<?php
$notifications = optional(auth()->user())->unreadNotifications;
$notifications_count = optional($notifications)->count();
$notifications_latest = optional($notifications)->take(5);
?>
<header class="header header-sticky mb-3 p-0">
    <div class="container-fluid border-bottom px-4">
        <button class="header-toggler" type="button" style="margin-inline-start: -14px;"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <i class="fa-solid fa-bars"></i>
        </button>
        <ul class="header-nav d-none d-lg-flex">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('frontend.index') }}" target="_blank">
                    {{ app_name() }}&nbsp;<i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </li>
        </ul>
        <ul class="header-nav ms-auto">
            <li class="nav-item dropdown">
                <button class="btn btn-link nav-link d-flex align-items-center px-2 py-2" data-coreui-toggle="dropdown"
                    type="button" aria-expanded="false">
                    <i class="fa-regular fa-bell"></i>
                    @if ($notifications_count)
                        &nbsp;<span class="badge badge-pill bg-danger">{{ $notifications_count }}</span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                    <li>
                        <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                            <strong>@lang('You have :count notifications', ['count' => $notifications_count])</strong>
                        </div>
                    </li>
                    @if ($notifications_latest)
                        @foreach ($notifications_latest as $notification)
                            @php
                                $notification_text = isset($notification->data['title'])
                                    ? $notification->data['title']
                                    : $notification->data['module'];
                            @endphp
                            <li>
                                <a class="dropdown-item d-flex align-items-center"
                                    href="{{ route('backend.notifications.show', $notification) }}">
                                    <i class="{{ isset($notification->data['icon']) ? $notification->data['icon'] : 'fa-solid fa-bullhorn' }}"></i>&nbsp;{{ $notification_text }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </li>
        </ul>
        <ul class="header-nav">
            <li class="nav-item dropdown">
                <button class="btn btn-link nav-link d-flex align-items-center px-2 py-2" data-coreui-toggle="dropdown"
                    type="button" aria-expanded="false">
                    <i class="fa-solid fa-circle-half-stroke"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                    <li>
                        <button class="dropdown-item d-flex align-items-center" data-coreui-theme-value="light"
                            type="button">
                            <i class="fa-regular fa-sun"></i>&nbsp;Light
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center" data-coreui-theme-value="dark"
                            type="button">
                            <i class="fa-solid fa-moon"></i>&nbsp;Dark
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center active" data-coreui-theme-value="auto"
                            type="button">
                            <i class="fa-solid fa-circle-half-stroke"></i>&nbsp;Auto
                        </button>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="header-nav">
            <li class="nav-item dropdown">
                <button class="btn btn-link nav-link d-flex align-items-center px-2 py-2" data-coreui-toggle="dropdown"
                    type="button" aria-expanded="false">
                    <svg class="icon icon-lg icon-tabler icons-tabler-outline icon-tabler-language"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 5h7" />
                        <path d="M9 3v2c0 4.418 -2.239 8 -5 8" />
                        <path d="M5 9c0 2.144 2.952 3.908 6.7 4" />
                        <path d="M12 20l4 -9l4 9" />
                        <path d="M19.1 18h-6.2" />
                    </svg>
                    &nbsp; {{ strtoupper(App::getLocale()) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                    @foreach (config('app.available_locales') as $locale_code => $locale_name)
                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('language.switch', $locale_code) }}">
                                {{ $locale_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
        <ul class="header-nav">
            <li class="nav-item dropdown">
                <a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <img class="avatar-img" src="{{ asset(auth()->user()->avatar) }}"
                            alt="{{ asset(auth()->user()->name) }}">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                        {{ __('Account') }}
                    </div>
                    <a class="dropdown-item" href="{{ route('backend.users.show', Auth::user()->id) }}">
                        <i class="fa-regular fa-user me-2"></i>&nbsp;{{ Auth::user()->name }}
                    </a>
                    <a class="dropdown-item" href="{{ route('backend.users.show', Auth::user()->id) }}">
                        <i class="fa-solid fa-at me-2"></i>&nbsp;{{ Auth::user()->email }}
                    </a>
                    <a class="dropdown-item" href="{{ route('backend.users.show', Auth::user()->id) }}">
                        <i class="fa-regular fa-bell me-2"></i>&nbsp;@lang('Notifications')
                        @if ($notifications_count)
                            &nbsp;<span class="badge bg-danger ms-2">{{ $notifications_count }}</span>
                        @endif
                    </a>

                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                        <div class="fw-semibold">@lang('Settings')</div>
                    </div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>&nbsp;@lang('Logout')
                    </a>
                    <form id="logout-form" style="display: none;" action="{{ route('logout') }}" method="POST">
                        @csrf </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                @yield('breadcrumbs')
            </ol>
        </nav>
        <div class="d-none d-sm-flex float-end flex-row">
            <div class="">{{ date_today() }}&nbsp;</div>
            <div class="clock" id="liveClock" onload="showTime()"></div>
        </div>
    </div>
</header>
