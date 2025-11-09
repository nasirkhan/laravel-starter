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
     * Caches menu structure for 1 hour (3600 seconds) to improve performance.
     *
     * @param  string  $location  The menu location identifier
     * @param  \App\Models\User|null  $user  The user to check permissions for (null for guest)
     * @param  string|null  $locale  The locale to filter menus by (defaults to current locale)
     * @return \Illuminate\Support\Collection Collection of processed menus with hierarchical items
     */
    public static function getCachedMenuData(string $location, $user = null, ?string $locale = null): \Illuminate\Support\Collection
    {
        $locale = $locale ?? app()->getLocale();
        $defaultLocale = config('app.fallback_locale', 'en');

        // Create cache key based on location, user permissions, and locale
        $userPermissions = $user ? implode(',', $user->getAllPermissions()->pluck('name')->sort()->toArray()) : 'guest';
        $cacheKey = "menu_data_{$location}_{$userPermissions}_{$locale}";

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 3600, function () use ($location, $user, $locale, $defaultLocale) {
            // Try to get menus in current locale first
            $menus = static::byLocation($location)
                ->activeAndVisible()
                ->where(function ($query) use ($locale) {
                    $query->where('locale', $locale)
                        ->orWhereNull('locale');
                })
                ->get()
                ->filter(function ($menu) use ($user) {
                    return $menu->userCanSee($user);
                });

            // Fallback to default locale if no menus found
            if ($menus->isEmpty() && $locale !== $defaultLocale) {
                $menus = static::byLocation($location)
                    ->activeAndVisible()
                    ->where(function ($query) use ($defaultLocale) {
                        $query->where('locale', $defaultLocale)
                            ->orWhereNull('locale');
                    })
                    ->get()
                    ->filter(function ($menu) use ($user) {
                        return $menu->userCanSee($user);
                    });

                if ($menus->isNotEmpty()) {
                    $locale = $defaultLocale;
                }
            }

            if ($menus->isEmpty()) {
                return collect();
            }

            // Fetch all menu items in a single query
            $menuIds = $menus->pluck('id');
            $allMenuItems = \Modules\Menu\Models\MenuItem::whereIn('menu_id', $menuIds)
                ->where('is_visible', true)
                ->where('is_active', true)
                ->where(function ($localeQuery) use ($locale) {
                    $localeQuery->where('locale', $locale)
                        ->orWhereNull('locale');
                })
                ->orderBy('menu_id')
                ->orderBy('parent_id', 'asc')
                ->orderBy('sort_order', 'asc')
                ->get();

            // Filter items by user permissions
            $accessibleItems = $allMenuItems->filter(function ($item) use ($user) {
                if (! $user) {
                    return ! $item->permissions || empty($item->permissions);
                }

                if (! $item->permissions || empty($item->permissions)) {
                    return true;
                }

                if (is_array($item->permissions)) {
                    foreach ($item->permissions as $permission) {
                        if ($user->can($permission)) {
                            return true;
                        }
                    }
                }

                return false;
            });

            // Build hierarchical structure
            $itemsByMenu = $accessibleItems->groupBy('menu_id');

            return $menus->map(function ($menu) use ($itemsByMenu) {
                $menuItems = $itemsByMenu->get($menu->id, collect());

                if ($menuItems->isEmpty()) {
                    $menu->hierarchicalItems = collect();

                    return $menu;
                }

                // Build parent-child hierarchy
                $itemsById = $menuItems->keyBy('id');
                $rootItems = collect();

                // Initialize children collection for each item
                foreach ($menuItems as $item) {
                    $item->children = collect();
                }

                // Build hierarchy
                foreach ($menuItems as $item) {
                    if ($item->parent_id === null) {
                        $rootItems->push($item);
                    } else {
                        $parent = $itemsById->get($item->parent_id);
                        if ($parent) {
                            $parent->children->push($item);
                        }
                    }
                }

                // Recursively sort by sort_order
                $sortItemsRecursively = function ($items) use (&$sortItemsRecursively) {
                    $sortedItems = $items->sortBy('sort_order');
                    foreach ($sortedItems as $item) {
                        if (isset($item->children)) {
                            $item->children = $sortItemsRecursively($item->children);
                        }
                    }

                    return $sortedItems;
                };

                $menu->hierarchicalItems = $sortItemsRecursively($rootItems);

                return $menu;
            })->filter(function ($menu) {
                return $menu->hierarchicalItems->isNotEmpty();
            });
        });
    }

    /**
     * Clear menu cache for a specific location or all menu caches.
     * This should be called whenever menus or menu items are updated.
     *
     * @param  string|null  $location  The menu location to clear cache for (null clears all)
     */
    public static function clearMenuCache(?string $location = null): void
    {
        if ($location) {
            // Clear all cache keys matching this location
            $pattern = "menu_data_{$location}_*";

            // Get all cache keys and remove matching ones
            // Note: This is a simplified approach. For production with Redis/Memcached,
            // you might want to use tags or a more sophisticated cache key pattern
            \Illuminate\Support\Facades\Cache::flush();
        } else {
            // Clear all menu caches
            \Illuminate\Support\Facades\Cache::flush();
        }
    }

    /**
     * Clear all menu caches across all locations.
     * Use this when you need to ensure all menu data is refreshed.
     */
    public static function clearAllMenuCaches(): void
    {
        \Illuminate\Support\Facades\Cache::flush();
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

        // Check permissions - user needs ANY of the required permissions (OR logic)
        if ($this->permissions && is_array($this->permissions) && ! empty($this->permissions)) {
            foreach ($this->permissions as $permission) {
                if ($user->can($permission)) {
                    return true; // User has at least one required permission
                }
            }

            return false; // User doesn't have any of the required permissions
        }

        // If no permissions specified, authenticated user can see it
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
