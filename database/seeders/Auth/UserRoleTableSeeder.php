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
