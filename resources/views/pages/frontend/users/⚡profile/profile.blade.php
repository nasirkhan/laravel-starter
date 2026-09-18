<div>
    {{-- Hero Banner: Muted deep charcoal with a subtle dot-grid texture --}}
    <div class="relative h-40 overflow-hidden sm:h-52"
         style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 55%, #0f3460 100%);">
        <div class="absolute inset-0"
             style="background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px); background-size: 22px 22px;"></div>
        <div class="absolute inset-0 bg-linear-to-b from-transparent to-black/30"></div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Avatar + Action Buttons Row --}}
        <div class="relative -mt-14 mb-5 flex flex-col items-start gap-4 sm:-mt-20 sm:flex-row sm:items-end sm:justify-between">
            <img
                class="h-24 w-24 rounded-2xl border-4 border-white object-cover shadow-xl ring-1 ring-black/8 sm:h-32 sm:w-32 dark:border-gray-900"
                src="{{ asset($$module_name_singular->avatar) }}"
                alt="{{ $$module_name_singular->name }}"
            />
            @auth
                @if (auth()->user()->id == $$module_name_singular->id)
                    <div class="flex flex-wrap gap-2 sm:mb-1">
                        <a
                            href="{{ route('frontend.users.profileEdit') }}"
                            wire:navigate
                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-600 shadow-sm transition hover:border-gray-300 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-750"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            {{ __('Edit Profile') }}
                        </a>
                        <a
                            href="{{ route('frontend.users.changePassword') }}"
                            wire:navigate
                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-600 shadow-sm transition hover:border-gray-300 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-750"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            {{ __('Password') }}
                        </a>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Identity Block --}}
        <div class="mb-8">
            {{-- Aesthetic choice: serif nameplate for identity pages --}}
            <h1 class="font-serif text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl dark:text-white">
                {{ $$module_name_singular->name }}
            </h1>
            <p class="mt-1 text-sm text-gray-400 dark:text-gray-500">
                &commat;{{ $$module_name_singular->username }}
            </p>

            {{-- Meta strip --}}
            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-1.5">
                @if ($$module_name_singular->address)
                    <span class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        {{ $$module_name_singular->address }}
                    </span>
                @endif
                <span class="inline-flex items-center gap-1.5 text-sm text-gray-400 dark:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ __('Member since') }} {{ $$module_name_singular->created_at->format('M Y') }}
                </span>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 gap-6 pb-16 lg:grid-cols-3">

            {{-- Left Sidebar --}}
            <div class="space-y-4">

                {{-- About / Bio --}}
                @if ($$module_name_singular->bio)
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
                        <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                            {{ __('About') }}
                        </h3>
                        <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                            {{ $$module_name_singular->bio }}
                        </p>
                    </div>
                @endif

                {{-- Social Links --}}
                @if ($$module_name_singular->url_facebook || $$module_name_singular->url_twitter || $$module_name_singular->url_instagram || $$module_name_singular->url_linkedin)
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
                        <h3 class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                            {{ __('Social') }}
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            @if ($$module_name_singular->url_facebook)
                                <a href="{{ $$module_name_singular->url_facebook }}" target="_blank" aria-label="Facebook"
                                   class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50 text-gray-500 ring-1 ring-gray-100 transition hover:bg-blue-50 hover:text-blue-600 hover:ring-blue-100 dark:bg-gray-700 dark:text-gray-400 dark:ring-gray-600 dark:hover:bg-blue-900/30 dark:hover:text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                    </svg>
                                </a>
                            @endif
                            @if ($$module_name_singular->url_twitter)
                                <a href="{{ $$module_name_singular->url_twitter }}" target="_blank" aria-label="X (Twitter)"
                                   class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50 text-gray-500 ring-1 ring-gray-100 transition hover:bg-gray-900 hover:text-white hover:ring-gray-900 dark:bg-gray-700 dark:text-gray-400 dark:ring-gray-600 dark:hover:bg-white dark:hover:text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                    </svg>
                                </a>
                            @endif
                            @if ($$module_name_singular->url_instagram)
                                <a href="{{ $$module_name_singular->url_instagram }}" target="_blank" aria-label="Instagram"
                                   class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50 text-gray-500 ring-1 ring-gray-100 transition hover:bg-pink-50 hover:text-pink-600 hover:ring-pink-100 dark:bg-gray-700 dark:text-gray-400 dark:ring-gray-600 dark:hover:bg-pink-900/30 dark:hover:text-pink-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                    </svg>
                                </a>
                            @endif
                            @if ($$module_name_singular->url_linkedin)
                                <a href="{{ $$module_name_singular->url_linkedin }}" target="_blank" aria-label="LinkedIn"
                                   class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50 text-gray-500 ring-1 ring-gray-100 transition hover:bg-blue-50 hover:text-blue-700 hover:ring-blue-100 dark:bg-gray-700 dark:text-gray-400 dark:ring-gray-600 dark:hover:bg-blue-900/30 dark:hover:text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Share Profile: icon-only sharekit buttons --}}
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
                    <h3 class="mb-3 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                        {{ __('Share Profile') }}
                    </h3>
                    <x-sharekit::buttons
                        theme="tailwind"
                        :icon-only="true"
                        :compact="true"
                        :url="route('frontend.users.profile', $$module_name_singular->username)"
                        :title="$$module_name_singular->name"
                        :networks="['x', 'facebook', 'linkedin', 'whatsapp', 'telegram', 'copy']"
                    />
                </div>

                {{-- Website --}}
                @if ($$module_name_singular->url_website)
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
                        <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                            {{ __('Website') }}
                        </h3>
                        <a
                            href="{{ $$module_name_singular->url_website }}"
                            target="_blank"
                            class="flex items-center gap-2 text-sm font-medium text-teal-600 transition hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="2" y1="12" x2="22" y2="12"/>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                            <span class="truncate">{{ str_replace(['http://', 'https://'], '', rtrim($$module_name_singular->url_website, '/')) }}</span>
                        </a>
                    </div>
                @endif

                {{-- Profile Link --}}
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
                    <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                        {{ __('Profile Link') }}
                    </h3>
                    <a
                        href="{{ route('frontend.users.profile', $$module_name_singular->username) }}"
                        wire:navigate
                        class="flex items-center gap-1.5 truncate text-sm font-medium text-teal-600 transition hover:text-teal-700 dark:text-teal-400 dark:hover:text-teal-300"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                        </svg>
                        <span class="truncate">{{ str_replace(['http://', 'https://'], '', route('frontend.users.profile', $$module_name_singular->username)) }}</span>
                    </a>
                </div>

            </div>

            {{-- Main Info Panel --}}
            <div class="col-span-2 space-y-5">

                {{-- Personal Details --}}
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 dark:bg-gray-800 dark:ring-gray-700">
                    <h3 class="mb-4 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">
                        {{ __('Personal Details') }}
                    </h3>
                    <dl class="divide-y divide-gray-50 dark:divide-gray-700/60">
                        <div class="flex items-center justify-between py-3 first:pt-0">
                            <dt class="text-xs text-gray-400 dark:text-gray-500">{{ label_case('first_name') }}</dt>
                            <dd class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $$module_name_singular->first_name ?: '—' }}</dd>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <dt class="text-xs text-gray-400 dark:text-gray-500">{{ label_case('last_name') }}</dt>
                            <dd class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $$module_name_singular->last_name ?: '—' }}</dd>
                        </div>
                        @auth
                            @if (auth()->user()->id == $$module_name_singular->id)
                                <div class="flex items-center justify-between py-3">
                                    <dt class="text-xs text-gray-400 dark:text-gray-500">{{ label_case('email') }}</dt>
                                    <dd class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $$module_name_singular->email ?: '—' }}</dd>
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <dt class="text-xs text-gray-400 dark:text-gray-500">{{ label_case('mobile') }}</dt>
                                    <dd class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $$module_name_singular->mobile ?: '—' }}</dd>
                                </div>
                                <div class="flex items-center justify-between py-3">
                                    <dt class="text-xs text-gray-400 dark:text-gray-500">{{ label_case('date_of_birth') }}</dt>
                                    <dd class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ optional($$module_name_singular->date_of_birth)->toFormattedDateString() ?: '—' }}</dd>
                                </div>
                                <div class="flex items-center justify-between py-3 last:pb-0">
                                    <dt class="text-xs text-gray-400 dark:text-gray-500">{{ label_case('gender') }}</dt>
                                    <dd class="text-sm font-medium capitalize text-gray-800 dark:text-gray-100">{{ $$module_name_singular->gender ?: '—' }}</dd>
                                </div>
                            @endif
                        @endauth
                    </dl>
                </div>

                {{-- Own profile: nudge to fill in missing details --}}
                @auth
                    @if (auth()->user()->id == $$module_name_singular->id)
                        @php
                            $incomplete = ! $$module_name_singular->bio
                                || ! $$module_name_singular->url_facebook && ! $$module_name_singular->url_twitter
                                || ! $$module_name_singular->url_website;
                        @endphp
                        @if ($incomplete)
                            <div class="flex items-start gap-4 rounded-2xl border border-teal-100 bg-teal-50 p-5 dark:border-teal-900/50 dark:bg-teal-950/30">
                                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-teal-100 text-teal-600 dark:bg-teal-900/50 dark:text-teal-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="8" x2="12" y2="12"/>
                                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-teal-800 dark:text-teal-300">{{ __('Your profile has empty fields') }}</p>
                                    <p class="mt-0.5 text-sm text-teal-600 dark:text-teal-400/80">{{ __('Add a bio, social links, or website so others can learn more about you.') }}</p>
                                    <a
                                        href="{{ route('frontend.users.profileEdit') }}"
                                        wire:navigate
                                        class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-teal-700 transition hover:text-teal-900 dark:text-teal-400 dark:hover:text-teal-300"
                                    >
                                        {{ __('Complete your profile') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="5" y1="12" x2="19" y2="12"/>
                                            <polyline points="12 5 19 12 12 19"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif
                @endauth

            </div>
        </div>
    </div>
</div>
