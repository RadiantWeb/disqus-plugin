<?php namespace RadiantWeb\Disqus\Components;

use Cms\Classes\ComponentBase;
use Cache;
use League\Flysystem\Exception;

class RecentComments extends ComponentBase
{

    public $requestUrl = 'https://disqus.com/api/3.0/forums/listPosts.json';

    public function componentDetails()
    {
        return [
          'name'        => 'Recent Comments',
          'description' => 'Displays recent comments block from Disqus'
        ];
    }

    public function defineProperties()
    {
        return [
          'api_key' => [
            'title'             => 'Public API key',
            'description'       => 'Disqus application API key',
            'default'           => '',
            'type'              => 'string',
            'validationMessage' => 'Public API key is required for recent comments component to work',
            'required'          => TRUE,
          ],
          'forum' => [
            'title'             => 'Shortname',
            'description'       => 'Shortname for your site in Disqus system',
            'default'           => '',
            'type'              => 'string',
            'validationMessage' => 'Shortname is required for recent comments component to work',
            'required'          => TRUE,
          ],
          'limit' => [
            'title'             => 'Comments limit',
            'description'       => 'Limit comments loaded by number given',
            'default'           => 10,
            'type'              => 'string',
            'validationMessage' => 'Limit must be a number',
            'validationPattern' => '^[0-9]+$',
            'required'          => FALSE,
          ],
          'message_limit' => [
            'title'             => 'Message length limit',
            'description'       => 'Limits message string to given length. Set 0 to unlimited',
            'default'           => 200,
            'type'              => 'string',
            'validationMessage' => 'Message length must be a number',
            'validationPattern' => '^[0-9]+$',
            'required'          => FALSE,
          ],
          'cache_lifetime' => [
            'title'             => 'Cache Lifetime',
            'description'       => 'Number of minutes comments are stored in cache',
            'default'           => 0,
            'type'              => 'string',
            'validationMessage' => 'Cache lifetime must be a number',
            'validationPattern' => '^[0-9]+$',
            'required'          => FALSE,
          ],
        ];
    }


    /**
     *
     * Returns message length limit set in this component's settings
     *
     * @return string
     */
    public function message_limit() {
        return $this->property('message_limit');
    }


    /**
     *
     * Returns array of recent comment data prepared for output
     * Checks in cache (if enabled), loads from Disqus if unavailable
     *
     * @return array
     */
    public function comments() {
        $comments = [];
        if ($this->property('cache_lifetime')) {
            $comments = Cache::get('disqus_recent_comments');
        }

        //if not cached, try to load
        if (empty($comments)) {
            $comments = $this->getComments();
        }

        return $comments;
    }


    /**
     *
     * Loads and prepares comments for output
     *
     * @return array
     */
    protected function getComments() {
        $response = $this->loadComments($this->property('api_key'), $this->property('forum'), $this->property('limit'));

        if (!$response || empty($response->response)) {
            return [];
        }

        // Process results
        $comments = [];
        foreach ($response->response as $comment) {
            $comments[] = [
              'author' => $comment->author->name,
              'picture' => $comment->author->avatar->permalink,
              'message' => $comment->message,
              'thread_name' => $comment->thread->clean_title,
              'thread_url' => $comment->thread->link,
              'created' => $comment->createdAt
            ];
        }

        //store in cache (if enabled)
        $cache = $this->property('cache_lifetime');
        if ($cache) {
            Cache::put('disqus_recent_comments', $comments, $cache);
        }

        return $comments;
    }


    /**
     *
     * Performs request to Disqus and returns recent comments parsed from JSON
     *
     * @param $key
     * @param $forum
     * @param $limit
     * @return array
     */
    protected function loadComments($key, $forum, $limit) {
        $url = $this->requestUrl
          . '?'
          . "api_key=$key"
          . "&related=thread"
          . "&forum=$forum"
          . "&limit=$limit";

        //TODO maybe we should replace this later with a more sophisticated getter
        $json = @file_get_contents($url);
        return json_decode($json);
    }
}
