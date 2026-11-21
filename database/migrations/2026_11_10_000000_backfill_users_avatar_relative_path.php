<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Rewrite every stored absolute avatar URL to a host-relative path so a
     * domain change never invalidates existing rows. Only rows whose avatar is
     * a non-empty absolute URL (contains '://') are touched, and updateQuietly
     * keeps timestamps and model events untouched.
     */
    public function up(): void
    {
        User::withTrashed()
            ->whereNotNull('avatar')
            ->where('avatar', '!=', '')
            ->where('avatar', 'like', '%://%')
            ->get()
            ->each(function (User $user) {
                $user->updateQuietly(['avatar' => User::imagePathFromUrl($user->avatar)]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: the original absolute URLs cannot be reconstructed.
    }
};
