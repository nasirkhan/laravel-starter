@props(['location' => 'admin-sidebar', 'cssClass' => 'sidebar-nav', 'containerTag' => 'ul'])

@php
    use Modules\Menu\Models\Menu;
    use Modules\Menu\Models\MenuItem;
    
    // Get current locale and user info once
    $currentLocale = app()->getLocale();
    $user = auth()->user();
    
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
        
        // Get user permissions and roles once for filtering
        $userPermissions = $user ? $user->getPermissionNames()->toArray() : [];
        $userRoles = $user ? $user->getRoleNames()->toArray() : [];
        
        // Filter menu items by user permissions in PHP (no additional database queries)
        $accessibleItems = $allMenuItems->filter(function($item) use ($user, $userPermissions, $userRoles) {
            // Public items are always accessible
            if ($item->is_public) {
                return true;
            }
            
            // If no user, only show public items
            if (!$user) {
                return false;
            }
            
            // If item has no permissions and no roles specified, it's accessible to authenticated users
            if ((!$item->permissions || empty($item->permissions)) && (!$item->roles || empty($item->roles))) {
                return true;
            }
            
            // Check permissions OR roles (user needs either the required permission OR role)
            $hasPermission = false;
            $hasRole = false;
            
            // Check permissions (if specified)
            if ($item->permissions && is_array($item->permissions) && !empty($item->permissions)) {
                foreach ($item->permissions as $permission) {
                    if (in_array($permission, $userPermissions)) {
                        $hasPermission = true;
                        break;
                    }
                }
            }
            
            // Check roles (if specified)
            if ($item->roles && is_array($item->roles) && !empty($item->roles)) {
                foreach ($item->roles as $role) {
                    if (in_array($role, $userRoles)) {
                        $hasRole = true;
                        break;
                    }
                }
            }
            
            // User needs either permission OR role (if item has both specified)
            $needsPermission = $item->permissions && is_array($item->permissions) && !empty($item->permissions);
            $needsRole = $item->roles && is_array($item->roles) && !empty($item->roles);
            
            if ($needsPermission && $needsRole) {
                return $hasPermission || $hasRole; // Either permission OR role
            } elseif ($needsPermission) {
                return $hasPermission; // Only permission required
            } elseif ($needsRole) {
                return $hasRole; // Only role required
            }
            
            return true; // No specific requirements
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
    <{{ $containerTag }} class="{{ $cssClass }}" data-coreui="navigation" data-simplebar>
        @foreach($processedMenus as $menu)
            @if($menu->hierarchicalItems && $menu->hierarchicalItems->isNotEmpty())
                @foreach($menu->hierarchicalItems as $menuItem)
                    @include('components.backend.dynamic-menu-item', ['item' => $menuItem, 'optimized' => true])
                @endforeach
            @endif
        @endforeach
    </{{ $containerTag }}>
@endif