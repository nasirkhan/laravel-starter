<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        // Add the master administrator, user id of 1
        $users = [
            [
                'name'              => 'Admin User',
                'email'             => 'admin@admin.com',
                'password'          => bcrypt('1234'),
                'Carbon::now()'     => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Manager User',
                'email'             => 'manager@manager.com',
                'password'          => bcrypt('1234'),
                'Carbon::now()'     => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'Executive User',
                'email'             => 'executive@executive.com',
                'password'          => bcrypt('1234'),
                'Carbon::now()'     => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'name'              => 'General User',
                'email'             => 'user@user.com',
                'password'          => bcrypt('1234'),
                'Carbon::now()'     => Carbon::now(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ];

        DB::table('users')->insert($users);

        $this->enableForeignKeys();
    }
}
