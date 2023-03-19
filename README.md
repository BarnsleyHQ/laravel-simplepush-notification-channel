# Laravel SimplePush Notification Channel

[![codecov](https://codecov.io/gh/BarnsleyHQ/laravel-simplepush-notifications-channel/branch/main/graph/badge.svg?token=QDM2JgtrfN)](https://codecov.io/gh/BarnsleyHQ/laravel-simplepush-notifications-channel)

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

That should be everything you need to get up and running!

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
