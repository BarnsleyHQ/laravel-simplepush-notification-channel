<?php

namespace BarnsleyHQ\SimplePush\Tests\Models;

use Illuminate\Notifications\Notifiable;

class User
{
    use Notifiable;

    public function getKey(): string
    {
        return 'id';
    }
}
