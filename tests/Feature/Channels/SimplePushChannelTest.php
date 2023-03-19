<?php

use BarnsleyHQ\SimplePush\Channels\SimplePushChannel;
use BarnsleyHQ\SimplePush\Tests\Notifications\SimplePushAlert;
use BarnsleyHQ\SimplePush\Tests\Models\User;
use Illuminate\Support\Facades\Notification;

it('should send message to notifiable', function () {
    Notification::fake();

    $user = new User();
    $alert = new SimplePushAlert('123456');

    $user->notify($alert);

    Notification::assertSentTimes(SimplePushAlert::class, 1);
    Notification::assertSentTo($user, SimplePushAlert::class, function ($notification) use ($alert) {
        return $notification->token === $alert->token;
    });
});

it('should send message using token from message', function () {
    $user = new User();

    (new SimplePushChannel($this->http))
        ->send($user, new SimplePushAlert('123456'));

    expect($this->httpMockHandler->getLastRequest()->getUri()->getPath())->toBe('/send');
    expect(json_decode($this->httpMockHandler->getLastRequest()->getBody()->getContents(), true))->toBe([
        'key'   => '123456',
        'title' => 'Test Alert',
        'msg'   => 'Test SimplePush Alert',
    ]);
});

it('should throw an exception if missing or invalid token', function ($token) {
    $user = new User();
    $instance = (new SimplePushChannel($this->http));

    expect(fn () => $instance->send($user, new SimplePushAlert($token)))->toThrow('Missing SimplePush data: token');

    expect($this->httpMockHandler->getLastRequest())->toBeNull();
})->with([
    '',
    'long token',
    '1234',
    '1234$',
]);

it('should throw an exception if missing content', function () {
    $user = new User();
    $instance = (new SimplePushChannel($this->http));

    expect(fn () => $instance->send($user, new SimplePushAlert('123456', '')))->toThrow('Missing SimplePush data: content');
});

it('should throw an exception if missing both token and content', function ($token, $content) {
    $user = new User();
    $instance = (new SimplePushChannel($this->http));

    expect(fn () => $instance->send($user, new SimplePushAlert($token, $content)))->toThrow('Missing SimplePush data: content, token');
})->with([
    ['', ''],
    ['long token', ''],
    ['1234', ''],
    ['1234$', ''],
]);
