{{-- Component: Navigation Nav Link --}}
{{-- Description: Navigation link with active state detection --}}
{{-- Props: href (required), active --}}

@props([
    'href' => '#',
    'active' => false,
])

@php
    $active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
    
    $classes = $active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-hidden focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-hidden focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

{{-- Usage:
<x-navigation.nav-link 
    href="{{ route('dashboard') }}" 
    :active="request()->routeIs('dashboard')">
    Dashboard
</x-navigation.nav-link>

With Alpine.js:
<x-navigation.nav-link 
    href="{{ route('settings') }}"
    :active="request()->routeIs('settings')"
    x-bind:class="{ 'opacity-75': loading }">
    Settings
</x-navigation.nav-link>
--}}
