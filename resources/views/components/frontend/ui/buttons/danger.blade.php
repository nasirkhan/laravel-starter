{{-- Component: UI Danger Button --}}
{{-- Description: Destructive action button (delete, remove, etc.) --}}
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
        'class' => 'inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-hidden focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150'
    ]) }}
>
    {{ $slot }}
</button>

{{-- Usage:
<x-ui.buttons.danger 
    x-on:click="$dispatch('open-modal', 'confirm-delete')">
    Delete Account
</x-ui.buttons.danger>

<x-ui.buttons.danger 
    type="submit"
    wire:click="delete"
    wire:loading.attr="disabled">
    Delete
</x-ui.buttons.danger>
--}}
