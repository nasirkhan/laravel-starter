<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="description" content="Laravel Starter Application. A boilarplate to all type of application.">
    <meta name="author" content="Nasir Khan Saikat http://nasirkhn.com">

    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <link type="text/plain" rel="author" href="{{asset('humans.txt')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('before-styles')

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <!-- <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" /> -->
    <link href="{{asset('vendor/now-ui-kit/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('vendor/now-ui-kit/css/now-ui-kit.css?v=1.2.0')}}" rel="stylesheet" />
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <link href="{{asset('plugins/fontawesome/css/fontawesome-all.min.css')}}" rel="stylesheet">

    @stack('after-styles')

</head>

<body class="{{$body_class}} sidebar-collapse">

    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '569561286532601',
                cookie     : true,
                xfbml      : true,
                version    : '2.12'
            });

            FB.AppEvents.logPageView();
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

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

<!--   Core JS Files   -->
<script src="{{ asset('vendor/now-ui-kit/js/core/jquery.3.3.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/now-ui-kit/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/now-ui-kit/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{ asset('vendor/now-ui-kit/js/plugins/bootstrap-switch.js') }}"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{ asset('vendor/now-ui-kit/js/plugins/nouislider.min.js') }}" type="text/javascript"></script>
<!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
<script src="{{ asset('vendor/now-ui-kit/js/plugins/bootstrap-datepicker.js') }}" type="text/javascript"></script>
<!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('vendor/now-ui-kit/js/now-ui-kit.js?v=1.2.0') }}" type="text/javascript"></script>


@stack('after-scripts')

</html>
