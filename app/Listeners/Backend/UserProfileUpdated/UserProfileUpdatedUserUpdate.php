<?php

namespace App\Listeners\Backend\UserProfileUpdated;

use App\Events\Backend\UserProfileUpdated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;

class UserProfileUpdatedUserUpdate implements ShouldQueue
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

        $user = User::where('id', '=', $user_profile->user_id)->first();
        $user->name = $user_profile->name;
        $user->first_name = $user_profile->first_name;
        $user->last_name = $user_profile->last_name;
        $user->username = $user_profile->username;
        $user->email = $user_profile->email;
        $user->mobile = $user_profile->mobile;
        $user->gender = $user_profile->gender;
        $user->date_of_birth = $user_profile->date_of_birth;
        $user->gender = $user_profile->gender;
        $user->save();

        // Clear Cache
        Artisan::call('cache:clear');
    }
}
