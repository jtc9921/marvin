# Marvin

## Introduction

Marvin is a user-friendly bot for [Slack](http://slack.com). Marvin takes its name from everyone's favorite Paranoid Android from  The Hitchhiker's Guide to the Galaxy.

At the moment it works with an outgoing webhook and the Slack API.

## Setup

### Enable outgoing webhook
On the integrations page on the Slack website add a new outgoing webhook. Go to the webhook setting and choose `Any` for the channel. The trigger word is `marvin` or you pick a name yourself if you want your bot to have a different name. In the URL text area you specifiy the URL of a publicly accessible server where your bot will be running (e.g. `https://marvin.yoursite.com`).

### Get a Slack API token
The last thing you need to do is get an API token so you can communicate with the Slack API. Go to [https://api.slack.com](https://api.slack.com) and under the Authentication paragraph you can create a API token. Make sure you copy this token as you need it for the next step.

### Install Marvin
Clone the repository:

```
git clone git@github.com:the-marvin-bot/marvin.git
```

Install the dependencies:

```
composer update
```

### Webserver config
The Slack API token should be set as an environment variable on your system. The easiest way is to set them in your virtual host config.

#### Apache
```
<VirtualHost *:80>
        ServerName marvin.yourdomain.com

        DocumentRoot /var/www/marvin.yourdomain.com/public

        SetEnv SLACK_TOKEN "xoxp-XXXXXXXXXX-XXXXXXXXXX-XXXXXXXXXX-XXXXXX"
        SetEnv SLACK_ICON "http://marvin.yourdomain.com/marvin.png"

        <Directory />
                Options FollowSymLinks
                AllowOverride None
        </Directory>

        <Directory /var/www/marvin.yourdomain.com/public/>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
        </Directory>
</VirtualHost>
```

## Plugins
Marvin ships with a couple of plugins enabled by default. It's easy to enable new plugins or disable the ones you don't need. To enable a plugin you can type the following command from the root of the project:

```
php marvin plugin:enable
```

You will be prompted to enter the name of the plugin you want to enable and that's all there is to it.

To disable a plugin you use the following command:

```
php marvin plugin:disable
```

Marvin will show you a list of enabled plugins and you can pick the one you want to disable.

### Create your own plugin
Creating your own plugin is not as hard as you might think. First of all you start with the create plugin command:

```
php marvin plugin:create
```

You'll be asked to answer a few questions to setup your plugin. Once you've answered all the questions a `workbench` directory will be created in the root of your project. It contains a composer.json file and a stub class of your plugin. Say you created a plugin called `Weather` with the namespace `YourName\Marvin\Plugin` then your stub class will be `Weather.php` which can be found in the `workbench/src/YourName/Marvin/Plugin` directory.

Below is an example of what the stub looks like:


```php
<?php

namespace YourName\Marvin\Plugin;

use Marvin\Lib\BasePlugin;

class Weather extends BasePlugin
{
    public function trigger()
    {
        $this->trigger = 'YOUR_TRIGGER';
    }

    public function description()
    {
        $this->addDescriptionLine($this->trigger, 'YOUR_DESCRIPTION');
    }

    public function config()
    {
        //$this->addConfigVariable('KEY', 'VALUE');
    }

    public function execute($parameters)
    {
        return $this->reply('YOUR_REPLY');
    }
}
```

The `trigger`, `description` and `execute` functions are all required and are pretty self explanatory.

The `config` function is an optional function that you can use to specify configuration variables like username, password, API key, etc. that is needed by your plugin. If you decide to use config variables then a user who installs your plugin will have to run `php marvin config:publish` after enabling your plugin. This will create a folder with the name of your plugin in the `config` directory. Inside this directory is json file where the user can fill in the config variables.

Once you are happy with your plugin you probably want to put it in its own git repository. Well luckily we also thought of this! First of all you create your repo on github, bitbucket, etc. Then run the following command:

```
php marvin plugin:finish
```

This will ask you to supply the url to your git repo and a version number. Once your plugin is successfully commited you'll be asked if you want to remove the `workbench` directory.

### Submit your plugin to the Marvin plugin repository
Coming soon!


## Development

### Using PHP's built-in web server

For debugging purposes you can use PHP's built-in web server to serve up the application. Use the following command to start up Marvin:

```
php marvin serve
```

This is start the development server on http://localhost:8000. You can optionally pass a port:

```
php marvin serve --port=8765
```

To test if your development server is running you can use the following CURL command:

```
curl -X POST -d 'channel_name=general&text=marvin+laws&trigger_word=marvin' http://localhost:8000
```

This will post The Three Laws of Robotics in the #general channel of your Slack organisation. To test other commands just replace `text=marvin+laws` with the trigger for your plugin, e.g. `text=marvin+weather`.