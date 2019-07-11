<?php

use App\Models\User;
use Auth;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleTableSeeder extends Seeder
{
    Auth::loginUsingId(1);

    use DisableForeignKeys;

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        User::findOrFail(1)->assignRole('administrator');
        User::findOrFail(2)->assignRole('manager');
        User::findOrFail(3)->assignRole('executive');
        User::findOrFail(4)->assignRole('user');

        $this->enableForeignKeys();
    }
}
