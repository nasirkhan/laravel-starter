<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
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

        // Create Roles
        $admin = Role::create(['name' => 'administrator']);
        $manager = Role::create(['name' => 'manager']);
        $executive = Role::create(['name' => 'executive']);
        $user = Role::create(['name' => 'user']);

        // Create Permissions
        Permission::firstOrCreate(['name' => 'view_backend']);
        Permission::firstOrCreate(['name' => 'edit_settings']);
        Permission::firstOrCreate(['name' => 'view_logs']);

        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        \Artisan::call('auth:permission', [
            'name' => 'posts',
        ]);
        echo "\n _Posts_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'categories',
        ]);
        echo "\n _Categories_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'tags',
        ]);
        echo "\n _Tags_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'comments',
        ]);
        echo "\n _Comments_ Permissions Created.";

        \Artisan::call('auth:permission', [
            'name' => 'newsletters',
        ]);
        echo "\n _Newsletters_ Permissions Created.";

        echo "\n\n";

        // Assign Permissions to Roles
        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo('view_backend');
        $executive->givePermissionTo('view_backend');

        $this->enableForeignKeys();
    }
}
