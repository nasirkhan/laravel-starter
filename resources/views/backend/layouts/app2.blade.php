<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <meta name="description" content="Laravel starter project. ">
    <meta name="author" content="Nasir Khan Saikat">
    <meta name="keyword" content="Laravel,Laravel starter,Bootstrap,Admin,Template,Open,Source">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />

    @stack('before-styles')

    <link rel="stylesheet" href="{{ mix('css/app_backend.css') }}">

    <script src="/js/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

    @stack('after-styles')
</head>

<body class="">
    <div class="wrapper">

        <!-- Sidebar -->
        @include('backend.includes.sidebar')
        <!-- /Sidebar -->

        <div class="main-panel">
            <!-- Header -->
            @include('backend.includes.header')
            <!-- Header -->

            @include('flash::message')

            <!-- Errors block -->
            @include('backend.includes.errors')
            <!-- / Errors block -->

            @yield('content')


        </div>

        <!-- Footer -->
        @include('backend.includes.footer')
        <!-- /Footer -->
    </div>
</body>

<!--   Core JS Files   -->
@stack('before-scripts')

<script src="{{ mix('js/app_backend.js') }}"></script>

@stack('after-scripts')
</html>
