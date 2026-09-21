<div>
    <div class="container mx-auto flex justify-center">
        @include('frontend.includes.messages')
    </div>

    <div class="container mx-auto max-w-7xl px-4 py-10 sm:px-6">
        <div class="mb-10 md:grid md:grid-cols-3 md:gap-6">
            <div class="sm:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-xl font-semibold leading-6 text-gray-800 dark:text-gray-200">
                        @lang('Change Password')
                    </h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        @lang('Use the following form to change your account password!')
                    </p>

                    <div class="pt-4">
                        <x-cube::button-link href="{{ route('frontend.users.profile') }}" wire:navigate variant="secondary" class="w-full">
                            @lang('View Profile')
                        </x-cube::button-link>
                    </div>
                </div>
            </div>

            <div class="mt-5 sm:col-span-2 md:mt-0">
                <form wire:submit="updatePassword">
                    <div class="mb-8 rounded-lg border border-gray-400 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
                        <div class="grid grid-cols-6 gap-6">
                            <x-cube::group name="password" :label="__('Password')" required class="col-span-6 sm:col-span-3">
                                <x-cube::input type="password" name="password" wire:model="password" required />
                            </x-cube::group>

                            <x-cube::group name="password_confirmation" :label="__('Confirm Password')" required class="col-span-6 sm:col-span-3">
                                <x-cube::input type="password" name="password_confirmation" wire:model="password_confirmation" required />
                            </x-cube::group>

                            <div class="col-span-6 bg-gray-50 py-3 text-end dark:bg-gray-700">
                                <x-cube::button type="submit" variant="primary" class="w-full">
                                    @lang('Update Password')
                                </x-cube::button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
            <div class="mb-10 py-4">
                <div class="border-t border-gray-200 dark:border-gray-700"></div>
            </div>
        </div>

        <div class="mb-10 mt-10 sm:mt-0">
            <div class="grid grid-cols-1 sm:grid-cols-3 sm:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-800 dark:text-gray-200">
                            @lang("Edit Profile")
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            @lang("Update account information.")
                        </p>
                    </div>
                </div>
                <div class="mt-5 sm:col-span-2 md:mt-0">
                    <div class="mb-8 rounded-lg border border-gray-400 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
                        <x-cube::button-link href="{{ route('frontend.users.profileEdit') }}" wire:navigate variant="secondary" class="w-full">
                            @lang("Edit Profile")
                        </x-cube::button-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
