disqus-plugin
===========

Add Disqus Commenting to your October site.

```php
      $$\  $$\    $$$$$$$\                  $$\ $$\                      $$\     $$\      $$\           $$\       
     $$  |$$  |   $$  __$$\                 $$ |\__|                     $$ |    $$ | $\  $$ |          $$ |      
    $$  /$$  /$$\ $$ |  $$ | $$$$$$\   $$$$$$$ |$$\  $$$$$$\  $$$$$$$\ $$$$$$\   $$ |$$$\ $$ | $$$$$$\  $$$$$$$\  
   $$  /$$  / \__|$$$$$$$  | \____$$\ $$  __$$ |$$ | \____$$\ $$  __$$\\_$$  _|  $$ $$ $$\$$ |$$  __$$\ $$  __$$\ 
  $$  /$$  /      $$  __$$<  $$$$$$$ |$$ /  $$ |$$ | $$$$$$$ |$$ |  $$ | $$ |    $$$$  _$$$$ |$$$$$$$$ |$$ |  $$ |
 $$  /$$  /   $$\ $$ |  $$ |$$  __$$ |$$ |  $$ |$$ |$$  __$$ |$$ |  $$ | $$ |$$\ $$$  / \$$$ |$$   ____|$$ |  $$ |
$$  /$$  /    \__|$$ |  $$ |\$$$$$$$ |\$$$$$$$ |$$ |\$$$$$$$ |$$ |  $$ | \$$$$  |$$  /   \$$ |\$$$$$$$\ $$$$$$$  |
\__/ \__/         \__|  \__| \_______| \_______|\__| \_______|\__|  \__|  \____/ \__/     \__| \_______|\_______/ 
```


## Disqus Settings

You can add a Disqus site key to your /backend/disqus/settings area.

* click on system on your backend top nav bar 
* then click on 'Disqus' under 'Misc'
* go to http://diqus.com and login/create your account and add your site.
* copy your Disqus site key in your settings and save.

## Recent Comments component

You can output Recent Comments block on any page or partial by adding Recent Comments component there. 
Before using the component though, you have to register an application at Disqus and enter your public API key in component settings.

Besides API key, you can:

* set your website shortname in Disqus
* set max comment count to output
* limit comment's message length
* set up (or disable) maximum time comments are cached
