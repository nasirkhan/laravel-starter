<?php

namespace App\Listeners\Frontend\UserProfileUpdated;

use App\Events\Frontend\UserProfileUpdated;
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
        $user_profile = $event->user_profile;
    }
}
