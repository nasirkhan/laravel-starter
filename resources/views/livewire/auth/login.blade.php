<div class="flex flex-col gap-6">
    <x-auth-header
        :title="__('Log in to your account')"
        :description="__('Enter your email and password below to log in')"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        {{-- Email Address --}}
        @php
            $field_name = "email";
            $filed_label = __("Email Address");
            $field_placeholder = $filed_label;
            $required = "required";
        @endphp

        <x-frontend.form.input
            wire:model="{{ $field_name }}"
            type="email"
            :label="$filed_label"
            :required="$required"
        />

        {{-- Password --}}
        @php
            $field_name = "password";
            $filed_label = __("Password");
            $field_placeholder = $filed_label;
            $required = "required";
        @endphp

        <x-frontend.form.input
            wire:model="{{ $field_name }}"
            type="password"
            :label="$filed_label"
            :required="$required"
        />

        <div class="flex items-center justify-between">
            <!-- Remember Me -->
            <x-frontend.form.checkbox wire:model="remember" :label="__('Remember me')" />

            @if (Route::has("password.request"))
                <x-frontend.link class="text-sm" :href="route('password.request')" wire:navigate>
                    {{ __("Forgot your password?") }}
                </x-frontend.link>
            @endif
        </div>

        <div class="flex items-center justify-end">
            <x-button class="w-full" variant="primary" type="submit">
                {{ __("Log in") }}
            </x-button>
        </div>
    </form>

    @if (Route::has("register"))
        <div class="space-x-1 text-center text-sm tracking-widest text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <x-frontend.link :href="route('register')" wire:navigate>{{ __("Sign up") }}</x-frontend.link>
        </div>
    @endif
</div>
