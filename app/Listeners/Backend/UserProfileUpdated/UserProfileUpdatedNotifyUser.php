<?php

namespace App\Listeners\Backend\UserProfileUpdated;

use App\Events\Backend\UserProfileUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserProfileUpdatedNotifyUser implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(UserProfileUpdated $event)
    {
        $user = $event->user_profile;
    }
}
