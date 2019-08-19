<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="author" content="Nasir Khan Saikat http://nasirkhn.com">
    <meta name="keyword" content="{{ setting('meta_keyword') }}">
    <link rel="shortcut icon" href="/img/favicon.png">
    <link type="text/plain" rel="author" href="{{asset('humans.txt')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel Starter') }}</title>

    @stack('before-styles')

    <link rel="stylesheet" href="{{ mix('css/app_backend.css') }}">

    <!-- simple-line-icons -->
    <link rel="stylesheet" href="{{asset('plugins/simple-line-icons/css/simple-line-icons.css')}}">

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
                        {{ date('l, F d, Y') }}&nbsp;<div id="openClockDisplay" class="clock" onload="showTime()"></div>
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

        showTime();
    })

    function showTime(){
        var date = new Date();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();

        var session = hours >= 12 ? 'pm' : 'am';

        hours = hours % 12;
        hours = hours ? hours : 12;
        minutes = minutes < 10 ? '0'+minutes : minutes;

        var time = hours + ":" + minutes + ":" + seconds + " " + session;
        document.getElementById("openClockDisplay").innerText = time;
        document.getElementById("openClockDisplay").textContent = time;

        setTimeout(showTime, 1000);
    }

    </script>

    @stack('after-scripts')
</body>
</html>
