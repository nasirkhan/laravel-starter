<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->currentLocale()) }}" dir="{{ language_direction() }}" class="scroll-smooth">
    <head>
        @include('partials.head')
    </head>

    <body class="antialiased font-sans text-gray-900 dark:text-white">
        <x-selected-theme />

        @include("frontend.includes.header")

        <main class="min-h-screen bg-white dark:bg-gray-800" id="main-content" role="main">
            @yield("content")
        </main>

        @include("frontend.includes.footer")

        <!-- Scripts -->
        @stack("after-scripts")
    </body>
</html>
