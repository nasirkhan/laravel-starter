<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ language_direction() }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-gray-950">
        <x-selected-theme />
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 bg-gray-50 p-6 dark:bg-gray-950 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="mb-1 flex items-center justify-center rounded-md">
                        <x-cube::application-logo class="h-10 rounded fill-current text-black dark:text-white" />
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ config('app.name') }}</span>
                </a>
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
