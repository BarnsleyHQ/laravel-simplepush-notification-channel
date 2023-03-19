<?php

namespace BarnsleyHQ\SimplePush\Tests\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class OtherAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $token,
        public $content = 'Test SimplePush Alert',
        public $title = 'Test Alert',
        public $event = 'test-event',
    ) {
        //
    }

    public function via(): string
    {
        return 'mail';
    }

    public function toMail()
    {
        return new Mailable();
    }
}
