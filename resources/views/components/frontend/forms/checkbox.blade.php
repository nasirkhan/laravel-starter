{{-- Component: Forms Checkbox --}}
{{-- Description: Styled checkbox input with label support --}}
{{-- Props: name, value, checked, disabled, required --}}

@props([
    'name' => '',
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'required' => false,
])

@php
    $checked = filter_var($checked, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
@endphp

<input
    type="checkbox"
    @if($name)
        name="{{ $name }}"
    @endif
    value="{{ $value }}"
    {{ $checked ? 'checked' : '' }}
    {{ $disabled ? 'disabled' : '' }}
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge([
        'class' => 'rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800 disabled:opacity-50 disabled:cursor-not-allowed'
    ]) }}
/>

{{-- Usage:
<label class="flex items-center">
    <x-forms.checkbox name="remember" />
    <span class="ml-2 text-sm">Remember me</span>
</label>

With Alpine.js:
<label class="flex items-center">
    <x-forms.checkbox x-model="agreed" />
    <span class="ml-2 text-sm">I agree to the terms</span>
</label>

With Livewire:
<x-forms.checkbox wire:model.live="terms_agreed" />
--}}
