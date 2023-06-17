<?php

use BarnsleyHQ\SimplePush\Exceptions\InvalidGetActionUrl;
use BarnsleyHQ\SimplePush\Models\Actions\GetAction;

it('should create an instance', function () {
    $actions = new GetAction();

    expect($actions)->toBeInstanceOf(GetAction::class);
});

it('should create action with data', function () {
    $action = GetAction::make('Test Action', 'https://test.com');

    expect($action->name)->toBe('Test Action');
    expect($action->url)->toBe('https://test.com');
});

it('should throw exception if invalid url', function () {
    GetAction::make('Test Action', 'ftp://test.com');
})->throws(InvalidGetActionUrl::class);

it('should throw exception if invalid property is accessed', function () {
    $action = GetAction::make('Test Action', 'http://test.com');

    expect($action->test)->toBe('Test Action');
})->throws(\Exception::class);

it('should throw exception if property does not exist when setting', function () {
    $action = GetAction::make('Test Action', 'http://test.com');

    $action->test = true;
})->throws(\Exception::class);

it('should validate url if set via property', function () {
    $action = new GetAction();

    $action->url = 'ftp://test.com';
})->throws(InvalidGetActionUrl::class);

it('should flatten action to array', function () {
    $action = GetAction::make('Test Action', 'https://test.com');

    expect($action->toArray())->toBe([
        'name' => 'Test Action',
        'url'  => 'https://test.com',
    ]);
});
