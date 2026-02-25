<div class="flex flex-col gap-6">
    <x-cube::auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-cube::auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <x-cube::group name="name" label="Full Name" required>
            <x-cube::input class="w-full" type="text" wire:model="name" required />
        </x-cube::group>

        <!-- Email Address -->
        <x-cube::group name="email" label="Email Address" required>
            <x-cube::input class="w-full" type="email" wire:model="email" required />
        </x-cube::group>

        <!-- Password -->
        <x-cube::group name="password" label="Password" required>
            <x-cube::input class="w-full" type="password" wire:model="password" required />
        </x-cube::group>

        <!-- Confirm Password -->
        <x-cube::group name="password_confirmation" label="Confirm Password" required>
            <x-cube::input class="w-full" type="password" wire:model="password_confirmation" required />
        </x-cube::group>

        <div class="flex items-center justify-end">
            <x-cube::button class="w-full" variant="primary" type="submit">
                {{ __('Create account') }}
            </x-cube::button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 tracking-widest dark:text-zinc-400">
        {{ __('Already have an account?') }}

        <x-cube::link class="text-sm" :href="route('login')" wire:navigate>
            {{ __('Log in') }}
        </x-cube::link>
    </div>
</div>
