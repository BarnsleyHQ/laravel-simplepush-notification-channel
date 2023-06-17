<?php

use BarnsleyHQ\SimplePush\Models\Actions\FeedbackActions;

it('should create an instance', function () {
    $actions = new FeedbackActions();

    expect($actions)->toBeInstanceOf(FeedbackActions::class);
});

it('should load in actions from string', function () {
    $actions = FeedbackActions::make('Test Action');

    expect($actions->options)->toBe(['Test Action']);
});

it('should load in actions from array', function () {
    $actions = FeedbackActions::make(['Test Action']);

    expect($actions->options)->toBe(['Test Action']);
});

it('should set send callback', function () {
    $method = fn () => true;
    $actions = FeedbackActions::make(['Test Action'], $method);

    expect($actions->options)->toBe(['Test Action']);
    expect($actions->sendCallback)->toBe($method);
});

it('should not load in actions of invalid type', function () {
    $actions = FeedbackActions::make([123]);

    expect($actions->options)->toBe([]);
});

it('should add in actions for existing instance', function () {
    $actions = FeedbackActions::make('Test Action');
    $actions->add('Another Action');
    $actions->add([
        'Third Action',
        'Fourth Action',
    ]);

    expect($actions->options)->toBe([
        'Test Action',
        'Another Action',
        'Third Action',
        'Fourth Action',
    ]);
});

it('should set send callback to existing instance', function () {
    $method = fn () => true;
    $actions = FeedbackActions::make(['Test Action']);

    $actions->sendCallback($method);
    expect($actions->sendCallback)->toBe($method);
});
