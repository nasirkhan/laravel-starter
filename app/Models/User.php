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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory;
    use HasHashedMediaTrait;
    use HasRoles {
        hasRole as hasRoleOriginal;
        hasPermissionTo as hasPermissionToOriginal;
        assignRole as assignRoleOriginal;
        givePermissionTo as givePermissionToOriginal;
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
        $lastUpdated = Cache::get('spatie_permissions_last_updated', 'never');
        Cache::forget('roles_user_'.$this->id.'_'.$lastUpdated);
        Cache::forget('permissions_user_'.$this->id.'_'.$lastUpdated);
    }

    /**
     * Override assignRole to clear the permission cache after Spatie v7 internally
     * accesses $this->roles (which would otherwise cache a stale empty collection).
     */
    public function assignRole(...$roles): static
    {
        $result = $this->assignRoleOriginal(...$roles);
        $this->clearPermissionCache();

        return $result;
    }

    /**
     * Override givePermissionTo to clear the permission cache after Spatie v7 internally
     * accesses $this->permissions (which would otherwise cache a stale empty collection).
     */
    public function givePermissionTo(...$permissions): static
    {
        $result = $this->givePermissionToOriginal(...$permissions);
        $this->clearPermissionCache();

        return $result;
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

        if (is_string($roles) && strpos($roles, '|') !== false) {
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

        if ($roles instanceof Role) {
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

        $permissionName = $permission instanceof Permission
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
        $permissionName = $permission instanceof Permission
            ? $permission->name
            : $permission;

        $guardName = $guardName ?? $this->getDefaultGuardName();

        foreach ($this->roles as $role) {
            if ($role->guard_name !== $guardName) {
                continue;
            }

            if ($role->relationLoaded('permissions')) {
                if ($role->permissions->where('guard_name', $guardName)->contains('name', $permissionName)) {
                    return true;
                }
            } elseif ($role->hasPermissionTo($permission)) {
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
    public function getRoleNames(): Collection
    {
        if (! static::$useCachedPermissions) {
            return $this->roles()->pluck('name');
        }

        return $this->roles->pluck('name');
    }

    /**
     * Override getAllPermissions to use cached data.
     */
    public function getAllPermissions(): Collection
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
    public function getDirectPermissions(): Collection
    {
        if (! static::$useCachedPermissions) {
            return $this->permissions()->get();
        }

        return $this->permissions;
    }
}
