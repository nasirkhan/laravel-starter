<?php

namespace App\Listeners\Backend\User;

use App\Events\Backend\User\UserUpdated;
use App\Models\Userprofile;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserUpdatedProfileUpdate implements ShouldQueue
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

        $userprofile = Userprofile::where('user_id', '=', $user->id)->first();
        $userprofile->name = $user->name;
        $userprofile->email = $user->email;
        $userprofile->mobile = $user->mobile;
        $userprofile->gender = $user->gender;
        $userprofile->date_of_birth = $user->date_of_birth;
        $userprofile->avatar = $user->avatar;
        $userprofile->status = $user->status;
        $userprofile->updated_at = $user->updated_at;
        $userprofile->updated_by = $user->updated_by;
        $userprofile->deleted_at = $user->deleted_at;
        $userprofile->deleted_by = $user->deleted_by;
        $userprofile->save();
    }
}
