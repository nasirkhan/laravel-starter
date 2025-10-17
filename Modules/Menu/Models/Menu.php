<?php

namespace Modules\Menu\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'menus';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'permissions' => 'array',
            'roles' => 'array',
            'is_public' => 'boolean',
            'is_active' => 'boolean',
            'is_visible' => 'boolean',
        ];
    }

    /**
     * Get the menu items that belong to this menu.
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('sort_order');
    }

    /**
     * Get all menu items (including nested ones).
     */
    public function allItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    /**
     * Scope: Get menus by location.
     */
    public function scopeByLocation($query, $location)
    {
        return $query->where('location', $location);
    }

    /**
     * Scope: Get active and visible menus.
     */
    public function scopeActiveAndVisible($query)
    {
        return $query->where('is_active', true)->where('is_visible', true);
    }

    /**
     * Scope: Get public menus.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope: Get menus by locale.
     */
    public function scopeByLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    /**
     * Get cached menu data for a specific location and user.
     */
    public static function getCachedMenuData($location, $user = null, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $userId = $user ? $user->id : 'guest';
        $cacheKey = "menu_data_{$location}_{$userId}_{$locale}";

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 300, function () use ($location, $user, $locale) {
            return static::byLocation($location)
                ->activeAndVisible()
                ->accessibleByUser($user)
                ->where(function ($query) use ($locale) {
                    $query->where('locale', $locale)
                        ->orWhereNull('locale');
                })
                ->with([
                    'allItems' => function ($query) use ($locale, $user) {
                        $query->visible()
                            ->accessibleByUser($user)
                            ->where(function ($localeQuery) use ($locale) {
                                $localeQuery->where('locale', $locale)
                                    ->orWhereNull('locale');
                            })
                            ->orderBy('parent_id', 'asc')
                            ->orderBy('sort_order', 'asc');
                    },
                ])
                ->get();
        });
    }

    /**
     * Clear menu cache for a specific location or all menus.
     */
    public static function clearMenuCache($location = null)
    {
        if ($location) {
            \Illuminate\Support\Facades\Cache::forget("menu_data_{$location}_*");
        } else {
            \Illuminate\Support\Facades\Cache::flush();
        }
    }

    /**
     * Scope: Get menus accessible by user with optimized permission checking.
     */
    public function scopeAccessibleByUser($query, $user = null)
    {
        $user = $user ?? \Illuminate\Support\Facades\Auth::user();

        if (! $user) {
            return $query->where('is_public', true);
        }

        // Get user permissions and roles once
        $userPermissions = $user->getPermissionNames()->toArray();
        $userRoles = $user->getRoleNames()->toArray();

        return $query->where(function ($q) use ($userPermissions, $userRoles) {
            // Menu is public OR user has required access
            $q->where('is_public', true)
                ->orWhere(function ($accessQuery) use ($userPermissions, $userRoles) {
                    // User has required permissions (if any specified)
                    $accessQuery->where(function ($permQuery) use ($userPermissions) {
                        $permQuery->whereNull('permissions');
                        if (! empty($userPermissions)) {
                            foreach ($userPermissions as $permission) {
                                $permQuery->orWhereJsonContains('permissions', $permission);
                            }
                        }
                    });

                    // AND user has required roles (if any specified)
                    $accessQuery->where(function ($roleQuery) use ($userRoles) {
                        $roleQuery->whereNull('roles');
                        if (! empty($userRoles)) {
                            foreach ($userRoles as $role) {
                                $roleQuery->orWhereJsonContains('roles', $role);
                            }
                        }
                    });
                });
        });
    }

    /**
     * Check if user can see this menu.
     */
    public function userCanSee($user = null): bool
    {
        $user = $user ?? \Illuminate\Support\Facades\Auth::user();

        // Check if public
        if ($this->is_public) {
            return true;
        }

        // If not public, user must be authenticated
        if (! $user) {
            return false;
        }

        // Check permissions
        if ($this->permissions) {
            foreach ($this->permissions as $permission) {
                if (! $user->can($permission)) {
                    return false;
                }
            }
        }

        // Check roles
        if ($this->roles) {
            $hasRole = false;
            foreach ($this->roles as $role) {
                if ($user->hasRole($role)) {
                    $hasRole = true;
                    break;
                }
            }
            if (! $hasRole) {
                return false;
            }
        }

        return true;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Menu\database\factories\MenuFactory::new();
    }
}
