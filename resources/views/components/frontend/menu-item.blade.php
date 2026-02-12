@props(['item', 'optimized' => false])

@include('menu::components.menu-item', ['item' => $item, 'optimized' => $optimized])
