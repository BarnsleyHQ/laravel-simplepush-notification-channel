<?php

use BarnsleyHQ\SimplePush\Models\Actions\FeedbackActions;
use BarnsleyHQ\SimplePush\Models\Actions\GetAction;
use BarnsleyHQ\SimplePush\Models\Actions\GetActions;
use BarnsleyHQ\SimplePush\Models\SimplePushMessage;

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

it('should set actions', function () {
    $message = (new SimplePushMessage())
        ->actions(FeedbackActions::make('Test Action'));

    expect($message)->toBeInstanceOf(SimplePushMessage::class);
    expect($message->actions->toArray())->toBe(['Test Action']);
});

it('should return false if message has no actions', function () {
    $message = (new SimplePushMessage());

    expect($message->hasFeedbackActionsCallback())->toBeFalse();
});

it('should return false if message has actions with are not feedback', function () {
    $message = (new SimplePushMessage())
        ->actions(GetActions::make(GetAction::make('Test Action', 'https://test.com')));

    expect($message->hasFeedbackActionsCallback())->toBeFalse();
});

it('should return false if message has feedback actions without callback', function () {
    $message = (new SimplePushMessage())
        ->actions(FeedbackActions::make('Test Action'));

    expect($message->hasFeedbackActionsCallback())->toBeFalse();
});

it('should return true if message has feedback actions with callback', function () {
    $message = (new SimplePushMessage())
        ->actions(FeedbackActions::make('Test Action', fn () => true));

    expect($message->hasFeedbackActionsCallback())->toBeTrue();
});
