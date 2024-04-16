<?php

namespace Database\Seeders\Auth;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        // Create Permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $permission) {
            $permission = Permission::make(['name' => $permission]);
            $permission->saveOrFail();
        }

        Artisan::call('auth:permission', [
            'name' => 'posts',
        ]);
        echo "\n _Posts_ Permissions Created.";

        Artisan::call('auth:permission', [
            'name' => 'categories',
        ]);
        echo "\n _Categories_ Permissions Created.";

        Artisan::call('auth:permission', [
            'name' => 'tags',
        ]);
        echo "\n _Tags_ Permissions Created.";

        Artisan::call('auth:permission', [
            'name' => 'comments',
        ]);
        echo "\n _Comments_ Permissions Created.";

        echo "\n\n";

        /**
         * Create Roles and Assign Permissions to Roles.
         */
        $super_admin = Role::create(['id' => '1', 'name' => 'super admin']);

        $admin = Role::create(['id' => '2', 'name' => 'administrator']);
        $admin->givePermissionTo(['view_backend', 'edit_settings']);

        $manager = Role::create(['id' => '3', 'name' => 'manager']);
        $manager->givePermissionTo('view_backend');

        $executive = Role::create(['id' => '4', 'name' => 'executive']);
        $executive->givePermissionTo('view_backend');

        $user = Role::create(['id' => '5', 'name' => 'user']);
    }
}
