<?php

namespace App\Livewire\Frontend\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ResendEmailConfirmation extends Component
{
    public function resend(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(401);
        }

        if ($user->hasVerifiedEmail()) {
            Session::flash('status', 'email-already-verified');

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    public function render()
    {
        return view('livewire.frontend.users.resend-email-confirmation');
    }
}
