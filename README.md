# Marvin

## Introduction

Marvin is a user-friendly bot for [Slack](http://slack.com). Marvin takes its name from everyone's favorite Paranoid Android from  The Hitchhiker's Guide to the Galaxy.

At the moment it works with an outgoing webhook and the Slack API.

## Setup

### Enable outgoing webhook
On the integrations page on the Slack website add a new outgoing webhook. Go to the webhook setting and choose `Any` for the channel. The trigger word is `marvin` or you pick a name yourself if you want your bot to have a different name. In the URL text area you specifiy the URL of a publicly accessible server where your bot will be running (e.g. `https://marvin.yoursite.com`).

### Get a Slack API token
The last thing you need to do is get an API token so you can communicate with the Slack API. Go to [https://api.slack.com](https://api.slack.com) and under the Authentication paragraph you can create a API token. Make sure you copy this token as you need it for the next step.

### Clone the repo
Clone the repository:

```
git clone git@github.com:the-marvin-bot/marvin.git
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

### Plugins
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
