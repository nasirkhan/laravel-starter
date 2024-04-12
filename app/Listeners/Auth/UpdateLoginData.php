<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserLoginSuccess;
use Carbon\Carbon;

class UpdateLoginData
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
        $user = $event->user;
        $request = $event->request;

        $user->last_login = Carbon::now();
        $user->last_ip = ($request) ? $request['last_ip'] : '0.0.0.0';
        $user->login_count += 1;

        $user->save();

        logger('User Login Success. Name: '.$user->name.' | Id: '.$user->id.' | Email: '.$user->email.' | Username: '.$user->username.' IP:'.$user->last_ip.' | UpdateLoginData');
    }
}
