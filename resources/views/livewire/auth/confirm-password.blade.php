<div class="flex flex-col gap-6">
    <x-cube::auth-header
        :title="__('Confirm password')"
        :description="__('This is a secure area of the application. Please confirm your password before continuing.')"
    />

    <!-- Session Status -->
    <x-cube::auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="confirmPassword" class="flex flex-col gap-6">
        {{-- Password --}}
        <x-cube::group name="password" label="Password" required>
            <x-cube::input class="w-full" type="password" wire:model="password" required />
        </x-cube::group>

        <x-cube::button class="w-full" variant="primary" type="submit">
    {{ __("Confirm") }}
</x-cube::button>
    </form>
</div>
