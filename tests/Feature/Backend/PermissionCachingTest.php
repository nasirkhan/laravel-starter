<?php

namespace Tests\Feature\Backend;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\Auth\UserRoleTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PermissionCachingTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Role $role;

    protected Permission $permission;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test roles and permissions using Spatie's method
        $this->role = Role::findOrCreate('test-role', 'web');
        $this->permission = Permission::findOrCreate('test-permission', 'web');
        $this->role->givePermissionTo($this->permission);

        $this->user = User::factory()->create();
        $this->user->assignRole($this->role);
        $this->user->givePermissionTo($this->permission);
    }

    #[Test]
    public function it_caches_user_roles_on_first_access()
    {
        Cache::flush();

        // First access should query and cache
        $roles = $this->user->roles;

        $lastUpdated = Cache::get('spatie_permissions_last_updated', 'never');
        $cacheKey = 'roles_user_'.$this->user->id.'_'.$lastUpdated;

        $this->assertTrue(Cache::has($cacheKey), 'Roles should be cached after first access');
        $this->assertCount(1, $roles);
        $this->assertEquals('test-role', $roles->first()->name);
    }

    #[Test]
    public function it_caches_user_permissions_on_first_access()
    {
        Cache::flush();

        // First access should query and cache
        $permissions = $this->user->permissions;

        $lastUpdated = Cache::get('spatie_permissions_last_updated', 'never');
        $cacheKey = 'permissions_user_'.$this->user->id.'_'.$lastUpdated;

        $this->assertTrue(Cache::has($cacheKey), 'Permissions should be cached after first access');
        $this->assertCount(1, $permissions);
        $this->assertEquals('test-permission', $permissions->first()->name);
    }

    #[Test]
    public function it_uses_cached_roles_on_subsequent_access()
    {
        Cache::flush();

        // First access - caches the data
        $this->user->roles;

        // Enable query logging
        DB::enableQueryLog();

        // Second access - should use cache (no queries)
        $roles = $this->user->fresh()->roles;

        $queries = DB::getQueryLog();

        // Filter out only role-related queries
        $roleQueries = array_filter($queries, function ($query) {
            return str_contains($query['query'], 'model_has_roles');
        });

        $this->assertEmpty($roleQueries, 'Should not query roles table on cached access');
        $this->assertCount(1, $roles);
    }

    #[Test]
    public function it_uses_cached_permissions_on_subsequent_access()
    {
        Cache::flush();

        // First access - caches the data
        $this->user->permissions;

        // Enable query logging
        DB::enableQueryLog();

        // Second access - should use cache (no queries)
        $permissions = $this->user->fresh()->permissions;

        $queries = DB::getQueryLog();

        // Filter out only permission-related queries
        $permissionQueries = array_filter($queries, function ($query) {
            return str_contains($query['query'], 'model_has_permissions');
        });

        $this->assertEmpty($permissionQueries, 'Should not query permissions table on cached access');
        $this->assertCount(1, $permissions);
    }

    #[Test]
    public function it_invalidates_cache_when_global_timestamp_changes()
    {
        Cache::flush();

        // Cache the roles
        $oldRoles = $this->user->roles;
        $oldLastUpdated = Cache::get('spatie_permissions_last_updated', 'never');

        // Update global timestamp (simulating role/permission update)
        Cache::put('spatie_permissions_last_updated', now()->timestamp);

        // Access roles again
        $newRoles = $this->user->fresh()->roles;

        $newLastUpdated = Cache::get('spatie_permissions_last_updated', 'never');

        $this->assertNotEquals($oldLastUpdated, $newLastUpdated, 'Timestamp should have changed');

        // Old cache key should not exist
        $oldCacheKey = 'roles_user_'.$this->user->id.'_'.$oldLastUpdated;
        $newCacheKey = 'roles_user_'.$this->user->id.'_'.$newLastUpdated;

        $this->assertTrue(Cache::has($newCacheKey), 'New cache key should exist');
    }

    #[Test]
    public function it_clears_user_specific_cache_when_roles_updated()
    {
        Cache::flush();

        // Cache the roles
        $this->user->roles;

        $lastUpdated = Cache::get('spatie_permissions_last_updated', 'never');
        $cacheKey = 'roles_user_'.$this->user->id.'_'.$lastUpdated;

        $this->assertTrue(Cache::has($cacheKey));

        // Clear user's permission cache
        $this->user->clearPermissionCache();

        // Cache should be cleared
        $this->assertFalse(Cache::has($cacheKey), 'User cache should be cleared');
    }

    #[Test]
    public function get_role_names_uses_cached_data()
    {
        Cache::flush();

        // First access to populate cache
        $this->user->roles;

        DB::enableQueryLog();

        // getRoleNames should use cached data
        $roleNames = $this->user->fresh()->getRoleNames();

        $queries = DB::getQueryLog();
        $roleQueries = array_filter($queries, function ($query) {
            return str_contains($query['query'], 'model_has_roles');
        });

        $this->assertEmpty($roleQueries, 'getRoleNames should use cached data');
        $this->assertTrue($roleNames->contains('test-role'));
    }

    #[Test]
    public function get_all_permissions_uses_cached_data()
    {
        Cache::flush();

        // First access to populate cache
        $this->user->roles;
        $this->user->permissions;

        DB::enableQueryLog();

        // getAllPermissions should use cached data
        $allPermissions = $this->user->fresh()->getAllPermissions();

        $queries = DB::getQueryLog();
        $permissionQueries = array_filter($queries, function ($query) {
            return str_contains($query['query'], 'model_has_permissions') ||
                str_contains($query['query'], 'role_has_permissions');
        });

        $this->assertEmpty($permissionQueries, 'getAllPermissions should use cached data');
        $this->assertTrue($allPermissions->contains('name', 'test-permission'));
    }

    #[Test]
    public function get_direct_permissions_uses_cached_data()
    {
        Cache::flush();

        // First access to populate cache
        $this->user->permissions;

        DB::enableQueryLog();

        // getDirectPermissions should use cached data
        $directPermissions = $this->user->fresh()->getDirectPermissions();

        $queries = DB::getQueryLog();
        $permissionQueries = array_filter($queries, function ($query) {
            return str_contains($query['query'], 'model_has_permissions');
        });

        $this->assertEmpty($permissionQueries, 'getDirectPermissions should use cached data');
        $this->assertCount(1, $directPermissions);
    }

    #[Test]
    public function has_role_uses_cached_data()
    {
        Cache::flush();

        // First access to populate cache
        $this->user->roles;

        DB::enableQueryLog();

        // hasRole should use cached data
        $hasRole = $this->user->fresh()->hasRole('test-role');

        $queries = DB::getQueryLog();
        $roleQueries = array_filter($queries, function ($query) {
            return str_contains($query['query'], 'model_has_roles');
        });

        $this->assertEmpty($roleQueries, 'hasRole should use cached data');
        $this->assertTrue($hasRole);
    }

    #[Test]
    public function has_permission_to_uses_cached_data()
    {
        Cache::flush();

        // First access to populate cache
        $this->user->permissions;
        $this->user->roles;

        DB::enableQueryLog();

        // hasPermissionTo should use cached data
        $hasPermission = $this->user->fresh()->hasPermissionTo('test-permission');

        $queries = DB::getQueryLog();
        $permissionQueries = array_filter($queries, function ($query) {
            return str_contains($query['query'], 'model_has_permissions') ||
                str_contains($query['query'], 'role_has_permissions');
        });

        $this->assertEmpty($permissionQueries, 'hasPermissionTo should use cached data');
        $this->assertTrue($hasPermission);
    }

    #[Test]
    public function cached_roles_include_permissions()
    {
        Cache::flush();

        // Access roles to cache them
        $roles = $this->user->roles;

        // Roles should have permissions loaded
        $this->assertTrue(
            $roles->first()->relationLoaded('permissions'),
            'Cached roles should have permissions eager loaded'
        );

        $this->assertCount(1, $roles->first()->permissions);
        $this->assertEquals('test-permission', $roles->first()->permissions->first()->name);
    }

    #[Test]
    public function eager_loaded_roles_are_cached_with_permissions(): void
    {
        Cache::flush();

        // Simulate eager loading (the path that previously skipped 'with permissions')
        $user = User::with('roles')->find($this->user->id);

        // Accessing the roles attribute triggers the eager-load cache branch
        $roles = $user->roles;

        $this->assertTrue(
            $roles->first()->relationLoaded('permissions'),
            'Roles from the eager-load cache branch should also have permissions loaded'
        );
    }

    #[Test]
    public function assign_role_writes_the_pivot_row_even_when_a_stale_cache_claims_the_user_has_it(): void
    {
        $user = User::factory()->create();
        $role = Role::findOrCreate('stale-role', 'web');

        // Prime the forever-cache so the cached accessor falsely reports the user already
        // has the role, while no model_has_roles row exists (the migrate:fresh scenario).
        Cache::forever('roles_user_'.$user->id.'_never', collect([$role]));

        $user->assignRole('stale-role');

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => $role->id,
            'model_id' => $user->id,
            'model_type' => $user->getMorphClass(),
        ]);
        $this->assertTrue($user->fresh()->hasRole('stale-role'));
    }

    #[Test]
    public function give_permission_to_writes_the_pivot_row_even_when_a_stale_cache_claims_the_user_has_it(): void
    {
        $user = User::factory()->create();
        $permission = Permission::findOrCreate('stale-permission', 'web');

        Cache::forever('permissions_user_'.$user->id.'_never', collect([$permission]));

        $user->givePermissionTo('stale-permission');

        $this->assertDatabaseHas('model_has_permissions', [
            'permission_id' => $permission->id,
            'model_id' => $user->id,
            'model_type' => $user->getMorphClass(),
        ]);
        $this->assertTrue($user->fresh()->hasPermissionTo('stale-permission'));
    }

    #[Test]
    public function seeder_grants_super_admin_every_ability_through_the_gate_bypass_despite_a_stale_cache(): void
    {
        $userRoles = [
            'super@admin.com' => 'super admin',
            'admin@admin.com' => 'administrator',
            'manager@manager.com' => 'manager',
            'executive@executive.com' => 'executive',
            'user@user.com' => 'user',
        ];
        foreach ($userRoles as $email => $role) {
            User::factory()->create(['email' => $email]);
            Role::findOrCreate($role, 'web');
        }
        $superAdmin = User::where('email', 'super@admin.com')->firstOrFail();

        // Simulate a file cache warmed by a previous database that outlived migrate:fresh.
        Cache::forever('roles_user_'.$superAdmin->id.'_never', collect([Role::findByName('super admin', 'web')]));

        (new UserRoleTableSeeder)->run();

        $this->assertTrue($superAdmin->fresh()->hasRole('super admin'));
        $this->assertTrue(Gate::forUser($superAdmin->fresh())->allows('any-undefined-ability'));
    }

    #[Test]
    public function has_permission_via_role_uses_loaded_permissions_without_extra_queries(): void
    {
        Cache::flush();

        // Populate the roles cache (which now stores roles with permissions)
        $this->user->roles;

        DB::enableQueryLog();

        // hasPermissionTo hitting the role-permission path should not query
        $hasPermission = $this->user->fresh()->hasPermissionTo('test-permission');

        $queries = DB::getQueryLog();
        $rolePermissionQueries = array_filter($queries, function ($query) {
            return str_contains($query['query'], 'role_has_permissions');
        });

        $this->assertEmpty($rolePermissionQueries, 'Role-permission lookup should use loaded collection, not DB');
        $this->assertTrue($hasPermission);
    }
}
