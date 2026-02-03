{{-- Component: UI Secondary Button --}}
{{-- Description: Secondary action button for less prominent actions --}}
{{-- Props: type, disabled --}}

@props([
    'type' => 'button',
    'disabled' => false,
])

@php
    $validTypes = ['submit', 'button', 'reset'];
    $type = in_array($type, $validTypes) ? $type : 'button';
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
@endphp

<button
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => 'inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150'
    ]) }}
>
    {{ $slot }}
</button>

{{-- Usage:
<x-ui.buttons.secondary>
    Cancel
</x-ui.buttons.secondary>

<x-ui.buttons.secondary 
    type="button"
    x-on:click="$dispatch('close-modal', 'confirm-delete')">
    Cancel
</x-ui.buttons.secondary>
--}}
