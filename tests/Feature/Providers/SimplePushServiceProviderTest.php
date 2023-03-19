<?php

use BarnsleyHQ\SimplePush\Channels\SimplePushChannel;
use Illuminate\Support\Facades\Notification;

it('should create an instance', function () {
    expect(Notification::channel('simplepush'))->toBeInstanceOf(SimplePushChannel::class);
});
