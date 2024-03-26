<?php

namespace Database\Seeders\Auth;

use App\Events\Backend\UserCreated;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Add the master administrator, user id of 1
        $users = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'super@admin.com',
                'password' => Hash::make('secretpassword'),
                'username' => '100001',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'first_name' => 'Admin',
                'last_name' => 'Istrator',
                'name' => 'Admin Istrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('secret'),
                'username' => '100002',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'first_name' => 'Manager',
                'last_name' => 'User User',
                'name' => 'Manager',
                'email' => 'manager@manager.com',
                'password' => Hash::make('secret'),
                'username' => '100003',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'first_name' => 'Executive',
                'last_name' => 'User',
                'name' => 'Executive User',
                'email' => 'executive@executive.com',
                'password' => Hash::make('secret'),
                'username' => '100004',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'first_name' => 'General',
                'last_name' => 'User',
                'name' => 'General User',
                'email' => 'user@user.com',
                'password' => Hash::make('secret'),
                'username' => '100005',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($users as $user_data) {
            $user = User::create($user_data);

            event(new UserCreated($user));
        }
    }
}
