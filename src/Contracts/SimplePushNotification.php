<?php

namespace BarnsleyHQ\SimplePush\Contracts;

use BarnsleyHQ\SimplePush\Messages\SimplePushMessage;

interface SimplePushNotification
{
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<string>
     */
    public function broadcastOn();

    /**
     * Set the locale to send this notification in.
     *
     * @param  string  $locale
     * @return $this
     */
    public function locale($locale);

    /**
     * Generate a SimplePush message.
     *
     * @param mixed|null $notifiable
     * @return SimplePushMessage
     */
    public function toSimplePush($notifiable = null): SimplePushMessage;

    /**
     * Get the methods with which to send the notification.
     *
     * @return string|array<string>
     */
    public function via(): string | array;
}
