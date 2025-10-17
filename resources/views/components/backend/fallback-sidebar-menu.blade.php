{{-- Fallback Sidebar Menu: Load menu items from menu_data.json (in case dynamic menu is empty) --}}
@php
    // Load menu data from JSON file
    $menuDataPath = base_path('Modules/Menu/database/seeders/data/menu_data.json');
    $fallbackMenuItems = collect();
    
    if (file_exists($menuDataPath)) {
        $menuData = json_decode(file_get_contents($menuDataPath), true);
        
        // Find admin-sidebar menu
        $adminMenu = collect($menuData['menus'] ?? [])
            ->where('location', 'admin-sidebar')
            ->where('is_active', true)
            ->where('is_visible', true)
            ->first();
        
        if ($adminMenu) {
            // Get menu items for this menu
            $menuItems = collect($menuData['menu_items'] ?? [])
                ->where('menu_id', $adminMenu['id'])
                ->where('is_active', true)
                ->where('is_visible', true)
                ->sortBy('sort_order');
            
            // Build hierarchy
            $itemsById = $menuItems->keyBy('id');
            $fallbackMenuItems = $menuItems->where('parent_id', null)->values();
            
            // Add children to each parent item
            foreach ($fallbackMenuItems as $item) {
                $children = $menuItems->where('parent_id', $item['id'])->sortBy('sort_order')->values();
                $item['children'] = $children->toArray();
            }
        }
    }
    
    // Get notifications count for badge display
    $notifications = optional(auth()->user())->unreadNotifications;
    $notifications_count = optional($notifications)->count();
@endphp

<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    @if($fallbackMenuItems->isNotEmpty())
        {{-- Render menu items from JSON data --}}
        @foreach($fallbackMenuItems as $item)
            @if($item['type'] === 'divider')
                <li class="nav-divider"></li>
            @elseif($item['type'] === 'heading')
                <li class="nav-title">{{ $item['name'] }}</li>
            @elseif($item['type'] === 'dropdown' && !empty($item['children']))
                <li class="nav-group">
                    <a class="nav-link nav-group-toggle" href="#">
                        <i class="nav-icon {{ $item['icon'] ?? 'fa-solid fa-link' }}"></i>
                        &nbsp;{{ $item['name'] }}
                    </a>
                    <ul class="nav-group-items compact">
                        @foreach($item['children'] as $child)
                            @php
                                $childUrl = '#';
                                if ($child['route_name'] && \Illuminate\Support\Facades\Route::has($child['route_name'])) {
                                    try {
                                        $childUrl = route($child['route_name'], $child['route_parameters'] ?? []);
                                    } catch (\Exception $e) {
                                        $childUrl = $child['url'] ?? '#';
                                    }
                                } elseif ($child['url']) {
                                    $childUrl = $child['url'];
                                }
                                $childIsActive = $child['route_name'] && request()->routeIs($child['route_name']);
                            @endphp
                            <li class="nav-item">
                                <a class="nav-link @if($childIsActive) active @endif" 
                                   href="{{ $childUrl }}"
                                   @if($child['opens_new_tab'] ?? false) target="_blank" @endif>
                                    <i class="nav-icon {{ $child['icon'] ?? 'fa-solid fa-link' }}"></i>
                                    &nbsp;{{ $child['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @else
                @php
                    $itemUrl = '#';
                    if ($item['route_name'] && \Illuminate\Support\Facades\Route::has($item['route_name'])) {
                        try {
                            $itemUrl = route($item['route_name'], $item['route_parameters'] ?? []);
                        } catch (\Exception $e) {
                            $itemUrl = $item['url'] ?? '#';
                        }
                    } elseif ($item['url']) {
                        $itemUrl = $item['url'];
                    }
                    $itemIsActive = $item['route_name'] && request()->routeIs($item['route_name']);
                @endphp
                <li class="nav-item">
                    <a class="nav-link @if($itemIsActive) active @endif" 
                       href="{{ $itemUrl }}"
                       @if($item['opens_new_tab'] ?? false) target="_blank" @endif>
                        <i class="nav-icon {{ $item['icon'] ?? 'fa-solid fa-link' }}"></i>
                        &nbsp;{{ $item['name'] }}
                        
                        {{-- Special handling for notifications badge --}}
                        @if($item['route_name'] === 'backend.notifications.index' && $notifications_count)
                            &nbsp;<span class="badge badge-sm bg-info ms-auto">{{ $notifications_count }}</span>
                        @endif
                    </a>
                </li>
            @endif
        @endforeach
    @else
        {{-- Final fallback: Basic hardcoded menu items --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route("backend.dashboard") }}">
                <i class="nav-icon fa-solid fa-cubes"></i>
                &nbsp;@lang("Dashboard")
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route("backend.notifications.index") }}">
                <i class="nav-icon fa-regular fa-bell"></i>
                &nbsp;@lang("Notifications")
                @if ($notifications_count)
                    &nbsp;<span class="badge badge-sm bg-info ms-auto">{{ $notifications_count }}</span>
                @endif
            </a>
        </li>
    @endif
</ul>