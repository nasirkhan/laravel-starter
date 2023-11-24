<?php

namespace App\Listeners\Frontend\UserRegistered;

use App\Events\Frontend\UserRegistered;
use App\Models\Userprofile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class UserRegisteredProfileCreate implements ShouldQueue
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
    public function handle(UserRegistered $event)
    {
        $user = $event->user;

        $userprofile = new Userprofile();
        $userprofile->user_id = $user->id;
        $userprofile->name = $user->name;
        $userprofile->first_name = $user->first_name;
        $userprofile->last_name = $user->last_name;
        $userprofile->username = $user->username;
        $userprofile->email = $user->email;
        $userprofile->mobile = $user->mobile;
        $userprofile->gender = $user->gender;
        $userprofile->date_of_birth = $user->date_of_birth;
        $userprofile->avatar = $user->avatar;
        $userprofile->status = $user->status > 0 ? $user->status : 0;
        $userprofile->save();

        Log::debug('UserRegisteredProfileCreate:'.$user->name);

        // Clear Cache
        Artisan::call('cache:clear');
    }
}
