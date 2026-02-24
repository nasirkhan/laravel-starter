<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

new class extends Component
{
    public function resend(): void
    {
        $user = Auth::user();

        if (! $user instanceof User) {
            abort(401);
        }

        // Check if email is already verified
        if ($user->email_verified_at !== null) {
            Log::info($user->name.' ('.$user->id.') - User requested but email already verified at '.$user->email_verified_at);

            flash(
                $user->name.', You already confirmed your email address at '.$user->email_verified_at->isoFormat('LL')
            )->success()->important();

            return;
        }

        Log::info($user->name.' ('.$user->id.') - User requested for email verification.');

        // Send Email Verification Notification
        $user->sendEmailVerificationNotification();

        flash('Email Sent! Please Check Your Inbox.')->success()->important();
    }
};
