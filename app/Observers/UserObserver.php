<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function creating(User $user)
    {
        $user->created_by = Auth::id();
    }

    public function updating(User $user)
    {
        $user->updated_by = Auth::id();
    }

    public function saving(User $user)
    {
        $user->updated_by = Auth::id();
    }

    public function deleting(User $user)
    {
        $user->deleted_by = Auth::id();
        $user->save();
    }
}
