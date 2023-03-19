<?php

namespace BarnsleyHQ\SimplePush\Providers;

use BarnsleyHQ\SimplePush\Channels\SimplePushChannel;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;

class SimplePushServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('simplepush', function ($app) {
                return new SimplePushChannel($app->make(HttpClient::class));
            });
        });
    }
}
