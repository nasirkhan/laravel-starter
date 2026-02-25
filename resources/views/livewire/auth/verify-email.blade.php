<div class="mt-4 flex flex-col gap-6">
    <div class="text-center">
        {{ __("Please verify your email address by clicking on the link we just emailed to you.") }}
    </div>

    @if (session("status") == "verification-link-sent")
        <div class="!dark:text-green-400 text-center font-medium !text-green-600">
            {{ __("A new verification link has been sent to the email address you provided during registration.") }}
        </div>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <x-cube::link wire:click="sendVerification" class="w-full">
            {{ __("Resend Verification Email") }}
        </x-cube::link>

        <x-cube::link wire:click="logout">{{ __("Log out") }}</x-cube::link>
    </div>
</div>
