<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserLoginSuccess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;

class UpdateProfileLoginData
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
     * @param  UserLoginSuccess  $event
     * @return void
     */
    public function handle(UserLoginSuccess $event)
    {
        $user = $event->user;
        $request = $event->request;
        $user_profile = $user->userprofile;

        /**
         * Updating user profile data after successful login
         */
        $user_profile->last_login = Carbon::now();
        $user_profile->last_ip = $request->getClientIp();
        $user_profile->login_count = $user_profile->login_count+1;
        $user_profile->save();
    }
}
