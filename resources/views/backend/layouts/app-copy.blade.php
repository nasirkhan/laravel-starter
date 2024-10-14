<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->currentLocale()) }}" dir="{{ language_direction() }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
        <link rel="icon" type="image/png" href="{{ asset("img/favicon.png") }}" />
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset("img/favicon.png") }}" />
        <meta name="keyword" content="{{ setting("meta_keyword") }}" />
        <meta name="description" content="{{ setting("meta_description") }}" />

        <!-- Shortcut Icon -->
        <link rel="shortcut icon" href="{{ asset("img/favicon.png") }}" />
        <link rel="icon" type="image/ico" href="{{ asset("img/favicon.png") }}" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield("title") | {{ config("app.name") }}</title>

        <script src="{{ asset("vendor/jquery/jquery-3.6.4.min.js") }}"></script>

        @vite(["resources/sass/app-backend.scss", "resources/js/app-backend.js"])

        <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+Bengali+UI&display=swap" rel="stylesheet" />
        <style>
            body {
                font-family: Ubuntu, 'Noto Sans Bengali UI', Arial, Helvetica, sans-serif;
            }
        </style>

        @livewireStyles

        @stack("after-styles")

        <x-google-analytics />
    </head>

    <body>
        <!-- Sidebar -->
        @include("backend.includes.sidebar")
        <!-- /Sidebar -->

        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
            <!-- Header -->
            @include("backend.includes.header")
            <!-- /Header -->

            <div class="body flex-grow-1">
                <div class="container-lg">
                    @include("flash::message")

                    <!-- Errors block -->
                    @include("backend.includes.errors")
                    <!-- / Errors block -->

                    <!-- Main content block -->
                    @yield("content")
                    <!-- / Main content block -->
                </div>
            </div>

            <!-- Footer block -->
            @include("backend.includes.footer")
            <!-- / Footer block -->
        </div>

        <!-- Scripts -->
        @livewireScripts

        @stack("after-scripts")
        <!-- / Scripts -->
    </body>
</html>
