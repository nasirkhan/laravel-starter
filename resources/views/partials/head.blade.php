<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

{{-- Page-specific Head API calls (OG type overrides, article/profile meta, etc.) --}}
@include('frontend.includes.meta')

@php
    // Backward-compatible title bridge: propagate @section('title') / $title into
    // laravel/head so @head renders <title> and fills og:title / twitter:title.
    // Controllers that call Head::title() directly will have their value replaced by
    // this bridge when a @section('title') is also defined; prefer one or the other
    // per page, not both simultaneously.
    $__sectionTitle = trim($__env->yieldContent('title', $title ?? ''));
    if ($__sectionTitle !== '') {
        \Laravel\Head\Facades\Head::title($__sectionTitle, suffix: ' | ' . config('app.name'));
    }
@endphp

@head

{{-- Repeatable same-property tags pushed from meta.blade.php (e.g. article:tag) --}}
@stack('head-meta')

<!-- Styles -->
@livewireStyles
@vite(['resources/css/app-frontend.css', 'resources/js/app-frontend.js'])
@stack('after-styles')

<!-- Google Analytics -->
<x-cube::google-analytics />
