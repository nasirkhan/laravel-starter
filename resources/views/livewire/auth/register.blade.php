<div class="flex flex-col gap-6">
    <div class="sm:hidden flex items-center justify-center gap-3">
        <a href="{{ route('home') }}" class="flex items-center gap-3" wire:navigate>
            <x-cube::application-logo class="h-10 rounded fill-current text-black dark:text-white" />
        </a>
    </div>

    <div class="text-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Create an account') }}</h1>
    </div>

    <!-- Session Status -->
    <x-cube::auth-session-status class="text-center" :status="session('status')" />

    {{-- Social Signup --}}
    <div class="grid grid-cols-1 gap-3">
        <button type="button" class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            {{ __('Sign up with Google') }}
        </button>
        <button type="button" class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
            </svg>
            {{ __('Sign up with Apple') }}
        </button>
    </div>

    {{-- Divider --}}
    <div class="flex items-center gap-3">
        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('or') }}</span>
        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
    </div>

    <form wire:submit="register" class="flex flex-col gap-5">
        <x-cube::group name="name" label="Full Name" required>
            <x-cube::input class="w-full" type="text" wire:model="name" required />
        </x-cube::group>

        <x-cube::group name="email" label="Email" required>
            <x-cube::input class="w-full" type="email" wire:model="email" placeholder="{{ __('Enter your email') }}" required />
        </x-cube::group>

        <x-cube::group name="password" label="Password" required>
            <x-cube::input class="w-full" type="password" wire:model="password" required />
        </x-cube::group>

        <x-cube::group name="password_confirmation" label="Confirm Password" required>
            <x-cube::input class="w-full" type="password" wire:model="password_confirmation" required />
        </x-cube::group>

        <x-cube::button class="w-full" variant="primary" type="submit">
            {{ __('Create your account') }}
        </x-cube::button>
    </form>

    <p class="text-center text-sm text-gray-500 dark:text-gray-400">
        {{ __('Already have an account?') }}
        <x-cube::link class="text-sm" :href="route('login')" wire:navigate>{{ __('Log in') }}</x-cube::link>
    </p>
</div>
