{{-- Component: Forms Toggle Switch --}}
{{-- Description: iOS-style toggle switch with Alpine.js --}}
{{-- Props: name, checked, disabled, label --}}

@props([
    'name' => '',
    'checked' => false,
    'disabled' => false,
    'label' => '',
])

@php
    $checked = filter_var($checked, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
@endphp

<div x-data="{ enabled: @json($checked) }" class="flex items-center">
    <input 
        type="checkbox" 
        @if($name)
            name="{{ $name }}"
        @endif
        x-model="enabled"
        value="1"
        {{ $disabled ? 'disabled' : '' }}
        class="sr-only"
        {{ $attributes->except('class') }}
    />
    
    <button
        type="button"
        x-on:click="enabled = !enabled"
        {{ $disabled ? 'disabled' : '' }}
        x-bind:class="enabled ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-700'"
        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-hidden focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed"
        role="switch"
        x-bind:aria-checked="enabled.toString()"
    >
        <span
            x-bind:class="enabled ? 'translate-x-5' : 'translate-x-0'"
            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
        ></span>
    </button>
    
    @if($label)
        <span class="ml-3 text-sm">
            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $label }}</span>
        </span>
    @endif
</div>

{{-- Usage:
<x-forms.toggle 
    name="notifications_enabled"
    :checked="$user->notifications_enabled"
    label="Enable notifications"
/>

With dynamic label:
<div x-data="{ enabled: false }">
    <x-forms.toggle 
        name="active"
        x-model="enabled"
    />
    <span 
        class="ml-3 text-sm"
        x-text="enabled ? 'Enabled' : 'Disabled'"
    ></span>
</div>

With Livewire:
<x-forms.toggle 
    wire:model.live="settings.notifications"
    label="Email Notifications"
/>
--}}
