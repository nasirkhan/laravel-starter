{{-- Component: Forms Text Input --}}
{{-- Description: Standard text input with validation and dark mode support --}}
{{-- Props: type, disabled, required, placeholder --}}

@props([
    'type' => 'text',
    'disabled' => false,
    'required' => false,
    'placeholder' => '',
])

@php
    // Validate input type
    $validTypes = ['text', 'email', 'password', 'number', 'tel', 'url', 'search', 'date', 'time', 'datetime-local'];
    $type = in_array($type, $validTypes) ? $type : 'text';
    
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
@endphp

<input
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $required ? 'required' : '' }}
    @if($placeholder)
        placeholder="{{ $placeholder }}"
    @endif
    {{ $attributes->merge([
        'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm disabled:opacity-50 disabled:cursor-not-allowed'
    ]) }}
/>

{{-- Usage:
<x-forms.text-input 
    name="email" 
    type="email" 
    required 
    placeholder="your@email.com"
/>

With Livewire (live validation):
<x-forms.text-input 
    wire:model.live="search" 
    placeholder="Search..." 
/>

With Alpine.js (debounced):
<x-forms.text-input 
    x-model="username"
    x-on:input.debounce.500ms="checkAvailability"
    ::class="{ 'border-green-500': available, 'border-red-500': !available }"
/>
--}}
