# Laravel SimplePush Notification Channel

[![Latest Stable Version](http://poser.pugx.org/barnsleyhq/laravel-simplepush-notification-channel/v)](https://packagist.org/packages/barnsleyhq/laravel-simplepush-notification-channel) [![PHP Version Require](http://poser.pugx.org/barnsleyhq/laravel-simplepush-notification-channel/require/php)](https://packagist.org/packages/barnsleyhq/laravel-simplepush-notification-channel) [![License](http://poser.pugx.org/barnsleyhq/laravel-simplepush-notification-channel/license)](https://packagist.org/packages/barnsleyhq/laravel-simplepush-notification-channel) [![codecov](https://codecov.io/gh/BarnsleyHQ/laravel-simplepush-notifications-channel/branch/main/graph/badge.svg?token=QDM2JgtrfN)](https://codecov.io/gh/BarnsleyHQ/laravel-simplepush-notifications-channel)


This package gives you all the basic elements you need to send notifications to notifiable models via SimplePush.

## Setup

Install the package using composer:

```bash
composer require barnsleyhq/laravel-simplepush-notifications-channel
```

## Usage

Once installed, all you need to do is setup your notifications to send to the SimplePush channel:

```php
<?php

use BarnsleyHQ\SimplePush\SimplePushMessage;

...

class CustomAlert
{
    ...

    public function via($notifiable)
    {
        $channels = [];

        ...

        $channels[] = 'simplepush';

        return $channels;
    }

    public function toSimplePush($notifiable): SimplePushMessage
    {
        return (new SimplePushMessage)
            ->token($notifiable->tokens->simplepush) // Change this line to get the token
            ->title('Custom Alert')
            ->content('You have a new alert!');
    }

    ...

}
```

### Available Methods (SimplePushMessage)

#### Required

##### token(string): SimplePushMessage

The token to be used when sending the notification.

**Example:**

```php
$message = (new SimplePushMessage())
    ->token('test-token');

$message = new SimplePushMessage();
$message->token('test-token');
```

##### content(string): SimplePushMessage

The message content to be included in the notification.

**Example:**

```php
$message = (new SimplePushMessage())
    ->content('This is a Test Alert');

$message = new SimplePushMessage();
$message->content('This is a Test Alert');
```

#### Optional

##### title(string): SimplePushMessage

The title of the notification.

**Example:**

```php
$message = (new SimplePushMessage())
    ->title('Test Alert');

$message = new SimplePushMessage();
$message->title('Test Alert');
```

##### event(string): SimplePushMessage

An event to trigger once the notification is sent.

**Example:**

```php
$message = (new SimplePushMessage())
    ->event('test-event');

$message = new SimplePushMessage();
$message->event('test-event');
```

## Testing

For basic testing, run:

```bash
$ composer test
```

Or for testing code coverage:

```bash
$ composer test:coverage
```

## Security

If you discover any security vulnerabilities, please email alex@barnsley.io instead of submitting an issue.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
