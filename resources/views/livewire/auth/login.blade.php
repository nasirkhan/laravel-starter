<div class="flex flex-col gap-6">
    <div class="sm:hidden flex items-center justify-center gap-3">
        <a href="{{ route('home') }}" class="flex items-center gap-3" wire:navigate>
            <x-cube::application-logo class="h-10 rounded fill-current text-black dark:text-white" />
        </a>
    </div>

    <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Welcome back') }}</h1>
    </div>

    <!-- Session Status -->
    <x-cube::auth-session-status class="text-center" :status="session('status')" />

    {{-- Divider --}}
    <div class="flex items-center gap-3">
        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Social Login') }}</span>
        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
    </div>

    {{-- Social Login --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <button type="button" class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            {{ __('Google') }}
        </button>
        <button type="button" class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="#1877F2">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            {{ __('Facebook') }}
        </button>
    </div>

    {{-- Divider --}}
    <div class="flex items-center gap-3">
        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('or') }}</span>
        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
    </div>

    <form wire:submit="login" class="flex flex-col gap-5">
        {{-- Email Address --}}
        <x-cube::group name="email" label="Email" required>
            <x-cube::input class="w-full" type="email" wire:model="email" placeholder="{{ __('Enter your email') }}" required />
        </x-cube::group>

        {{-- Password --}}
        <x-cube::group name="password" label="Password" required>
            <x-cube::input class="w-full" type="password" wire:model="password" required />
        </x-cube::group>

        <div class="flex items-center justify-between">
            <x-cube::checkbox wire:model="remember">{{ __('Remember me') }}</x-cube::checkbox>

            @if (Route::has('password.request'))
                <x-cube::link class="text-sm dark:text-gray-400" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot password?') }}
                </x-cube::link>
            @endif
        </div>

        <x-cube::button class="w-full" variant="primary" type="submit">
            {{ __('Sign in to your account') }}
        </x-cube::button>
    </form>

    @if (Route::has('register'))
        <p class="text-center text-sm text-gray-500 dark:text-gray-400">
            {{ __("Don't have an account yet?") }}
            <x-cube::link :href="route('register')" wire:navigate>{{ __('Sign up here') }}</x-cube::link>
        </p>
    @endif
</div>
