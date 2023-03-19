<?php

namespace BarnsleyHQ\SimplePush\Tests\Notifications;

use BarnsleyHQ\SimplePush\Channels\SimplePushChannel;
use BarnsleyHQ\SimplePush\Contracts\SimplePushNotification;
use BarnsleyHQ\SimplePush\Messages\SimplePushMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SimplePushAlert extends Notification implements ShouldQueue, SimplePushNotification
{
    use Queueable;

    public function __construct(public string $token)
    {
        //
    }

    public function via(): string
    {
        return 'simplepush';

        // return SimplePushChannel::class;
    }

    public function toSimplePush($notifiable = null): SimplePushMessage
    {
        return (new SimplePushMessage)
            ->token($this->token)
            ->title('Test Alert')
            ->content('Test SimplePush Alert');
    }
}
