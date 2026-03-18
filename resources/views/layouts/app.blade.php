<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ language_direction() }}">
    <head>
        @include('partials.head')
    </head>

    <body>
        @include('frontend.includes.header')

        <main>
            {{ $slot }}
        </main>

        @include('frontend.includes.footer')

        @livewireScripts
        @stack('after-scripts')
    </body>
</html>
