<?php

namespace App\Models;

use App\Models\Presenters\UserPresenter;
use App\Models\Traits\HasHashedMediaTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory;
    use HasHashedMediaTrait;
    use HasRoles {
        hasRole as hasRoleOriginal;
        hasPermissionTo as hasPermissionToOriginal;
    }
    use Notifiable;
    use SoftDeletes;
    use UserPresenter;

    protected $guarded = [
        'id',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'datetime',
            'last_login' => 'datetime',
            'deleted_at' => 'datetime',
            'social_profiles' => 'array',
        ];
    }

    /**
     * Retrieve the providers associated with the user.
     */
    public function providers(): HasMany
    {
        return $this->hasMany(UserProvider::class);
    }
    /**
     * Toggle for using cached permissions.
     *
     * @var bool
     */
    public static $useCachedPermissions = true;

    /**
     * Clear the user's permission cache.
     */
    public function clearPermissionCache()
    {
        $lastUpdated = \Illuminate\Support\Facades\Cache::get('spatie_permissions_last_updated', 'never');
        \Illuminate\Support\Facades\Cache::forget('roles_user_'.$this->id.'_'.$lastUpdated);
        \Illuminate\Support\Facades\Cache::forget('permissions_user_'.$this->id.'_'.$lastUpdated);
    }

    /**
     * Override Spatie's hasRole to use cached roles.
     */
    public function hasRole($roles, ?string $guard = null): bool
    {
        if (! static::$useCachedPermissions) {
            return $this->hasRoleOriginal($roles, $guard);
        }

        $userRoles = $this->roles; // Uses cached accessor

        if (is_string($roles) && false !== strpos($roles, '|')) {
            $roles = $this->convertPipeToArray($roles);
        }

        if (is_string($roles)) {
            return $guard
                ? $userRoles->where('guard_name', $guard)->contains('name', $roles)
                : $userRoles->contains('name', $roles);
        }

        if (is_int($roles)) {
            return $guard
                ? $userRoles->where('guard_name', $guard)->contains('id', $roles)
                : $userRoles->contains('id', $roles);
        }

        if ($roles instanceof \Spatie\Permission\Contracts\Role) {
            return $guard
                ? $userRoles->where('guard_name', $guard)->contains('id', $roles->id)
                : $userRoles->contains('id', $roles->id);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role, $guard)) {
                    return true;
                }
            }

            return false;
        }

        return $roles->intersect($guard ? $userRoles->where('guard_name', $guard) : $userRoles)->isNotEmpty();
    }

    /**
     * Override Spatie's hasPermissionTo to use cached permissions.
     */
    public function hasPermissionTo($permission, $guardName = null): bool
    {
        if (! static::$useCachedPermissions) {
            return $this->hasPermissionToOriginal($permission, $guardName);
        }

        $permissionName = $permission instanceof \Spatie\Permission\Contracts\Permission
            ? $permission->name
            : $permission;

        $guardName = $guardName ?? $this->getDefaultGuardName();

        // Check direct permissions (cached)
        if ($this->permissions->where('guard_name', $guardName)->contains('name', $permissionName)) {
            return true;
        }

        // Check permissions via roles (cached)
        return $this->hasPermissionViaRole($permission, $guardName);
    }

    /**
     * Check if the user has a permission via roles (using cached roles).
     */
    public function hasPermissionViaRole($permission, $guardName = null): bool
    {
        $permissionName = $permission instanceof \Spatie\Permission\Contracts\Permission
            ? $permission->name
            : $permission;

        $guardName = $guardName ?? $this->getDefaultGuardName();

        foreach ($this->roles as $role) {
            if ($role->guard_name !== $guardName) {
                continue;
            }

            // We need to check if the ROLE has the permission.
            // Spatie's Role model caches permissions too?
            // Yes, Role->permissions is a relation.
            // If we access $role->permissions, it might query if not loaded.
            // But we eager loaded 'roles.permissions' in some places.
            // However, here we are iterating cached roles.
            // If the role object in cache has permissions loaded, great.
            // If not, it will query.
            // Spatie caches permissions for roles automatically in its own cache.
            // So $role->hasPermissionTo($permission) should be fast/cached by Spatie.

            if ($role->hasPermissionTo($permission)) {
                return true;
            }
        }

        return false;
    }

    protected function convertPipeToArray(string $pipeString)
    {
        $pipeString = trim($pipeString);

        if (strlen($pipeString) <= 2) {
            return $pipeString;
        }

        $quoteCharacter = substr($pipeString, 0, 1);
        $endCharacter = substr($quoteCharacter, -1, 1);

        if ($quoteCharacter !== $endCharacter) {
            return explode('|', $pipeString);
        }

        if (! in_array($quoteCharacter, ["'", '"'])) {
            return explode('|', $pipeString);
        }

        return explode('|', trim($pipeString, $quoteCharacter));
    }

    /**
     * Override getRoleNames to use cached roles.
     */
    public function getRoleNames(): \Illuminate\Support\Collection
    {
        if (! static::$useCachedPermissions) {
            return $this->roles()->pluck('name');
        }

        return $this->roles->pluck('name');
    }

    /**
     * Override getAllPermissions to use cached data.
     */
    public function getAllPermissions(): \Illuminate\Support\Collection
    {
        if (! static::$useCachedPermissions) {
            return parent::getAllPermissions();
        }

        // Get direct permissions (cached)
        $permissions = $this->permissions;

        // Get permissions from roles (cached)
        return $permissions->merge(
            $this->roles->flatMap(function ($role) {
                return $role->permissions;
            })
        )->unique('id');
    }

    /**
     * Override getDirectPermissions to use cached permissions.
     */
    public function getDirectPermissions(): \Illuminate\Support\Collection
    {
        if (! static::$useCachedPermissions) {
            return $this->permissions()->get();
        }

        return $this->permissions;
    }
}
