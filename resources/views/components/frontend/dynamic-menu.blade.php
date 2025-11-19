@props(['location', 'cssClass' => 'flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-8', 'itemComponent' => null])

@php
    use Modules\Menu\Models\Menu;
    
    $user = auth()->user();
    $currentLocale = app()->getLocale();
    
    // Determine which menu item component to use based on location
    $menuItemComponent = $itemComponent ?? match($location) {
        'frontend-footer' => 'components.frontend.footer-menu-item',
        default => 'components.frontend.menu-item'
    };
    
    // Get cached menu data - this includes all processing and hierarchy building
    $processedMenus = Menu::getCachedMenuData($location, $user, $currentLocale);
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