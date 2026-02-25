<?php

namespace App\Listeners\Backend\UserUpdated;

use App\Events\Backend\UserUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserUpdatedNotifyUser implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        $user = $event->user;
    }
}
