@props(['location', 'cssClass' => 'flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-8', 'itemComponent' => null])

<x-menu-dynamic-menu :location="$location" :css-class="$cssClass" :item-component="$itemComponent" />
