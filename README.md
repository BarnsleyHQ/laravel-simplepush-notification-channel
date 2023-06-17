# Laravel SimplePush Notification Channel

[![Latest Stable Version](http://poser.pugx.org/barnsleyhq/laravel-simplepush-notification-channel/v)](https://packagist.org/packages/barnsleyhq/laravel-simplepush-notification-channel) [![PHP Version Require](http://poser.pugx.org/barnsleyhq/laravel-simplepush-notification-channel/require/php)](https://packagist.org/packages/barnsleyhq/laravel-simplepush-notification-channel) [![License](http://poser.pugx.org/barnsleyhq/laravel-simplepush-notification-channel/license)](https://packagist.org/packages/barnsleyhq/laravel-simplepush-notification-channel) [![codecov](https://codecov.io/gh/BarnsleyHQ/laravel-simplepush-notifications-channel/branch/main/graph/badge.svg?token=QDM2JgtrfN)](https://codecov.io/gh/BarnsleyHQ/laravel-simplepush-notifications-channel)


This package gives you all the basic elements you need to send notifications to notifiable models via SimplePush.

## Setup

Install the package using composer:

```bash
composer require barnsleyhq/laravel-simplepush-notifications-channel
```

## Laravel Usage

Once installed, all you need to do is setup your notifications to send to the SimplePush channel:

```php
<?php

use BarnsleyHQ\SimplePush\Models\SimplePushMessage;

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

## API

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

##### actions(FeedbackActions|GetActions): SimplePushMessage

Actions to be sent along with the event.

**Feedback Actions Example:**

```php
$message = (new SimplePushMessage())
    ->actions(FeedbackActions::make('Pause events for 1 hour'));

$actions = FeedbackActions::make([
    'Pause events for 1 hour',
    'Pause events for 2 hours',
]);
$actions->add('Pause events for 3 hours');

$message = new SimplePushMessage();
$message->actions($actions);
```

**GET Actions Example:**

```php
$message = (new SimplePushMessage())
    ->actions(GetActions::make(GetAction::make('Pause events for 1 hour', 'https://my-url.com/pause?hours=1')));

$actions = GetActions::make([
    GetAction::make('Pause events for 1 hour', 'https://my-url.com/pause?hours=1'),
    GetAction::make('Pause events for 2 hours', 'https://my-url.com/pause?hours=2'),
]);
$actions->add(GetAction::make('Pause events for 3 hours', 'https://my-url.com/pause?hours=3'));

$message = new SimplePushMessage();
$message->actions($actions);
```

### Available Methods (FeedbackActions)

##### make(string|array $action, null|callable $sendCallback = null): FeedbackActions

Create new instance of FeedbackActions with an initial action.

**Example:**

```php
$actions = FeedbackActions::make('Action 1');
$actions = FeedbackActions::make('Action 1', fn ($feedbackId) => saveFeedbackId($feedbackId));
```

##### getFeedbackResponseForId(string $feedbackId, ?\GuzzleHttp\Client $httpClient): array|null

Check message for feedback response.

**Example:**

```php
FeedbackActions::getFeedbackResponseForId('5e885b1d33c547bbac78bda8cdaf7be7');
```

##### add(string|array $action): FeedbackActions

Add another action to an existing instance of FeedbackActions.

**Example:**

```php
$actions = FeedbackActions::make('Action 1')
    ->add('Action 2');

$actions = new FeedbackActions();
$actions->add([
    'Action 1',
    'Action 2',
]);
```

##### sendCallback(null|callable $sendCallback): FeedbackActions

Update callback to retrieve Feedback ID for an existing instance of FeedbackActions.

**Example:**

```php
$actions = FeedbackActions::make('Action 1')
    ->sendCallback(fn ($feedbackId) => saveFeedbackId($feedbackId));

$actions = new FeedbackActions();
$actions->sendCallback(function ($feedbackId) {
    $this->saveFeedbackId($feedbackId);
});
```

##### toArray: array

Return FeedbackAction options as an array.

**Example:**

```php
$actions = FeedbackActions::make('Action 1')
    ->toArray();

$actions = new FeedbackActions();
$actions->toArray();
```

### Available Methods (GetActions)

##### make(GetAction $action): GetActions

Create new instance of GetActions with an initial action.

**Example:**

```php
$actions = GetActions::make(GetAction::make('Action 1', 'https://my-url.com/action'));
```

##### add(GetAction|array $action): GetActions

Add another action to an existing instance of GetActions.

**Example:**

```php
$actions = GetActions::make(GetAction::make('Action 1', 'https://my-url.com/action'))
    ->add(GetAction::make('Action 2', 'https://my-url.com/action-2'));

$actions = new GetActions();
$actions->add([
    GetAction::make('Action 1', 'https://my-url.com/action'),
    GetAction::make('Action 2', 'https://my-url.com/action-2'),
]);
```

##### addAction(string $name, string $url): GetActions

Add another action, with just the required values, to an existing instance of GetActions.

**Example:**

```php
$actions = GetActions::make()
    ->addAction('Action 1', 'https://my-url.com/action');

$actions->addAction('Action 1', 'https://my-url.com/action');
```

##### toArray: array

Return GetActions options as an array.

**Example:**

```php
$actions = GetActions::make(GetAction::make('Action 1', 'https://my-url.com/action'))
    ->toArray();

$actions = new GetActions();
$actions->toArray();
```

### Available Methods (GetAction)

##### make(string $name, string $url): GetAction

Create new instance of GetAction with initial values.

**Example:**

```php
$actions = GetAction::make('Action 1', 'https://my-url.com/action');
```

##### setName(string $name): GetAction

Set the name of the action.

**Example:**

```php
$actions = GetAction::make('Action 1', 'https://my-url.com/action')
    ->setName('Renamed Action')
    ->setUrl('https://my-url.com/renamed-action');

$actions = new GetAction();
$actions->setName('Action 1')
    ->setUrl('https://my-url.com/action');
```

##### setUrl(string $url): GetAction

Set the URL for the action.

**Example:**

```php
$actions = GetAction::make()
    ->addAction('Action 1', 'https://my-url.com/action');

$actions->addAction('Action 1', 'https://my-url.com/action');
```

##### toArray: array

Return GetAction options as an array.

**Example:**

```php
$actions = GetAction::make('Action 1', 'https://my-url.com/action')
    ->setName('Renamed Action')
    ->setUrl('https://my-url.com/renamed-action')
    ->toArray();

$actions = new GetAction();
$actions->setName('Action 1')
    ->setUrl('https://my-url.com/action')
    ->toArray();
```

## Base PHP Usage

While this is built for Laravel, it's possible to use without.

```php
<?php

use BarnsleyHQ\SimplePush\Models\GetAction;
use BarnsleyHQ\SimplePush\Models\GetActions;
use BarnsleyHQ\SimplePush\Models\SimplePushMessage;

(new SimplePushMessage)
    ->token('123456')
    ->title('Custom Alert')
    ->content('You have a new alert!')
    ->event('Custom Event')
    ->actions(GetActions::make([
        GetAction::make('Pause for 1 hour', 'https://webhooks.my-url.com/pause?hours=1'),
        GetAction::make('Pause for 24 hours', 'https://webhooks.my-url.com/pause?hours=24'),
    ]))
    ->send();
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
