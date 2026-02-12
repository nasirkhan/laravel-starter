<div class="flex flex-col gap-6">
    <x-frontend.auth-header
        :title="__('Forgot password')"
        :description="__('Enter your email to receive a password reset link')"
    />

    <!-- Session Status -->
    <x-frontend.auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
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

        <div class="flex items-center justify-end">
            <x-cube::button class="w-full" variant="primary" type="submit">
                {{ __("Email password reset link") }}
            </x-frontend.button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600">
        {{ __("Or, return to") }}
        <x-cube::link class="text-sm" :href="route('login')" wire:navigate>
            {{ __("log in") }}
        </x-cube::link>
    </div>
</div>
