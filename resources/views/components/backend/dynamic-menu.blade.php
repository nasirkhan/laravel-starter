@props(['location' => 'admin-sidebar', 'cssClass' => 'sidebar-nav', 'containerTag' => 'ul'])

@php
    use Modules\Menu\Models\Menu;
    
    $user = auth()->user();
    $currentLocale = app()->getLocale();
    
    // Get cached menu data - this includes all processing and hierarchy building
    $processedMenus = Menu::getCachedMenuData($location, $user, $currentLocale);
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