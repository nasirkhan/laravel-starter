<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

/**
 * Class AuthTableSeeder.
 */
class AuthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        $this->call(UserTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
