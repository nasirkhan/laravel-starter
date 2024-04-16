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

        $users = [
            [
                'id' => 1,
                'username' => '100001',
                'name' => 'Super Admin',
                'email' => 'super@admin.com',
                'password' => Hash::make('secret'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'username' => '100002',
                'name' => 'Admin Istrator',
                'email' => 'admin@admin.com',
                'password' => Hash::make('secret'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'username' => '100003',
                'name' => 'Manager User',
                'email' => 'manager@manager.com',
                'password' => Hash::make('secret'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'username' => '100004',
                'name' => 'Executive User',
                'email' => 'executive@executive.com',
                'password' => Hash::make('secret'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'username' => '100005',
                'name' => 'General User',
                'email' => 'user@user.com',
                'password' => Hash::make('secret'),
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
