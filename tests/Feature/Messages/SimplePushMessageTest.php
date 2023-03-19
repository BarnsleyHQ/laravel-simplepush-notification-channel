<?php

use BarnsleyHQ\SimplePush\Messages\SimplePushMessage;

it('should create an instance', function () {
    $message = new SimplePushMessage();

    expect($message)->toBeInstanceOf(SimplePushMessage::class);
});

it('should set the token', function () {
    $message = (new SimplePushMessage())
        ->token('test-token');

    expect($message)->toBeInstanceOf(SimplePushMessage::class);
    expect($message->token)->toBe('test-token');
});

it('should set the title', function () {
    $message = (new SimplePushMessage())
        ->title('test-title');

    expect($message)->toBeInstanceOf(SimplePushMessage::class);
    expect($message->title)->toBe('test-title');
});

it('should set the content', function () {
    $message = (new SimplePushMessage())
        ->content('test-content');

    expect($message)->toBeInstanceOf(SimplePushMessage::class);
    expect($message->content)->toBe('test-content');
});
