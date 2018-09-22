<?php

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class UserRoleTableSeeder.
 */
class UserRoleTableSeeder extends Seeder
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

        User::findOrFail(1)->assignRole('administrator');
        User::findOrFail(2)->assignRole('manager');
        User::findOrFail(3)->assignRole('executive');
        User::findOrFail(4)->assignRole('user');

        $this->enableForeignKeys();
    }
}
