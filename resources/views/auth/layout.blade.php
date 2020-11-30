<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keyword" content="{{ setting('meta_keyword') }}">

    @include('frontend.includes.meta')

    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <link rel="icon" type="image/ico" href="{{asset('img/favicon.png')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('before-styles')

    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">

    @stack('after-styles')

    <x-google-analytics config="{{ setting('google_analytics') }}" />
</head>

<body class="bg-white">

    <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{asset('img/logo-with-text.jpg')}}" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="/">
                                <img src="{{asset('img/logo-with-text-dark.png')}}" height="40">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>

                @guest
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            <span class="nav-link-inner--text">Login</span>
                        </a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link">
                            <span class="nav-link-inner--text">Register</span>
                        </a>
                    </li>
                    @endif
                </ul>
                @endguest

                <hr class="d-lg-none" />
                <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="#" target="_blank" data-toggle="tooltip" data-original-title="Like us on Facebook">
                            <i class="fab fa-facebook-square"></i>
                            <span class="nav-link-inner--text d-lg-none">Facebook</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="#" target="_blank" data-toggle="tooltip" data-original-title="Follow us on Instagram">
                            <i class="fab fa-instagram"></i>
                            <span class="nav-link-inner--text d-lg-none">Instagram</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="#" target="_blank" data-toggle="tooltip" data-original-title="Follow us on Twitter">
                            <i class="fab fa-twitter-square"></i>
                            <span class="nav-link-inner--text d-lg-none">Twitter</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="#" target="_blank" data-toggle="tooltip" data-original-title="Star us on Github">
                            <i class="fab fa-github"></i>
                            <span class="nav-link-inner--text d-lg-none">Github</span>
                        </a>
                    </li>
                    <li class="nav-item d-none d-lg-block ml-lg-4">
                        <a href="#" target="_blank" class="btn btn-neutral btn-icon">
                            <span class="btn-inner--icon">
                                <i class="fas fa-paper-plane mr-2"></i>
                            </span>
                            <span class="nav-link-inner--text">Upgrade to Pro</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    @include('auth.footer')

    @stack('before-scripts')

    <script src="{{ mix('js/dashboard.js') }}"></script>

    @stack('after-scripts')

</body>

</html>
