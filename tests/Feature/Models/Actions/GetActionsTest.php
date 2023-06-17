<?php

use BarnsleyHQ\SimplePush\Models\Actions\GetAction;
use BarnsleyHQ\SimplePush\Models\Actions\GetActions;

it('should create an instance', function () {
    $actions = new GetActions();

    expect($actions)->toBeInstanceOf(GetActions::class);
});

it('should load in actions from object', function () {
    $actions = GetActions::make(GetAction::make('Test Action', 'https://test.com'));

    expect($actions->options)->toHaveCount(1);
    expect($actions->options[0]->name)->toBe('Test Action');
    expect($actions->options[0]->url)->toBe('https://test.com');
});

it('should load in actions from array', function () {
    $actions = GetActions::make([
        GetAction::make('Test Action', 'https://test.com'),
        GetAction::make('Another Action', 'https://another.com'),
    ]);

    expect($actions->options)->toHaveCount(2);
    expect($actions->options[0]->name)->toBe('Test Action');
    expect($actions->options[0]->url)->toBe('https://test.com');
    expect($actions->options[1]->name)->toBe('Another Action');
    expect($actions->options[1]->url)->toBe('https://another.com');
});

it('should not load in actions of invalid type', function () {
    $actions = GetActions::make([123]);

    expect($actions->options)->toHaveCount(0);
    expect($actions->options)->toBe([]);
});

it('should add in actions for existing instance', function () {
    $actions = GetActions::make(GetAction::make('Test Action', 'https://test.com'));
    $actions->add(GetAction::make('Another Action', 'https://another.com'));
    $actions->add([
        GetAction::make('Third Action', 'https://third.com'),
        GetAction::make('Fourth Action', 'https://fourth.com'),
    ]);
    $actions->addAction('Fifth Action', 'https://fifth.com');

    expect($actions->options)->toHaveCount(5);
    expect($actions->options[0]->name)->toBe('Test Action');
    expect($actions->options[0]->url)->toBe('https://test.com');
    expect($actions->options[1]->name)->toBe('Another Action');
    expect($actions->options[1]->url)->toBe('https://another.com');
    expect($actions->options[2]->name)->toBe('Third Action');
    expect($actions->options[2]->url)->toBe('https://third.com');
    expect($actions->options[3]->name)->toBe('Fourth Action');
    expect($actions->options[3]->url)->toBe('https://fourth.com');
    expect($actions->options[4]->name)->toBe('Fifth Action');
    expect($actions->options[4]->url)->toBe('https://fifth.com');
});

it('should flatten options to array', function () {
    $actions = GetActions::make([
        GetAction::make('Test Action', 'https://test.com'),
        GetAction::make('Another Action', 'https://another.com'),
    ])->toArray();

    expect($actions)->toHaveCount(2);
    expect($actions)->toBe([
        [
            'name' => 'Test Action',
            'url'  => 'https://test.com',
        ],
        [
            'name' => 'Another Action',
            'url'  => 'https://another.com',
        ],
    ]);
});
