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
        // Create Roles
        $super_admin = Role::create(['id' => '1', 'name' => 'super admin']);
        $admin = Role::create(['id' => '2', 'name' => 'administrator']);
        $manager = Role::create(['id' => '3', 'name' => 'manager']);
        $executive = Role::create(['id' => '4', 'name' => 'executive']);
        $user = Role::create(['id' => '5', 'name' => 'user']);

        // Create Permissions
        Permission::firstOrCreate(['name' => 'view_backend']);

        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
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

        // Assign Permissions to Roles
        $admin->givePermissionTo('view_backend');
        $manager->givePermissionTo('view_backend');
        $executive->givePermissionTo('view_backend');
    }
}
