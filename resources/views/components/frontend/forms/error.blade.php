{{-- Component: Forms Input Error --}}
{{-- Description: Display validation errors for form fields --}}
{{-- Props: messages --}}

@props([
    'messages' => [],
])

@php
    // Ensure messages is always an array
    if (is_string($messages)) {
        $messages = [$messages];
    } elseif (!is_array($messages)) {
        $messages = [];
    }
    
    // Filter out empty messages
    $messages = array_filter($messages);
@endphp

@if (count($messages) > 0)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1 mt-2']) }}>
        @foreach ($messages as $message)
            <li class="flex items-start">
                <svg class="h-5 w-5 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <span>{{ $message }}</span>
            </li>
        @endforeach
    </ul>
@endif

{{-- Usage:
<x-forms.text-input name="email" />
<x-forms.error :messages="$errors->get('email')" />

Multiple errors:
<x-forms.error :messages="$errors->all()" />

Single error:
<x-forms.error messages="This field is required" />
--}}
