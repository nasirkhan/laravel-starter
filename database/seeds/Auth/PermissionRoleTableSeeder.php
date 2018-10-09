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

        // Assign Permissions to Roles
        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo('view_backend');
        $executive->givePermissionTo('view_backend');

        $this->enableForeignKeys();
    }
}
