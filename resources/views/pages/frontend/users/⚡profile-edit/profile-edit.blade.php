<div>
    <div class="container mx-auto flex justify-center">
        @include('frontend.includes.messages')
    </div>

    <div class="container mx-auto max-w-7xl px-4 py-10 sm:px-6">
        {{-- Email Verification Alert --}}
        @if(Auth::user() && Auth::user()->email_verified_at === null)
            <div class="mb-6 rounded-lg border-2 border-yellow-400 bg-yellow-50 p-4 dark:bg-yellow-100">
                <div class="flex items-start">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-yellow-800">
                            @lang('Email Not Verified')
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>
                                @lang('Your email address has not been verified. Please check your inbox for the verification email.')
                            </p>
                        </div>
                        <div class="mt-4">
                            <button
                                type="button"
                                wire:click="resendEmailConfirmation"
                                wire:loading.attr="disabled"
                                class="rounded-md bg-yellow-50 px-3 py-2 text-sm font-medium text-yellow-800 hover:bg-yellow-100 focus:ring-2 focus:ring-yellow-600 focus:ring-offset-2 focus:ring-offset-yellow-50 focus:outline-hidden disabled:opacity-50"
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

                    <div class="pt-4 text-center">
                        <a href="{{ route('frontend.users.profile') }}" wire:navigate>
                            <div
                                class="w-full rounded-sm border-2 border-gray-900 px-6 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in hover:bg-gray-800 hover:text-white focus:outline-hidden dark:border-gray-500"
                            >
                                @lang(" View Profile")
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-5 sm:col-span-2 sm:mt-0">
                <form wire:submit="update" enctype="multipart/form-data">
                    <div class="mb-8 rounded-lg border border-gray-400 bg-white p-6 shadow-lg dark:bg-gray-100">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
    <label for="first_name" id="first_name-label" class="block text-sm font-medium text-gray-700">
        @lang('First Name') <span class="text-red-500">*</span>
    </label>
    <input
        type="text"
        wire:model="first_name"
        id="first_name"
        placeholder="@lang('First Name')"
        required
        class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 placeholder-gray-300 shadow-sm focus:border-transparent focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:bg-gray-100"
        aria-labelledby="first_name-label"
    />
    @error('first_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
</div>

                            <div class="col-span-6 sm:col-span-3">
    <label for="last_name" id="last_name-label" class="block text-sm font-medium text-gray-700">
        @lang('Last Name') <span class="text-red-500">*</span>
    </label>
    <input
        type="text"
        wire:model="last_name"
        id="last_name"
        placeholder="@lang('Last Name')"
        required
        class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 placeholder-gray-300 shadow-sm focus:border-transparent focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:bg-gray-100"
        aria-labelledby="last_name-label"
    />
    @error('last_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
</div>

<div class="col-span-6 sm:col-span-3">
    <label for="mobile" id="mobile-label" class="block text-sm font-medium text-gray-700">
        @lang('Mobile')
    </label>
    <input
        type="text"
        wire:model="mobile"
        id="mobile"
        placeholder="@lang('Mobile')"
        class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 placeholder-gray-300 shadow-sm focus:border-transparent focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:bg-gray-100"
        aria-labelledby="mobile-label"
    />
    @error('mobile') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
</div>

<div class="col-span-6 sm:col-span-3">
    <label for="date_of_birth" id="date_of_birth-label" class="block text-sm font-medium text-gray-700">
        @lang('Date Of Birth')
    </label>
    <input
        type="date"
        wire:model="date_of_birth"
        id="date_of_birth"
        class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 placeholder-gray-300 shadow-sm focus:border-transparent focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:bg-gray-100"
        aria-labelledby="date_of_birth-label"
    />
    @error('date_of_birth') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
</div>

<div class="col-span-6">
    <label for="address" id="address-label" class="block text-sm font-medium text-gray-700">
        @lang('Address')
    </label>
    <input
        type="text"
        wire:model="address"
        id="address"
        placeholder="@lang('Address')"
        class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 placeholder-gray-300 shadow-sm focus:border-transparent focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:bg-gray-100"
        aria-labelledby="address-label"
    />
    @error('address') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
</div>

<div class="col-span-6">
    <label for="bio" id="bio-label" class="block text-sm font-medium text-gray-700">
        @lang('Bio')
    </label>
    <textarea
        wire:model="bio"
        id="bio"
        rows="3"
        placeholder="@lang('Bio')"
        class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 placeholder-gray-300 shadow-sm focus:border-transparent focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:bg-gray-100"
        aria-labelledby="bio-label"
    ></textarea>
    @error('bio') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
</div>

<div class="col-span-6 sm:col-span-3">
    <label for="url" id="url-label" class="block text-sm font-medium text-gray-700">
        @lang('Website URL')
    </label>
    <input
        type="url"
        wire:model="url"
        id="url"
        placeholder="@lang('Website URL')"
        class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 placeholder-gray-300 shadow-sm focus:border-transparent focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:bg-gray-100"
        aria-labelledby="url-label"
    />
    @error('url') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
</div>

<div class="col-span-6 sm:col-span-3">
    <label for="url_text" id="url_text-label" class="block text-sm font-medium text-gray-700">
        @lang('Website Link Text')
    </label>
    <input
        type="text"
        wire:model="url_text"
        id="url_text"
        placeholder="@lang('Website Link Text')"
        class="mt-1 w-full rounded-sm border border-gray-300 bg-white px-4 py-2 text-gray-700 placeholder-gray-300 shadow-sm focus:border-transparent focus:outline-hidden focus:ring-2 focus:ring-blue-600 dark:bg-gray-100"
        aria-labelledby="url_text-label"
    />
    @error('url_text') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
</div>

<div class="col-span-6 sm:col-span-3">
    <label for="gender" id="gender-label" class="block text-sm font-medium text-gray-700">
        @lang('Gender')
    </label>
    <select
        wire:model="gender"
        id="gender"
        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-hidden text-sm dark:bg-gray-100"
        aria-labelledby="gender-label"
    >
        <option value="">-- Select an option --</option>
        <option value="Female">Female</option>
        <option value="Male">Male</option>
        <option value="Other">Other</option>
    </select>
    @error('gender') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
</div>

<div class="col-span-6 sm:col-span-3">
    <label for="avatar" id="avatar-label" class="block text-sm font-medium text-gray-700">
        @lang('Avatar')
    </label>
    <input
        type="file"
        wire:model="avatar"
        id="avatar"
        accept="image/*"
        class="mt-1 block w-full text-sm text-gray-500 file:me-3 file:rounded-sm file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100"
        aria-labelledby="avatar-label"
    />
    @error('avatar') <span class="text-sm text-red-500">{{ $message }}</span> @enderror

    @if($avatar)
        <div class="mt-2">
            <img src="{{ $avatar->temporaryUrl() }}" class="h-20 w-20 rounded-md object-cover" alt="Preview" aria-labelledby="avatar-label" />
        </div>
    @endif
</div>
                        </div>

                        <div class="mt-6 bg-gray-50 px-4 text-end sm:px-6">
                            <button
                                class="inline-flex w-full cursor-pointer justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-hidden"
                                type="submit"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove>@lang('Save')</span>
                                <span wire:loading>@lang('Saving...')</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
            <div class="mb-10 py-4">
                <div class="border-t border-gray-200"></div>
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
                    <div class="mb-8 rounded-lg border border-gray-400 bg-white p-6 shadow-lg dark:bg-gray-100">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 text-center">
                                <a href="{{ route('frontend.users.changePassword') }}" wire:navigate>
                                    <div
                                        class="w-full rounded-sm border-2 border-gray-900 px-6 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in hover:bg-gray-800 hover:text-white focus:outline-hidden"
                                    >
                                        Change Password
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($user->providers && $user->providers->count() > 0)
            <div class="hidden sm:block" aria-hidden="true">
                <div class="mb-10 py-4">
                    <div class="border-t border-gray-200"></div>
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
                        <div class="mb-8 rounded-lg border border-gray-400 bg-white p-6 shadow-lg dark:bg-gray-100">
                            <div class="space-y-4">
                                @foreach($user->providers as $provider)
                                    <div class="flex items-center justify-between rounded-md border border-gray-200 p-4">
                                        <div class="flex items-center">
                                            <div class="shrink-0">
                                                @if($provider->provider === 'github')
                                                    <i class="fab fa-github text-2xl text-gray-800"></i>
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
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ ucfirst($provider->provider) }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    Connected on {{ $provider->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <button
                                                type="button"
                                                wire:click="unlinkProvider({{ $provider->id }})"
                                                wire:loading.attr="disabled"
                                                wire:confirm="Are you sure you want to unlink this {{ $providerNames[$provider->id] ?? $provider->provider }} account?"
                                                class="inline-flex items-center rounded-md border border-red-600 bg-white px-3 py-2 text-sm font-semibold text-red-600 shadow-sm hover:bg-red-50 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-hidden disabled:opacity-50"
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
                                            </button>
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
