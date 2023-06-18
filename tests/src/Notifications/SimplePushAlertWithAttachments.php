<?php

namespace BarnsleyHQ\SimplePush\Tests\Notifications;

use BarnsleyHQ\SimplePush\Models\SimplePushMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SimplePushAlertWithAttachments extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $token,
        public $content = 'Test SimplePush Alert',
        public $title = 'Test Alert',
        public $event = 'test-event',
        public $attachments = null,
    ) {
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
            ->content($this->content)
            ->event($this->event)
            ->attachments($this->attachments);
    }
}
