<?php

use App\Events\Backend\User\UserCreated;
use App\Models\User;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $faker = Faker\Factory::create();

        // Add the master administrator, user id of 1
        $users = [
            [
                'name'              => 'Admin User',
                'email'             => 'admin@admin.com',
                'password'          => '1234',
                'mobile'            => $faker->phoneNumber,
                'date_of_birth'     => $faker->date,
                'avatar'            => 'img/1000px-blue-cube-logo.jpg',
                'gender'            => $faker->randomElement(['Man', 'Woman', 'Other']),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed_at'      => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Manager User',
                'email'             => 'manager@manager.com',
                'password'          => '1234',
                'mobile'            => $faker->phoneNumber,
                'date_of_birth'     => $faker->date,
                'avatar'            => 'img/1000px-blue-cube-logo.jpg',
                'gender'            => $faker->randomElement(['Man', 'Woman', 'Other']),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed_at'      => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Executive User',
                'email'             => 'executive@executive.com',
                'password'          => '1234',
                'mobile'            => $faker->phoneNumber,
                'date_of_birth'     => $faker->date,
                'avatar'            => 'img/1000px-blue-cube-logo.jpg',
                'gender'            => $faker->randomElement(['Man', 'Woman', 'Other']),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed_at'      => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'General User',
                'email'             => 'user@user.com',
                'password'          => '1234',
                'mobile'            => $faker->phoneNumber,
                'date_of_birth'     => $faker->date,
                'avatar'            => 'img/1000px-blue-cube-logo.jpg',
                'gender'            => $faker->randomElement(['Man', 'Woman', 'Other']),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed_at'      => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];

        foreach ($users as $user_data) {
            $user = User::create($user_data);

            event(new UserCreated($user));
        }

        $this->enableForeignKeys();
    }
}
