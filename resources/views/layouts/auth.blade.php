<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ language_direction() }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50 antialiased dark:bg-gray-950">
        <x-selected-theme />

        <div class="flex flex-col sm:flex-row max-w-6xl justify-center mx-auto min-h-screen">
            {{-- Left Panel --}}
            <div class="hidden sm:flex sm:w-1/2 xl:w-2/5 flex-col justify-around px-10 py-12">
                <a href="{{ route('home') }}" class="flex items-center gap-3" wire:navigate>
                    <x-cube::application-logo class="h-12 rounded fill-current text-black dark:text-white" />
                </a>

                <div class="space-y-10">
                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0 w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ __('Get started quickly') }}</p>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">{{ __('Integrate with developer-friendly APIs or choose low-code.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0 w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ __('Support any business model') }}</p>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">{{ __('Manage your data and workflows in a secure, private environment.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="mt-0.5 shrink-0 w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ __('Built for teams of all sizes') }}</p>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">{{ __('Trusted by ambitious startups and enterprises of every size.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-6 text-sm text-gray-500 dark:text-gray-400">
                    <a href="#" class="hover:text-gray-700 dark:hover:text-gray-200 transition-colors">{{ __('About') }}</a>
                    <a href="#" class="hover:text-gray-700 dark:hover:text-gray-200 transition-colors">{{ __('Terms & Conditions') }}</a>
                    <a href="#" class="hover:text-gray-700 dark:hover:text-gray-200 transition-colors">{{ __('Contact') }}</a>
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="flex flex-1 items-center justify-center p-6 lg:p-12">
                <div class="w-full max-w-md">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8 md:p-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
