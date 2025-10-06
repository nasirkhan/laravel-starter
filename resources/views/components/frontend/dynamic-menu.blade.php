@props(['location', 'cssClass' => 'flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-8', 'itemComponent' => null])

@php
    use Modules\Menu\Models\Menu;
    
    // Get current locale
    $currentLocale = app()->getLocale();
    
    // Determine which menu item component to use based on location
    $menuItemComponent = $itemComponent ?? match($location) {
        'frontend-footer' => 'components.frontend.footer-menu-item',
        default => 'components.frontend.menu-item'
    };
    
    // Fetch active menus for the specified location
    $menus = Menu::byLocation($location)
        ->activeAndVisible()
        ->where(function($query) use ($currentLocale) {
            $query->where('locale', $currentLocale)
                  ->orWhereNull('locale');
        })
        ->with(['items' => function($query) {
            $query->visible()
                  ->rootLevel()
                  ->orderBy('sort_order')
                  ->with(['children' => function($childQuery) {
                      $childQuery->visible()->orderBy('sort_order');
                  }]);
        }])
        ->get()
        ->filter(function($menu) {
            return $menu->userCanSee();
        });
@endphp

@if($menus->isNotEmpty())
    <ul class="{{ $cssClass }}">
        @foreach($menus as $menu)
            @foreach($menu->items as $menuItem)
                @if($menuItem->userCanSee())
                    @include($menuItemComponent, ['item' => $menuItem])
                @endif
            @endforeach
        @endforeach
    </ul>
@endif