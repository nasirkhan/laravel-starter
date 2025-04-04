<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="{{ setting('meta_description') }}" />
<meta name="keyword" content="{{ setting('meta_keyword') }}" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>{{ $title ?? '' }} | {{ config('app.name') }}</title>

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicon.png') }}" />
<link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />
<link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" />
<link rel="icon" type="image/ico" href="{{ asset('img/favicon.png') }}" />

<!-- Meta Includes -->
@include('frontend.includes.meta')

<!-- Styles -->
@livewireStyles
@vite(['resources/css/app-frontend.css', 'resources/js/app-frontend.js'])
@stack('after-styles')

<!-- Google Analytics -->
<x-google-analytics />