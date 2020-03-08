<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/favicon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="description" content="{{ setting('meta_description') }}">
    <meta name="keyword" content="{{ setting('meta_keyword') }}">

    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}">
    <link type="text/plain" rel="author" href="{{asset('humans.txt')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('before-styles')

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+Bengali+UI&display=swap" rel="stylesheet" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ mix('css/frontend.css') }}">

    @stack('after-styles')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-20163741-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '');
    </script>

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
                    <a class="dropdown-item" href="#" target="_blank">About</a>
                </div>
            </div>
            <div class="navbar-translate">
                <a class="navbar-brand" href="/" rel="tooltip" title="{{ config('app.name', 'Laravel Starter') }} - Application Login Page" data-placement="bottom">
                    {{app_name()}}
                </a>
                <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar top-bar"></span>
                    <span class="navbar-toggler-bar middle-bar"></span>
                    <span class="navbar-toggler-bar bottom-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navigation" data-nav-image="{{asset('img/blurred-image-1.jpg')}}">
                <ul class="navbar-nav">
                    @if(user_registration())
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary" href="{{ route('register') }}">
                            <strong><i class="now-ui-icons business_badge"></i> {{ __("labels.text.register") }}</strong>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-header" filter-color="orange">

        @yield('content')

        @include('auth.footer')
    </div>
</body>

<!-- Scripts -->
@stack('before-scripts')

<script src="https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js"></script>
<script src="{{ mix('js/frontend.js') }}"></script>

@stack('after-scripts')
</html>
