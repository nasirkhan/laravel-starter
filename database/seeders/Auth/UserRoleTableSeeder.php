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
        User::findOrFail(1)->assignRole('super admin');
        User::findOrFail(2)->assignRole('administrator');
        User::findOrFail(3)->assignRole('manager');
        User::findOrFail(4)->assignRole('executive');
        User::findOrFail(5)->assignRole('user');

        Artisan::call('cache:clear');
    }
}
