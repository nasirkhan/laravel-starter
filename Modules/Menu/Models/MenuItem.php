<?php

namespace Modules\Menu\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'menu_items';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'route_parameters' => 'array',
            'html_attributes' => 'array',
            'permissions' => 'array',
            'roles' => 'array',
            'custom_data' => 'array',
            'opens_new_tab' => 'boolean',
            'is_visible' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the menu that owns the menu item.
     */
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Get the parent menu item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Get the child menu items.
     */
    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Get all descendants (recursive children).
     */
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }

    /**
     * Scope: Get only root level items (no parent).
     */
    public function scopeRootLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope: Get only visible items.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true)
            ->where('is_active', true);
    }

    /**
     * Scope: Get menu items accessible by user with optimized permission checking.
     */
    public function scopeAccessibleByUser($query, $user = null)
    {
        $user = $user ?? \Illuminate\Support\Facades\Auth::user();

        if (! $user) {
            // Guest users can only see items with no permissions
            return $query->whereNull('permissions');
        }

        // Authenticated users can see items with no permissions OR items they have permission for
        return $query->where(function ($q) {
            $q->whereNull('permissions')
                ->orWhere(function ($subQuery) {
                    // User needs ANY of the item's permissions using Laravel's can()
                    $subQuery->whereNotNull('permissions');
                    // This is complex to do in SQL, better to filter in PHP
                });
        });
    }

    /**
     * Scope: Get items by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Get items by locale.
     */
    public function scopeByLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    /**
     * Check if menu item has children (without database query).
     * Use $item->children collection if already loaded, otherwise query database.
     */
    public function hasChildren(): bool
    {
        // If children relationship is loaded, use that
        if ($this->relationLoaded('children')) {
            return $this->children->isNotEmpty();
        }

        // Otherwise, query database (fallback)
        return $this->children()->count() > 0;
    }

    /**
     * Check if menu item is a dropdown (without database query if children loaded).
     */
    public function isDropdown(): bool
    {
        return $this->type === 'dropdown' || $this->hasChildren();
    }

    /**
     * Check if menu item is external link.
     */
    public function isExternal(): bool
    {
        return $this->type === 'external' ||
               (filter_var($this->url, FILTER_VALIDATE_URL) &&
                ! str_contains($this->url, config('app.url')));
    }

    /**
     * Get the full URL for the menu item.
     */
    public function getFullUrl(): ?string
    {
        // If URL is present, use it directly
        if (! empty($this->url)) {
            return $this->url;
        }

        // If URL is empty, fall back to route_name
        if (! empty($this->route_name)) {
            try {
                return route($this->route_name, $this->route_parameters ?? []);
            } catch (\Exception $e) {
                // If route doesn't exist, return placeholder
                return '#';
            }
        }

        // If both URL and route_name are empty, return placeholder
        return '#';
    }

    /**
     * Check if current menu item is active based on current route.
     */
    public function isCurrentlyActive(): bool
    {
        $currentRoute = request()->route();

        if (! $currentRoute) {
            return false;
        }

        // Check if route name matches
        if ($this->route_name && $currentRoute->getName() === $this->route_name) {
            return true;
        }

        // Check if URL matches
        if ($this->url && request()->is(trim($this->url, '/'))) {
            return true;
        }

        // Check if any child is active
        return $this->children->contains(function ($child) {
            return $child->isCurrentlyActive();
        });
    }

    /**
     * Check if menu item is visible based on time conditions.
     */
    /**
     * Get the display title (using 'name' field from database).
     */
    public function getDisplayTitle(): string
    {
        return $this->name;
    }

    /**
     * Set the display title (maps to 'name' field).
     */
    public function setDisplayTitle(string $title): void
    {
        $this->name = $title;
    }

    /**
     * Check if user has permission to see this menu item.
     */
    public function userCanSee($user = null): bool
    {
        $user = $user ?? \Illuminate\Support\Facades\Auth::user();

        // If not authenticated, only show items with no permissions
        if (! $user) {
            return ! $this->permissions || empty($this->permissions);
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
     * Get menu item with all visibility checks.
     */
    public function scopeAccessible($query, $user = null)
    {
        return $query->visible();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Menu\database\factories\MenuItemFactory::new();
    }
}
