<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title') | {{ config('app.name', 'Laravel Starter') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keyword" content="{{ setting('meta_keyword') }}">

    @include('frontend.includes.meta')

    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <link rel="icon" type="image/ico" href="{{asset('img/favicon.png')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('before-styles')

    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+Bengali+UI&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ mix('css/frontend.css') }}">

    @stack('after-styles')

</head>

<body class="{{isset($body_class) ? $body_class : ''}} sidebar-collapse">

    <!-- Header Block -->
    @include('frontend.includes.header')
    <!-- / Header Block -->

    <div class="wrapper">

        @yield('content')

        <!-- Footer block -->
        @include('frontend.includes.footer')
        <!-- / Footer block -->
    </div>
</body>

<!-- Scripts -->
@stack('before-scripts')

<script src="{{ mix('js/frontend.js') }}"></script>

@stack('after-scripts')

</html>
