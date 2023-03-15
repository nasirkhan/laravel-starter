<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keyword" content="{{ setting('meta_keyword') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    @stack('before-styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('after-styles')

    <!-- Analytics -->
    <x-google-analytics config="{{ setting('google_analytics') }}" />
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

    <!-- Scripts -->
    <script type="module" src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>