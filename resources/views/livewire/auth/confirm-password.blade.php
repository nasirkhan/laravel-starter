<div class="flex flex-col gap-6">
    <x-frontend.auth-header
        :title="__('Confirm password')"
        :description="__('This is a secure area of the application. Please confirm your password before continuing.')"
    />

    <!-- Session Status -->
    <x-frontend.auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="confirmPassword" class="flex flex-col gap-6">
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

        <x-cube::button class="w-full" variant="primary" type="submit">
            {{ __("Confirm") }}
        </x-frontend.button>
    </form>
</div>
