<div>
    <div class="container mx-auto flex justify-center">
        @include('frontend.includes.messages')
    </div>

    <div class="container mx-auto max-w-7xl px-4 py-10 sm:px-6">
        {{-- Email Verification Alert --}}
        @if(Auth::user() && Auth::user()->email_verified_at === null)
            <div class="mb-6 rounded-lg border-2 border-yellow-400 bg-yellow-50 p-4 dark:border-yellow-700 dark:bg-yellow-900/20">
                <div class="flex items-start">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">
                            @lang('Email Not Verified')
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-400">
                            <p>
                                @lang('Your email address has not been verified. Please check your inbox for the verification email.')
                            </p>
                        </div>
                        <div class="mt-4">
                            <button
                                type="button"
                                wire:click="resendEmailConfirmation"
                                wire:loading.attr="disabled"
                                class="rounded-md bg-yellow-50 px-3 py-2 text-sm font-medium text-yellow-800 hover:bg-yellow-100 focus:ring-2 focus:ring-yellow-600 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:outline-hidden disabled:opacity-50 dark:bg-yellow-900/30 dark:text-yellow-300 dark:hover:bg-yellow-900/50"
                            >
                                <span wire:loading.remove wire:target="resendEmailConfirmation">
                                    @lang('Resend Verification Email')
                                </span>
                                <span wire:loading wire:target="resendEmailConfirmation">
                                    @lang('Sending...')
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-10 sm:grid sm:grid-cols-3 sm:gap-6">
            <div class="sm:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-xl font-semibold leading-6 text-gray-800 dark:text-gray-200">
                        @lang("Edit Profile")
                    </h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        @lang("This information will be displayed publicly so be careful what you share.")
                    </p>

                    <div class="pt-4">
                        <x-cube::button-link href="{{ route('frontend.users.profile') }}" wire:navigate variant="secondary" class="w-full">
                            @lang("View Profile")
                        </x-cube::button-link>
                    </div>
                </div>
            </div>

            <div class="mt-5 sm:col-span-2 sm:mt-0">
                <form wire:submit="update" enctype="multipart/form-data">
                    <div class="mb-8 rounded-lg border border-gray-400 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
                        <div class="grid grid-cols-6 gap-6">
                            <x-cube::group name="first_name" :label="__('First Name')" required class="col-span-6 sm:col-span-3">
                                <x-cube::input type="text" name="first_name" wire:model="first_name" :placeholder="__('First Name')" required />
                            </x-cube::group>

                            <x-cube::group name="last_name" :label="__('Last Name')" required class="col-span-6 sm:col-span-3">
                                <x-cube::input type="text" name="last_name" wire:model="last_name" :placeholder="__('Last Name')" required />
                            </x-cube::group>

                            <x-cube::group name="mobile" :label="__('Mobile')" class="col-span-6 sm:col-span-3">
                                <x-cube::input type="text" name="mobile" wire:model="mobile" :placeholder="__('Mobile')" />
                            </x-cube::group>

                            <x-cube::group name="date_of_birth" :label="__('Date Of Birth')" class="col-span-6 sm:col-span-3">
                                <x-cube::input type="date" name="date_of_birth" wire:model="date_of_birth" />
                            </x-cube::group>

                            <x-cube::group name="address" :label="__('Address')" class="col-span-6">
                                <x-cube::input type="text" name="address" wire:model="address" :placeholder="__('Address')" />
                            </x-cube::group>

                            <x-cube::group name="bio" :label="__('Bio')" class="col-span-6">
                                <x-cube::textarea name="bio" wire:model="bio" :placeholder="__('Bio')" rows="3"></x-cube::textarea>
                            </x-cube::group>

                            <x-cube::group name="url" :label="__('Website URL')" class="col-span-6 sm:col-span-3">
                                <x-cube::input type="url" name="url" wire:model="url" :placeholder="__('Website URL')" />
                            </x-cube::group>

                            <x-cube::group name="url_text" :label="__('Website Link Text')" class="col-span-6 sm:col-span-3">
                                <x-cube::input type="text" name="url_text" wire:model="url_text" :placeholder="__('Website Link Text')" />
                            </x-cube::group>

                            <x-cube::group name="gender" :label="__('Gender')" class="col-span-6 sm:col-span-3">
                                <x-cube::select name="gender" wire:model="gender">
                                    <option value="">-- Select an option --</option>
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Other">Other</option>
                                </x-cube::select>
                            </x-cube::group>

                            <x-cube::group name="avatar" :label="__('Avatar')" class="col-span-6 sm:col-span-3">
                                <x-cube::file-input name="avatar" wire:model="avatar" accept="image/*" />
                                @if($avatar)
                                    <div class="mt-2">
                                        <img src="{{ $avatar->temporaryUrl() }}" class="h-20 w-20 rounded-md object-cover" alt="Preview" />
                                    </div>
                                @endif
                            </x-cube::group>
                        </div>

                        <div class="mt-6 px-6">
                            <x-cube::button type="submit" variant="primary" class="w-full" wire:loading.attr="disabled">
                                <span wire:loading.remove>@lang('Save')</span>
                                <span wire:loading>@lang('Saving...')</span>
                            </x-cube::button>
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
            <div class="sm:grid sm:grid-cols-3 sm:gap-6">
                <div class="sm:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-800 dark:text-gray-200">Account Settings</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update account information.</p>
                    </div>
                </div>
                <div class="mt-5 sm:col-span-2 sm:mt-0">
                    <div class="mb-8 rounded-lg border border-gray-400 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
                        <x-cube::button-link href="{{ route('frontend.users.changePassword') }}" wire:navigate variant="secondary" class="w-full">
                            @lang('Change Password')
                        </x-cube::button-link>
                    </div>
                </div>
            </div>
        </div>

        @if($user->providers && $user->providers->count() > 0)
            <div class="hidden sm:block" aria-hidden="true">
                <div class="mb-10 py-4">
                    <div class="border-t border-gray-200 dark:border-gray-700"></div>
                </div>
            </div>

            <div class="mb-10 mt-10 sm:mt-0">
                <div class="sm:grid sm:grid-cols-3 sm:gap-6">
                    <div class="sm:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-800 dark:text-gray-200">Connected Accounts</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage your social authentication providers.</p>
                        </div>
                    </div>
                    <div class="mt-5 sm:col-span-2 sm:mt-0">
                        <div class="mb-8 rounded-lg border border-gray-400 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
                            <div class="space-y-4">
                                @foreach($user->providers as $provider)
                                    <div class="flex items-center justify-between rounded-md border border-gray-200 p-4 dark:border-gray-700">
                                        <div class="flex items-center">
                                            <div class="shrink-0">
                                                @if($provider->provider === 'github')
                                                    <i class="fab fa-github text-2xl text-gray-800 dark:text-gray-200"></i>
                                                @elseif($provider->provider === 'google')
                                                    <i class="fab fa-google text-2xl text-red-500"></i>
                                                @elseif($provider->provider === 'facebook')
                                                    <i class="fab fa-facebook text-2xl text-blue-600"></i>
                                                @elseif($provider->provider === 'twitter')
                                                    <i class="fab fa-twitter text-2xl text-blue-400"></i>
                                                @else
                                                    <i class="fas fa-link text-2xl text-gray-500"></i>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ ucfirst($provider->provider) }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    Connected on {{ $provider->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <x-cube::button
                                                type="button"
                                                variant="danger"
                                                wire:click="unlinkProvider({{ $provider->id }})"
                                                wire:loading.attr="disabled"
                                                wire:confirm="Are you sure you want to unlink this {{ $providerNames[$provider->id] ?? $provider->provider }} account?"
                                                aria-label="@lang('Unlink Provider')"
                                            >
                                                <span wire:loading.remove wire:target="unlinkProvider({{ $provider->id }})">
                                                    <i class="fas fa-unlink me-1"></i>
                                                    @lang('Unlink')
                                                </span>
                                                <span wire:loading wire:target="unlinkProvider({{ $provider->id }})">
                                                    <i class="fas fa-spinner fa-spin me-1"></i>
                                                    @lang('Unlinking...')
                                                </span>
                                            </x-cube::button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
