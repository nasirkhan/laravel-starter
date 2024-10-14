<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route("login") }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                class="mt-1 block w-full"
                id="email"
                name="email"
                type="email"
                :value="old('email')"
                required
                autocomplete="email"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input
                class="mt-1 block w-full"
                id="password"
                name="password"
                type="password"
                required
                autocomplete="current-password"
            />
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me -->
        <div class="mt-4 block">
            <label class="inline-flex items-center" for="remember_me">
                <input
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    id="remember_me"
                    name="remember"
                    type="checkbox"
                />
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __("Remember me") }}</span>
            </label>
        </div>

        <div class="mt-4 flex items-center justify-end">
            @if (Route::has("password.request"))
                <a
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                    href="{{ route("password.request") }}"
                >
                    {{ __("Forgot your password?") }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __("Log in") }}
            </x-primary-button>
        </div>
    </form>

    <div class="py-2 text-gray-600 dark:text-gray-400">
        {{ __("Create an account?") }}
        <a class="underline" href="{{ route("register") }}">{{ __("Register") }}</a>
    </div>
</x-guest-layout>
