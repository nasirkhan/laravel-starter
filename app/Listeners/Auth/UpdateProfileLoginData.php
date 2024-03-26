<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserLoginSuccess;
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
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(UserLoginSuccess $event): void
    {
        try {
            $user = $event->user;
            $request = $event->request;
            $user_profile = $user->userprofile;

            /*
             * Updating user profile data after successful login
             */
            $user_profile->last_login = Carbon::now();
            $user_profile->last_ip = $request->last_ip;
            $user_profile->login_count += 1;
            $user_profile->save();

            logger('User Login Success. Name: '.$user->name.' | Id: '.$user->id.' | Email: '.$user->email.' | Username: '.$user->username.' IP:'.$user_profile->last_ip.' | UpdateProfileLoginData');
        } catch (\Exception $e) {
            logger()->error($e);
        }
    }
}
