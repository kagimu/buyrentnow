<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserLastActivity implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(UserActivityChanged $event)
    {
        $user = $event->user;

        // Update the user's last_activity field
        $user->last_activity = now();
        $user->save();
    }
}
