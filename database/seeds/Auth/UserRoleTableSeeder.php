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

        User::find(1)->assignRole('administrator');
        User::find(2)->assignRole('manager');
        User::find(3)->assignRole('executive');
        User::find(4)->assignRole('user');

        $this->enableForeignKeys();
    }
}
