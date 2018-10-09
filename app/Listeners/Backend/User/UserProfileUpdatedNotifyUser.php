<?php

namespace App\Listeners\Backend\User;

use App\Events\Backend\User\UserProfileUpdated;
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
        //
    }

    /**
     * Handle the event.
     *
     * @param UserProfileUpdated $event
     *
     * @return void
     */
    public function handle(UserProfileUpdated $event)
    {
        $user = $event->user_profile;
        //
    }
}
