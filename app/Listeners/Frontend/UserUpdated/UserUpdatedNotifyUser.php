<?php

namespace App\Listeners\Frontend\UserUpdated;

use App\Events\Frontend\UserUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserUpdatedNotifyUser implements ShouldQueue
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
     * @param UserUpdated $event
     *
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        $user = $event->user;
    }
}
