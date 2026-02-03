{{-- Component: Forms Select --}}
{{-- Description: Styled select dropdown with options --}}
{{-- Props: name, options, selected, placeholder, disabled, required --}}

@props([
    'name' => '',
    'options' => [],
    'selected' => '',
    'placeholder' => 'Select an option',
    'disabled' => false,
    'required' => false,
])

@php
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
@endphp

<select
    @if($name)
        name="{{ $name }}"
    @endif
    {{ $disabled ? 'disabled' : '' }}
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge([
        'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm disabled:opacity-50 disabled:cursor-not-allowed'
    ]) }}
>
    @if($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif
    
    @foreach($options as $value => $label)
        <option 
            value="{{ $value }}" 
            {{ $selected == $value ? 'selected' : '' }}
        >
            {{ $label }}
        </option>
    @endforeach
</select>

{{-- Usage:
<x-forms.select 
    name="country" 
    :options="['us' => 'United States', 'ca' => 'Canada', 'uk' => 'United Kingdom']"
    selected="{{ old('country') }}"
    placeholder="Choose a country"
/>

With Alpine.js:
<x-forms.select 
    x-model="category"
    x-on:change="loadSubcategories"
    :options="$categories"
/>

With Livewire:
<x-forms.select 
    wire:model.live="status"
    :options="['active' => 'Active', 'inactive' => 'Inactive']"
/>
--}}
