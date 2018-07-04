<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Laravel starter project. ">
    <meta name="author" content="Nasir Khan Saikat http://nasirkhn.com">
    <meta name="keyword" content="Laravel,Laravel starter,Bootstrap,Admin,Template,Open,Source">
    <link rel="shortcut icon" href="/img/favicon.png">
    <link type="text/plain" rel="author" href="{{asset('humans.txt')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel Starter') }}</title>

    @stack('before-styles')

    <link rel="stylesheet" href="{{ mix('css/app_backend.css') }}">

    <!-- simple-line-icons -->
    <link rel="stylesheet" href="{{asset('plugins/simple-line-icons/css/simple-line-icons.css')}}">

    <!-- fontawesome -->
    <link href="{{asset('plugins/fontawesome/css/fontawesome-all.min.css')}}" rel="stylesheet">

    @stack('after-styles')
</head>

<!-- BODY options, add following classes to body to change options

// Header options
1. '.header-fixed'					- Fixed Header

// Brand options
1. '.brand-minimized'       - Minimized brand (Only symbol)

// Sidebar options
1. '.sidebar-fixed'					- Fixed Sidebar
2. '.sidebar-hidden'				- Hidden Sidebar
3. '.sidebar-off-canvas'		- Off Canvas Sidebar
4. '.sidebar-minimized'			- Minimized Sidebar (Only icons)
5. '.sidebar-compact'			  - Compact Sidebar

// Aside options
1. '.aside-menu-fixed'			- Fixed Aside Menu
2. '.aside-menu-hidden'			- Hidden Aside Menu
3. '.aside-menu-off-canvas'	- Off Canvas Aside Menu

// Breadcrumb options
1. '.breadcrumb-fixed'			- Fixed Breadcrumb

// Footer options
1. '.footer-fixed'					- Fixed footer

-->

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

    <!-- Header Block -->
    @include('backend.includes.header')
    <!-- / Header Block -->

    <div class="app-body">

        <!-- Sidebar -->
        @include('backend.includes.sidebar')
        <!-- /Sidebar -->

        <!-- Main content -->
        <main class="main">

            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                @yield('breadcrumbs')

                <!-- Breadcrumb Menu-->
                <li class="breadcrumb-menu d-md-down-none">
                    <div class="btn-group" role="group" aria-label="Button group">
                        <a class="btn" href="#"><i class="icon-speech"></i></a>
                        <a class="btn" href="{{ route('backend.users.profile') }}">
                            <i class="fas fa-user"></i> &nbsp;Profile
                        </a>
                    </div>
                </li>
            </ol>


            <div class="container-fluid">

                <div class="animated fadeIn">

                    @include('flash::message')

                    <!-- Errors block -->
                    @include('backend.includes.errors')
                    <!-- / Errors block -->

                    @yield('content')

                </div>
                <!-- / animated fadeIn -->

            </div>
            <!-- /.conainer-fluid -->
        </main>

        <!-- aside block -->
        @include('backend.includes.aside')
        <!-- / aside block -->


    </div>

    <!-- Footer block -->
    @include('backend.includes.footer')
    <!-- / Footer block -->

    <!-- Scripts -->
    @stack('before-scripts')

    <script src="{{ mix('js/app_backend.js') }}"></script>

    <script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('#flash-overlay-modal').modal();
    </script>

    @stack('after-scripts')
</body>
</html>
