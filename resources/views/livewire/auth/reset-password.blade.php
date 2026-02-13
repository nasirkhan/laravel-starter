<div class="flex flex-col gap-6">
    <x-frontend.auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

    <!-- Session Status -->
    <x-frontend.auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        {{-- Email Address --}}
        <x-cube::group name="email" label="Email Address" required>
            <x-cube::input class="w-full" type="email" wire:model="email" required />
        </x-cube::group>

        {{-- Password --}}
        <x-cube::group name="password" label="Password" required>
            <x-cube::input class="w-full" type="password" wire:model="password" required />
        </x-cube::group>

        {{-- Confirm Password --}}
        <x-cube::group name="password_confirmation" label="Confirm Password" required>
            <x-cube::input class="w-full" type="password" wire:model="password_confirmation" required />
        </x-cube::group>

        <div class="flex items-center justify-end">
            <x-cube::button class="w-full" variant="primary" type="submit">
                {{ __("Reset password") }}
            </x-frontend.button>
        </div>
    </form>
</div>
