<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        // Clear any cache left over from a previous database (the file cache store
        // survives migrate:fresh). A stale roles_user_{id}_{lastUpdated} entry would
        // otherwise make Spatie's assignRole diff empty and skip the pivot INSERT.
        Artisan::call('cache:clear');

        $userRoles = [
            'super@admin.com' => 'super admin',
            'admin@admin.com' => 'administrator',
            'manager@manager.com' => 'manager',
            'executive@executive.com' => 'executive',
            'user@user.com' => 'user',
        ];

        foreach ($userRoles as $email => $role) {
            User::where('email', $email)->firstOrFail()->syncRoles($role);
        }

        Artisan::call('cache:clear');
    }
}
