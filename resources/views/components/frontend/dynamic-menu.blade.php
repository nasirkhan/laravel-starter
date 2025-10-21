@props(['location', 'cssClass' => 'flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-8', 'itemComponent' => null])

@php
    use Modules\Menu\Models\Menu;
    use Modules\Menu\Models\MenuItem;
    
    // Get current locale and user info once
    $currentLocale = app()->getLocale();
    $user = auth()->user();
    
    // Determine which menu item component to use based on location
    $menuItemComponent = $itemComponent ?? match($location) {
        'frontend-footer' => 'components.frontend.footer-menu-item',
        default => 'components.frontend.menu-item'
    };
    
    // STEP 1: Get all menus based on menu location
    $menus = Menu::byLocation($location)
        ->activeAndVisible()
        ->where(function($query) use ($currentLocale) {
            $query->where('locale', $currentLocale)
                  ->orWhereNull('locale');
        })
        ->get()
        ->filter(function($menu) use ($user) {
            return $menu->userCanSee($user);
        });
    
    if ($menus->isEmpty()) {
        $processedMenus = collect();
    } else {
        // STEP 2: Fetch all menu items of ALL levels into a collection (single query)
        $menuIds = $menus->pluck('id');
        $allMenuItems = MenuItem::whereIn('menu_id', $menuIds)
            ->where('is_visible', true)
            ->where('is_active', true)
            ->where(function($localeQuery) use ($currentLocale) {
                $localeQuery->where('locale', $currentLocale)
                           ->orWhereNull('locale');
            })
            ->orderBy('menu_id')
            ->orderBy('parent_id', 'asc')
            ->orderBy('sort_order', 'asc')
            ->get();
        
        // Filter menu items by user permissions using Laravel's authorization
        $accessibleItems = $allMenuItems->filter(function($item) use ($user) {
            // If no user, only show items with no permissions required
            if (!$user) {
                return !$item->permissions || empty($item->permissions);
            }
            
            // If item has no permissions specified, it's accessible to authenticated users
            if (!$item->permissions || empty($item->permissions)) {
                return true;
            }
            
            // Check if user has ANY of the required permissions using Laravel's can()
            // This automatically handles "super admin" role which passes all permissions
            if (is_array($item->permissions)) {
                foreach ($item->permissions as $permission) {
                    if ($user->can($permission)) {
                        return true;
                    }
                }
            }
            
            return false;
        });
        
        // STEP 3: Rearrange the collection based on parent-child relation (no database queries)
        $itemsByMenu = $accessibleItems->groupBy('menu_id');
        
        $processedMenus = $menus->map(function($menu) use ($itemsByMenu) {
            $menuItems = $itemsByMenu->get($menu->id, collect());
            
            if ($menuItems->isEmpty()) {
                $menu->hierarchicalItems = collect();
                return $menu;
            }
            
            // Build parent-child hierarchy using collection manipulation
            $itemsById = $menuItems->keyBy('id');
            $rootItems = collect();
            
            // Single pass hierarchy building - no database queries for child items
            // First, ensure all items have an empty children collection to prevent Eloquent relationship access
            foreach ($menuItems as $item) {
                $item->children = collect();
            }
            
            // Now build the hierarchy
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
            
            // Recursively sort all levels by sort_order
            $sortItemsRecursively = function($items) use (&$sortItemsRecursively) {
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
        })->filter(function($menu) {
            return $menu->hierarchicalItems->isNotEmpty();
        });
    }
@endphp

@if($processedMenus->isNotEmpty())
    <ul class="{{ $cssClass }}">
        @foreach($processedMenus as $menu)
            @if($menu->hierarchicalItems && $menu->hierarchicalItems->isNotEmpty())
                @foreach($menu->hierarchicalItems as $menuItem)
                    @include($menuItemComponent, ['item' => $menuItem, 'optimized' => true])
                @endforeach
            @endif
        @endforeach
    </ul>
@endif