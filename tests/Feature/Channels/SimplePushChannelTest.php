<?php

use BarnsleyHQ\SimplePush\Channels\SimplePushChannel;
use BarnsleyHQ\SimplePush\Tests\Notifications\SimplePushAlert;
use BarnsleyHQ\SimplePush\Tests\Models\User;

it('should send message using token from message', function () {
    $user = new User();

    (new SimplePushChannel($this->http))
        ->send($user, new SimplePushAlert('test-token'));

    expect($this->httpMockHandler->getLastRequest()->getUri()->getPath())->toBe('/send/test-token/Test%20Alert/Test%20SimplePush%20Alert');
});

it('should do nothing if no token', function () {
    $user = new User();

    (new SimplePushChannel($this->http))
        ->send($user, new SimplePushAlert(''));

    expect($this->httpMockHandler->getLastRequest())->toBeNull();
});
