{{-- Component: Forms Textarea --}}
{{-- Description: Styled textarea with character count support --}}
{{-- Props: name, rows, disabled, required, placeholder, maxlength --}}

@props([
    'name' => '',
    'rows' => 4,
    'disabled' => false,
    'required' => false,
    'placeholder' => '',
    'maxlength' => null,
])

@php
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $rows = max(2, (int)$rows);
@endphp

<textarea
    @if($name)
        name="{{ $name }}"
    @endif
    rows="{{ $rows }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $required ? 'required' : '' }}
    @if($placeholder)
        placeholder="{{ $placeholder }}"
    @endif
    @if($maxlength)
        maxlength="{{ $maxlength }}"
    @endif
    {{ $attributes->merge([
        'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm disabled:opacity-50 disabled:cursor-not-allowed w-full'
    ]) }}
>{{ $slot }}</textarea>

{{-- Usage:
<x-forms.textarea 
    name="description" 
    rows="6" 
    placeholder="Enter description..."
    maxlength="500"
/>

With Alpine.js character counter:
<div x-data="{ content: '', max: 500 }">
    <x-forms.textarea 
        x-model="content"
        maxlength="500"
    />
    <div class="text-sm text-gray-500 mt-2">
        <span x-text="content.length"></span> / <span x-text="max"></span> characters
    </div>
</div>

With Livewire:
<x-forms.textarea 
    wire:model.live.debounce.500ms="bio"
    rows="5"
/>
--}}
