<ul class="sidebar-nav" {{ $attributes }}>
    @foreach($items as $item)
    @if($item->isDivider())
    <x-menus-divider :item="$item" class="border-0 bg-gray-500 text-gray-500 h-px" />
    @else
    @if($item->isActive())
    <x-menus-item :item="$item" class="nav-link" />
    @else
    <x-menus-item :item="$item" class="nav-link" />
    @endif
    @endif
    @endforeach
</ul>