<div class="flex flex-col gap-6">
    <x-cube::auth-header
        :title="__('Forgot password')"
        :description="__('Enter your email to receive a password reset link')"
    />

    <!-- Session Status -->
    <x-cube::auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <x-cube::group name="email" label="Email Address" required>
            <x-cube::input class="w-full" type="email" wire:model="email" required />
        </x-cube::group>

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
