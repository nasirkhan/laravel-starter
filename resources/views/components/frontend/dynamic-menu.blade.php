@props(['location', 'cssClass' => 'flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-8'])

@php
    use Modules\Menu\Models\Menu;
    
    // Get current locale
    $currentLocale = app()->getLocale();
    
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
                    @include('components.frontend.menu-item', ['item' => $menuItem])
                @endif
            @endforeach
        @endforeach
    </ul>
@endif