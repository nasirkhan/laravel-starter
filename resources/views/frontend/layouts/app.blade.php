<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->currentLocale()) }}" dir="{{ language_direction() }}">
    <head>
        @include('partials.head')
    </head>

    <body>
        <x-selected-theme />

        @include("frontend.includes.header")

        <main class="bg-white dark:bg-gray-800" id="main-content" role="main">
            @yield("content")
        </main>

        @include("frontend.includes.footer")

        <!-- Scripts -->
        @stack("after-scripts")
    </body>
</html>
