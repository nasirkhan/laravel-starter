<?php

namespace Database\Seeders;

use Database\Seeders\Auth\PermissionRoleTableSeeder;
use Database\Seeders\Auth\UserRoleTableSeeder;
use Database\Seeders\Auth\UserTableSeeder;
use Illuminate\Database\Seeder;

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
        $this->call(UserTableSeeder::class);
        if (! app()->runningUnitTests()) {
            $this->command->info('Default Users Created.');
        }

        $this->call(PermissionRoleTableSeeder::class);
        if (! app()->runningUnitTests()) {
            $this->command->info('Default Permissions Created.');
        }

        $this->call(UserRoleTableSeeder::class);
        if (! app()->runningUnitTests()) {
            $this->command->info('Default Roles created and assigned to Users.');
        }

        // Single summary message for tests (only show during debugging)
        if (app()->runningUnitTests() && env('SHOW_TEST_SEEDING', false)) {
            $this->command->line('<fg=green>✓</fg=green> Auth seeding completed for test');
        }
    }
}
