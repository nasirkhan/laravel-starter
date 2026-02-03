{{-- Component: Forms Group --}}
{{-- Description: Complete form field with label, input, error, and help text --}}
{{-- Props: label, name, required, help, error --}}

@props([
    'label' => '',
    'name' => '',
    'required' => false,
    'help' => '',
    'error' => null,
])

@php
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    
    // Get error from $errors bag if not provided
    if ($error === null && $name) {
        $error = $errors->get($name);
    }
@endphp

<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    @if($label)
        <x-forms.label 
            :for="$name" 
            :value="$label" 
            :required="$required"
            class="mb-2"
        />
    @endif
    
    <div class="relative">
        {{ $slot }}
    </div>
    
    @if($error)
        <x-forms.error :messages="$error" />
    @endif
    
    @if($help)
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            {{ $help }}
        </p>
    @endif
</div>

{{-- Usage:
<x-forms.group 
    label="Email Address" 
    name="email" 
    required
    help="We'll never share your email">
    <x-forms.text-input 
        name="email" 
        type="email" 
        required 
    />
</x-forms.group>

With Livewire:
<x-forms.group label="Username" name="username" required>
    <x-forms.text-input 
        wire:model.live="username"
        name="username"
    />
</x-forms.group>

With Alpine.js:
<x-forms.group label="Search" name="search">
    <x-forms.text-input 
        x-model="search"
        x-on:input.debounce.500ms="performSearch"
    />
</x-forms.group>
--}}
