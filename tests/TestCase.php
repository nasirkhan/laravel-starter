<?php

namespace Tests;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create And Login as Super Admin.
     *
     * @return bool|mixed
     */
    protected function loginAsSuperAdmin()
    {
        // $super_admin = factory(User::class)->create();
        $super_admin = User::factory()->create();

        if ($super_admin_role = Role::whereName('super admin')->first()) {
            dd($super_admin_role);
        } else {
            $super_admin_role = Role::create(['name' => 'super admin']);
        }

        $super_admin->assignRole($super_admin_role);

        $this->actingAs($super_admin);

        return $super_admin;
    }

    /**
     * Create the admin role or return it if it already exists.
     *
     * @return mixed
     */
    protected function getAdminRole()
    {
        if ($role = Role::whereName('administrator')->first()) {
            return $role;
        }
        $adminRole = Role::create(['name' => 'administrator']);
        $adminRole->givePermissionTo(Permission::firstOrCreate(['name' => 'view_backend']));

        return $adminRole;
    }

    /**
     * Create an administrator.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    protected function createAdmin(array $attributes = [])
    {
        $adminRole = $this->getAdminRole();
        // $admin = factory(User::class)->create($attributes);
        $admin = User::factory()->create($attributes);
        $admin->assignRole($adminRole);

        return $admin;
    }

    /**
     * Login the given administrator or create the first if none supplied.
     *
     * @param bool $admin
     *
     * @return bool|mixed
     */
    protected function loginAsAdmin($admin = false)
    {
        if (!$admin) {
            $admin = $this->createAdmin();
        }
        $this->actingAs($admin);

        return $admin;
    }
}
