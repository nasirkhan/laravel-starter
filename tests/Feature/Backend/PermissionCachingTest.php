<?php

namespace Tests\Feature\Backend;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
}
