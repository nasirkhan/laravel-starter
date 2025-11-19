# Menu Caching System

This Laravel application now includes a comprehensive menu caching system to improve performance by reducing database queries for menu data.

## Overview

Menus are cached for **1 hour (3600 seconds)** by default. The cache is automatically cleared whenever menus or menu items are created, updated, or deleted.

## Features

### 1. **Automatic Caching**
- Menu data is automatically cached when first accessed
- Cache includes menu structure, permissions, and hierarchical relationships
- Cache key includes location, user permissions, and locale for accurate data delivery

### 2. **Automatic Cache Clearing**
- **Model Observers**: MenuObserver and MenuItemObserver automatically clear cache when:
  - A menu or menu item is created
  - A menu or menu item is updated
  - A menu or menu item is deleted
  - A menu or menu item is restored (from soft delete)

### 3. **Manual Cache Clearing**
You can manually clear menu caches using the Artisan command:

```bash
# Clear all menu caches
php artisan menu:clear-cache --all

# Clear cache for a specific location
php artisan menu:clear-cache admin-sidebar
php artisan menu:clear-cache frontend-header
```

## Implementation Details

### Menu Model Methods

#### `getCachedMenuData($location, $user = null, $locale = null)`
Retrieves cached menu data for a specific location and user.

```php
use Modules\Menu\Models\Menu;

// Get cached menu data for frontend header
$processedMenus = Menu::getCachedMenuData('frontend-header', auth()->user(), app()->getLocale());
```

**Parameters:**
- `$location` (string): Menu location identifier (e.g., 'admin-sidebar', 'frontend-header')
- `$user` (User|null): User to check permissions for (null for guests)
- `$locale` (string|null): Locale to filter menus by (defaults to current locale)

**Returns:** Collection of processed menus with hierarchical items

#### `clearMenuCache($location = null)`
Clears menu cache for a specific location or all menus.

```php
use Modules\Menu\Models\Menu;

// Clear cache for specific location
Menu::clearMenuCache('admin-sidebar');

// Clear all menu caches
Menu::clearAllMenuCaches();
```

### Blade Components Usage

The menu caching is automatically used in the dynamic menu components:

**Frontend:**
```blade
<x-frontend.dynamic-menu location="frontend-header" />
```

**Backend:**
```blade
<x-backend.dynamic-menu location="admin-sidebar" />
```

### Cache Keys

Cache keys are generated based on:
1. **Location**: Menu location identifier
2. **User Permissions**: Comma-separated list of user permissions (or 'guest')
3. **Locale**: Current application locale

Example cache key: `menu_data_admin-sidebar_edit_posts,view_backend,delete_users_en`

This ensures users with different permissions see appropriately cached menus.

## Controller Integration

The MenusController and MenuItemsController automatically clear cache after:
- Creating a new menu item (`store`)
- Updating a menu item (`update`)
- Deleting a menu (`destroy`)

## Performance Benefits

**Before Caching:**
- Multiple database queries per page load
- Menu structure built on every request
- Permission checks on every menu render

**After Caching:**
- Single cache lookup per location
- Menu structure built once per hour
- Permissions pre-calculated and cached

**Estimated Performance Improvement:**
- Reduces database queries by ~5-15 queries per page (depending on menu complexity)
- Faster page load times, especially for pages with multiple menu locations
- Reduced database load on high-traffic applications

## Cache Storage

The menu cache uses Laravel's default cache driver (configured in `config/cache.php`).

Recommended cache drivers for production:
- **Redis**: Best performance, supports cache tags
- **Memcached**: Good performance
- **Database**: Acceptable for smaller applications
- **File**: Not recommended for high-traffic sites

## Debugging

To check if caching is working:

1. Enable cache logging by checking `storage/logs/laravel.log` after menu updates
2. Look for log entries like: `"Menu cache cleared for location: admin-sidebar"`

## Best Practices

1. **Cache Duration**: The default 1-hour cache is suitable for most applications. Adjust in `Menu::getCachedMenuData()` if needed.

2. **Manual Cache Clearing**: If you're making bulk menu updates, consider clearing cache manually afterward:
   ```bash
   php artisan menu:clear-cache --all
   ```

3. **Deployment**: After deploying menu changes, clear the cache:
   ```bash
   php artisan menu:clear-cache --all
   ```

4. **Development**: If you're frequently updating menus during development, you can temporarily disable caching or reduce the cache duration.

## Files Modified/Created

### Created Files:
- `Modules/Menu/Observers/MenuObserver.php` - Observer for Menu model
- `Modules/Menu/Observers/MenuItemObserver.php` - Observer for MenuItem model
- `Modules/Menu/Console/Commands/ClearMenuCacheCommand.php` - Artisan command

### Modified Files:
- `Modules/Menu/Models/Menu.php` - Added caching methods
- `Modules/Menu/Providers/MenuServiceProvider.php` - Registered observers
- `Modules/Menu/Http/Controllers/Backend/MenusController.php` - Added cache clearing
- `Modules/Menu/Http/Controllers/Backend/MenuItemsController.php` - Added cache clearing
- `resources/views/components/frontend/dynamic-menu.blade.php` - Uses cached data
- `resources/views/components/backend/dynamic-menu.blade.php` - Uses cached data

## Troubleshooting

**Issue: Menu changes not appearing**
- Solution: Clear menu cache with `php artisan menu:clear-cache --all`

**Issue: Different users seeing wrong menus**
- Solution: Check that user permissions are properly set. Cache keys include permissions.

**Issue: Performance not improved**
- Solution: Verify cache driver is configured correctly and not using 'array' or 'null' driver

## Future Enhancements

Potential improvements for the future:
- Cache tags support (requires Redis/Memcached)
- Configurable cache duration per menu location
- Cache warming on deployment
- Menu cache statistics dashboard
