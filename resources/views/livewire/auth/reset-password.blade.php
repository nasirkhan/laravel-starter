<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
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
        
        {{-- Confirm Password --}}
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
                {{ __("Reset password") }}
            </x-button>
        </div>
    </form>
</div>
