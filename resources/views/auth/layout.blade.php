<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="description" content="">
    <meta name="author" content="Nasir Khan Saikat http://nasirkhn.com">

    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <link type="text/plain" rel="author" href="{{asset('humans.txt')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <!-- <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" /> -->
    <link href="{{asset('vendor/now-ui-kit/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('vendor/now-ui-kit/css/now-ui-kit.css?v=1.2.0')}}" rel="stylesheet" />
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">

</head>

<body class="login-page sidebar-collapse">

    <nav class="navbar navbar-expand-lg bg-primary fixed-top navbar-transparent " color-on-scroll="400">
        <div class="container">
            <div class="dropdown button-dropdown">
                <a href="#" class="dropdown-toggle" id="navbarDropdown" data-toggle="dropdown">
                    <span class="button-bar"></span>
                    <span class="button-bar"></span>
                    <span class="button-bar"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-header">Home</a>
                    <a class="dropdown-item" href="#">About</a>
                </div>
            </div>
            <div class="navbar-translate">
                <a class="navbar-brand" href="/" rel="tooltip" title="{{ config('app.name') }} " data-placement="bottom">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation" data-nav-image="{{asset('img/blurred-image-1.jpg')}}">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-header" filter-color="orange">

        @yield('content')

        @include('auth.footer')
    </div>
</body>

<!--   Core JS Files   -->
<script src="{{ asset('vendor/now-ui-kit/js/core/jquery.3.3.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/now-ui-kit/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/now-ui-kit/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/now-ui-kit/js/now-ui-kit.js?v=1.2.0') }}" type="text/javascript"></script>

</html>
