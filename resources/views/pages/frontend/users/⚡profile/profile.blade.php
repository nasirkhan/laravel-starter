<div>
    {{-- Hero Banner --}}
    <div class="h-44 bg-linear-to-br from-blue-500 via-indigo-600 to-violet-600 sm:h-56 dark:from-blue-700 dark:via-indigo-800 dark:to-violet-900"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Avatar + Action Buttons Row --}}
        <div class="relative -mt-16 mb-6 flex flex-col items-start gap-4 sm:-mt-20 sm:flex-row sm:items-end sm:justify-between">
            <img
                class="h-28 w-28 rounded-2xl border-4 border-white object-cover shadow-lg sm:h-36 sm:w-36 dark:border-gray-900"
                src="{{ asset($$module_name_singular->avatar) }}"
                alt="{{ $$module_name_singular->name }}"
            />
            @auth
                @if (auth()->user()->id == $$module_name_singular->id)
                    <div class="flex flex-wrap gap-2 sm:mb-1">
                        <a
                            href="{{ route('frontend.users.profileEdit') }}"
                            wire:navigate
                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            {{ __('Edit Profile') }}
                        </a>
                        <a
                            href="{{ route('frontend.users.changePassword') }}"
                            wire:navigate
                            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            {{ __('Change Password') }}
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Name + Location --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl dark:text-white">
                {{ $$module_name_singular->name }}
            </h1>
            @if ($$module_name_singular->address)
                <p class="mt-1 flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    {{ $$module_name_singular->address }}
                </p>
            @endif
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 gap-6 pb-16 lg:grid-cols-3">

            {{-- Left Sidebar --}}
            <div class="space-y-5">

                {{-- About / Bio --}}
                @if ($$module_name_singular->bio)
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
                        <h3 class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                            {{ __('About') }}
                        </h3>
                        <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                            {{ $$module_name_singular->bio }}
                        </p>
                    </div>
                @endif

                {{-- Website --}}
                @if ($$module_name_singular->url_website)
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
                        <h3 class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                            {{ __('Website') }}
                        </h3>
                        <a
                            href="{{ $$module_name_singular->url_website }}"
                            target="_blank"
                            class="flex items-center gap-2 text-sm font-medium text-indigo-600 transition hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="2" y1="12" x2="22" y2="12"/>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                            {{ str_replace(['http://', 'https://'], '', rtrim($$module_name_singular->url_website, '/')) }}
                        </a>
                    </div>
                @endif

                {{-- Profile Link --}}
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
                    <h3 class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                        {{ __('Profile Link') }}
                    </h3>
                    <a
                        href="{{ route('frontend.users.profile', $$module_name_singular->username) }}"
                        wire:navigate
                        class="flex items-center gap-2 truncate text-sm font-medium text-indigo-600 transition hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300"
                    >
                        {{ str_replace(['http://', 'https://'], '', route('frontend.users.profile', $$module_name_singular->username)) }}
                    </a>
                </div>

                {{-- Social Links --}}
                @if ($$module_name_singular->url_facebook || $$module_name_singular->url_twitter || $$module_name_singular->url_instagram || $$module_name_singular->url_linkedin)
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
                        <h3 class="mb-4 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                            {{ __('Social') }}
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            @if ($$module_name_singular->url_facebook)
                                <a href="{{ $$module_name_singular->url_facebook }}" target="_blank" aria-label="Facebook"
                                   class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 text-gray-600 transition hover:bg-blue-100 hover:text-blue-700 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-blue-900 dark:hover:text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                    </svg>
                                </a>
                            @endif
                            @if ($$module_name_singular->url_twitter)
                                <a href="{{ $$module_name_singular->url_twitter }}" target="_blank" aria-label="Twitter / X"
                                   class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 text-gray-600 transition hover:bg-sky-100 hover:text-sky-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-sky-900 dark:hover:text-sky-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                    </svg>
                                </a>
                            @endif
                            @if ($$module_name_singular->url_instagram)
                                <a href="{{ $$module_name_singular->url_instagram }}" target="_blank" aria-label="Instagram"
                                   class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 text-gray-600 transition hover:bg-pink-100 hover:text-pink-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-pink-900 dark:hover:text-pink-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                    </svg>
                                </a>
                            @endif
                            @if ($$module_name_singular->url_linkedin)
                                <a href="{{ $$module_name_singular->url_linkedin }}" target="_blank" aria-label="LinkedIn"
                                   class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 text-gray-600 transition hover:bg-blue-100 hover:text-blue-700 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-blue-900 dark:hover:text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

            </div>

            {{-- Main Info Panel --}}
            <div class="col-span-2 space-y-5">

                {{-- Personal Details --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
                    <h3 class="mb-5 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                        {{ __('Personal Details') }}
                    </h3>
                    <dl class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ label_case('first_name') }}</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-800 dark:text-gray-100">
                                {{ $$module_name_singular->first_name ?: '—' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ label_case('last_name') }}</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-800 dark:text-gray-100">
                                {{ $$module_name_singular->last_name ?: '—' }}
                            </dd>
                        </div>

                        @auth
                            @if (auth()->user()->id == $$module_name_singular->id)
                                <div>
                                    <dt class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ label_case('email') }}</dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-800 dark:text-gray-100">
                                        {{ $$module_name_singular->email ?: '—' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ label_case('mobile') }}</dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-800 dark:text-gray-100">
                                        {{ $$module_name_singular->mobile ?: '—' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ label_case('date_of_birth') }}</dt>
                                    <dd class="mt-1 text-sm font-medium text-gray-800 dark:text-gray-100">
                                        {{ optional($$module_name_singular->date_of_birth)->toFormattedDateString() ?: '—' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-400 dark:text-gray-500">{{ label_case('gender') }}</dt>
                                    <dd class="mt-1 text-sm font-medium capitalize text-gray-800 dark:text-gray-100">
                                        {{ $$module_name_singular->gender ?: '—' }}
                                    </dd>
                                </div>
                            @endif
                        @endauth
                    </dl>
                </div>

                {{-- Bio (full width, only if not shown in sidebar because sidebar only shows when bio exists) --}}
                @unless ($$module_name_singular->bio)
                    {{-- bio card placeholder removed when empty --}}
                @endunless

            </div>
        </div>
    </div>
</div>

@push('after-scripts')
    <script type="module" src="https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js"></script>
@endpush
