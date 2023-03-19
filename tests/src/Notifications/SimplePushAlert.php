<?php

namespace BarnsleyHQ\SimplePush\Tests\Notifications;

use BarnsleyHQ\SimplePush\Contracts\SimplePushNotification;
use BarnsleyHQ\SimplePush\Messages\SimplePushMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SimplePushAlert extends Notification implements ShouldQueue, SimplePushNotification
{
    use Queueable;

    public function __construct(
        public $token,
        public $content = 'Test SimplePush Alert',
        public $title = 'Test Alert',
    )
    {
        //
    }

    public function via(): string
    {
        return 'simplepush';
    }

    public function toSimplePush($notifiable = null): SimplePushMessage
    {
        return (new SimplePushMessage)
            ->token($this->token)
            ->title($this->title)
            ->content($this->content);
    }
}
