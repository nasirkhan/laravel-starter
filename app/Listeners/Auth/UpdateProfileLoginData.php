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
            try {
                $user_profile->last_login = Carbon::now();
                $user_profile->last_ip = ($request) ? $request->last_ip : "0.0.0.0";
                $user_profile->login_count += 1;
                $user_profile->save();
            } catch (\Throwable $th) {
                logger()->error($th);
            }

            logger('User Login Success. Name: '.$user->name.' | Id: '.$user->id.' | Email: '.$user->email.' | Username: '.$user->username.' IP:'.$user_profile->last_ip.' | UpdateProfileLoginData');
        } catch (\Exception $e) {
            logger()->error($e);
        }
    }
}
