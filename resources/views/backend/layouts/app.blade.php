<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Laravel starter project. ">
    <meta name="author" content="Nasir Khan Saikat">
    <meta name="keyword" content="Laravel,Laravel starter,Bootstrap,Admin,Template,Open,Source">
    <link rel="shortcut icon" href="img/favicon.png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Icons -->
    @stack('before-styles')

    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simple-line-icons.css') }}" rel="stylesheet">

    <!-- Main Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('after-styles')
</head>
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
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>

                <!-- Breadcrumb Menu-->
                <li class="breadcrumb-menu d-md-down-none">
                    <div class="btn-group" role="group" aria-label="Button group">
                        <a class="btn" href="#"><i class="icon-speech"></i></a>
                        <a class="btn" href="./"><i class="icon-graph"></i> &nbsp;Dashboard</a>
                        <a class="btn" href="#"><i class="icon-settings"></i> &nbsp;Settings</a>
                    </div>
                </li>
            </ol>


            <div class="container-fluid">

                <div class="animated fadeIn">

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

    <!-- Necessary plugins -->
    @stack('before-scripts')
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('plugins/popper/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/pace/pace.min.js') }}"></script>

    <script src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script>

    <!-- main scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    </script>
    @stack('after-scripts')
</body>
</html>
