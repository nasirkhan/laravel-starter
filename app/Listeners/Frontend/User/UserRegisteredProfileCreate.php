<?php

namespace App\Listeners\Frontend\User;

use App\Events\Frontend\User\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Userprofile;

class UserRegisteredProfileCreate implements ShouldQueue
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
     * @param UserRegistered $event
     *
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        $userprofile = new Userprofile();
        $userprofile->user_id = $user->id;
        $userprofile->name = $user->name;
        $userprofile->email = $user->email;
        $userprofile->mobile = $user->mobile;
        $userprofile->gender = $user->gender;
        $userprofile->date_of_birth = $user->date_of_birth;
        $userprofile->avatar = $user->avatar;
        $userprofile->status = ($user->status > 0) ? $user->status : 0;
        $userprofile->save();

        \Log::debug('UserRegisteredProfileCreate');
    }
}
