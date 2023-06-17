<?php

use BarnsleyHQ\SimplePush\Channels\SimplePushChannel;
use BarnsleyHQ\SimplePush\Exceptions\MissingToSimplePushMethodException;
use BarnsleyHQ\SimplePush\Tests\Notifications\SimplePushAlert;
use BarnsleyHQ\SimplePush\Tests\Models\User;
use BarnsleyHQ\SimplePush\Tests\Notifications\OtherAlert;
use BarnsleyHQ\SimplePush\Tests\Notifications\SimplePushAlertWithActions;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
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
        'key'     => '123456',
        'title'   => 'Test Alert',
        'msg'     => 'Test SimplePush Alert',
        'event'   => 'test-event',
        'actions' => null,
    ]);
});

it('should send message with actions', function () {
    $user = new User();

    (new SimplePushChannel($this->http))
        ->send($user, new SimplePushAlertWithActions('123456'));

    expect($this->httpMockHandler->getLastRequest()->getUri()->getPath())->toBe('/send');
    expect(json_decode($this->httpMockHandler->getLastRequest()->getBody()->getContents(), true))->toBe([
        'key'     => '123456',
        'title'   => 'Test Alert',
        'msg'     => 'Test SimplePush Alert',
        'event'   => 'test-event',
        'actions' => ['Test Action'],
    ]);
});

it('should call feedback actions callback', function () {
    $user = new User();

    $alertFeedbackId = null;

    $httpMockHandler = new MockHandler([
        new Response(200, [], json_encode([
            'feedbackId' => 'test-feedback-id',
        ])),
    ]);

    $handlerStack = HandlerStack::create($httpMockHandler);

    $http = new Client(['handler' => $handlerStack]);

    (new SimplePushChannel($http))
        ->send($user, new SimplePushAlertWithActions(
            token: '123456',
            actionsCallback: function ($feedbackId) use (&$alertFeedbackId) {
                $alertFeedbackId = $feedbackId;
            },
        ));

    expect($alertFeedbackId)->toBe('test-feedback-id');
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

it('should throw an exception if notification cannot send to simplepush', function () {
    $user = new User();
    $instance = (new SimplePushChannel($this->http));

    expect(fn () => $instance->send($user, new OtherAlert('123456', '')))->toThrow(MissingToSimplePushMethodException::class);
});
