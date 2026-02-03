{{-- Component: UI Primary Button --}}
{{-- Description: Primary action button with loading states and Alpine.js support --}}
{{-- Props: type, disabled, loading --}}

@props([
    'type' => 'submit',
    'disabled' => false,
    'loading' => false,
])

@php
    // Validate button type
    $validTypes = ['submit', 'button', 'reset'];
    $type = in_array($type, $validTypes) ? $type : 'submit';
    
    // Convert string booleans to actual booleans
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $loading = filter_var($loading, FILTER_VALIDATE_BOOLEAN);
@endphp

<button
    type="{{ $type }}"
    {{ $disabled || $loading ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => 'inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150'
    ]) }}
>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @endif
    {{ $slot }}
</button>

{{-- Usage:
<x-ui.buttons.primary>
    Save Changes
</x-ui.buttons.primary>

With Alpine.js loading state:
<x-ui.buttons.primary 
    x-bind:disabled="loading"
    x-on:click="loading = true; submitForm()">
    <span x-show="!loading">Submit</span>
    <span x-show="loading" class="flex items-center">
        <svg class="animate-spin h-4 w-4 mr-2">...</svg>
        Submitting...
    </span>
</x-ui.buttons.primary>

With Livewire:
<x-ui.buttons.primary 
    wire:click="save" 
    wire:loading.attr="disabled">
    Save
</x-ui.buttons.primary>
--}}
