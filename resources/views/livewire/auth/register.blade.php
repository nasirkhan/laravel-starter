<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        @php
            $field_name = "name";
            $filed_label = __("Full Name");
            $field_placeholder = $filed_label;
            $required = "required";
        @endphp

        <x-frontend.form.input
            wire:model="{{ $field_name }}"
            type="text"
            :label="$filed_label"
            :required="$required"
        />

        <!-- Email Address -->
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

        <!-- Password -->
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

        <!-- Confirm Password -->
        @php
            $field_name = "password_confirmation";
            $filed_label = __("Confirm Password");
            $field_placeholder = $filed_label;
            $required = "required";
        @endphp

        <x-frontend.form.input
            wire:model="{{ $field_name }}"
            type="password"
            :label="$filed_label"
            :required="$required"
        />

        <div class="flex items-center justify-end">
            <x-button class="w-full" variant="primary" type="submit">
                {{ __('Create account') }}
            </x-button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 tracking-widest dark:text-zinc-400">
        {{ __('Already have an account?') }}

        <x-frontend.link class="text-sm" :href="route('login')" wire:navigate>
            {{ __('Log in') }}
        </x-frontend.link>
    </div>
</div>
