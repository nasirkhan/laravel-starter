{{-- Component: Forms Label --}}
{{-- Description: Form label with required indicator --}}
{{-- Props: for, value, required --}}

@props([
    'for' => '',
    'value' => '',
    'required' => false,
])

@php
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
@endphp

<label 
    @if($for)
        for="{{ $for }}"
    @endif
    {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}
>
    {{ $value ?: $slot }}
    @if($required)
        <span class="text-red-600 dark:text-red-400 ml-1" aria-label="required">*</span>
    @endif
</label>

{{-- Usage:
<x-forms.label for="email" value="Email Address" required />
<x-forms.text-input id="email" name="email" type="email" />

Or with slot:
<x-forms.label for="username" required>
    Username
</x-forms.label>
--}}
