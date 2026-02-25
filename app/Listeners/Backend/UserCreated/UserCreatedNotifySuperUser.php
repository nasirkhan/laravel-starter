<?php

namespace App\Listeners\Backend\UserCreated;

use App\Events\Backend\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedNotifySuperUser implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->user;
    }
}
