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

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">

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
                        <a class="btn" href="{{ route('backend.users.profile', auth()->user()->id) }}">
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
        $('[data-toggle="tooltip"]').tooltip();

        $('#flash-overlay-modal').modal();
    })

    </script>

    @stack('after-scripts')
</body>
</html>
