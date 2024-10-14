<?php
$notifications = optional(auth()->user())->unreadNotifications;
$notifications_count = optional($notifications)->count();
$notifications_latest = optional($notifications)->take(5);
?>

<header class="header header-sticky mb-3 p-0">
    <div class="container-fluid border-bottom px-4">
        <button
            class="header-toggler"
            type="button"
            style="margin-inline-start: -14px"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
        >
            <i class="fa-solid fa-bars"></i>
        </button>
        <ul class="header-nav d-none d-lg-flex">
            <li class="nav-item">
                <a class="nav-link" href="{{ route("frontend.index") }}" target="_blank">
                    {{ app_name() }}&nbsp;
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </li>
        </ul>
        <ul class="header-nav ms-auto">
            <li class="nav-item dropdown">
                <button
                    class="btn btn-link nav-link d-flex align-items-center px-2 py-2"
                    data-coreui-toggle="dropdown"
                    type="button"
                    aria-expanded="false"
                >
                    <i class="fa-regular fa-bell"></i>
                    @if ($notifications_count)
                        &nbsp;
                        <span class="badge badge-pill bg-danger">{{ $notifications_count }}</span>
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem">
                    <li>
                        <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                            <strong>
                                @lang("You have :count notifications", ["count" => $notifications_count])
                            </strong>
                        </div>
                    </li>
                    @if ($notifications_latest)
                        @foreach ($notifications_latest as $notification)
                            @php
                                $notification_text = isset($notification->data["title"])
                                    ? $notification->data["title"]
                                    : $notification->data["module"];
                            @endphp

                            <li>
                                <a
                                    class="dropdown-item d-flex align-items-center"
                                    href="{{ route("backend.notifications.show", $notification) }}"
                                >
                                    <i
                                        class="{{ isset($notification->data["icon"]) ? $notification->data["icon"] : "fa-solid fa-bullhorn" }}"
                                    ></i>
                                    &nbsp;{{ $notification_text }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </li>
        </ul>
        <ul class="header-nav">
            <li class="nav-item dropdown">
                <button
                    class="btn btn-link nav-link d-flex align-items-center px-2 py-2"
                    data-coreui-toggle="dropdown"
                    type="button"
                    aria-expanded="false"
                >
                    <svg
                        class="theme-icon-active icon icon-lg"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                    >
                        <path
                            class="ci-primary"
                            fill="var(--ci-primary-color, currentColor)"
                            d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"
                        />
                    </svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem">
                    <li>
                        <button
                            class="dropdown-item d-flex align-items-center"
                            data-coreui-theme-value="light"
                            type="button"
                        >
                            <svg
                                class="theme-icon icon icon-lg"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                            >
                                <path
                                    class="ci-primary"
                                    fill="var(--ci-primary-color, currentColor)"
                                    d="M256,104c-83.813,0-152,68.187-152,152s68.187,152,152,152,152-68.187,152-152S339.813,104,256,104Zm0,272A120,120,0,1,1,376,256,120.136,120.136,0,0,1,256,376Z"
                                ></path>
                                <rect
                                    class="ci-primary"
                                    width="32"
                                    height="48"
                                    x="240"
                                    y="16"
                                    fill="var(--ci-primary-color, currentColor)"
                                ></rect>
                                <rect
                                    class="ci-primary"
                                    width="32"
                                    height="48"
                                    x="240"
                                    y="448"
                                    fill="var(--ci-primary-color, currentColor)"
                                ></rect>
                                <rect
                                    class="ci-primary"
                                    width="48"
                                    height="32"
                                    x="448"
                                    y="240"
                                    fill="var(--ci-primary-color, currentColor)"
                                ></rect>
                                <rect
                                    class="ci-primary"
                                    width="48"
                                    height="32"
                                    x="16"
                                    y="240"
                                    fill="var(--ci-primary-color, currentColor)"
                                ></rect>
                                <rect
                                    class="ci-primary"
                                    width="32"
                                    height="45.255"
                                    x="400"
                                    y="393.373"
                                    fill="var(--ci-primary-color, currentColor)"
                                    transform="rotate(-45 416 416)"
                                ></rect>
                                <rect
                                    class="ci-primary"
                                    width="32.001"
                                    height="45.255"
                                    x="80"
                                    y="73.373"
                                    fill="var(--ci-primary-color, currentColor)"
                                    transform="rotate(-45 96 96)"
                                ></rect>
                                <rect
                                    class="ci-primary"
                                    width="45.255"
                                    height="32"
                                    x="73.373"
                                    y="400"
                                    fill="var(--ci-primary-color, currentColor)"
                                    transform="rotate(-45.001 96.002 416.003)"
                                ></rect>
                                <rect
                                    class="ci-primary"
                                    width="45.255"
                                    height="32.001"
                                    x="393.373"
                                    y="80"
                                    fill="var(--ci-primary-color, currentColor)"
                                    transform="rotate(-45 416 96)"
                                ></rect>
                            </svg>
                            &nbsp;Light
                        </button>
                    </li>
                    <li>
                        <button
                            class="dropdown-item d-flex align-items-center"
                            data-coreui-theme-value="dark"
                            type="button"
                        >
                            <svg
                                class="theme-icon icon icon-lg"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                            >
                                <path
                                    class="ci-primary"
                                    fill="var(--ci-primary-color, currentColor)"
                                    d="M268.279,496c-67.574,0-130.978-26.191-178.534-73.745S16,311.293,16,243.718A252.252,252.252,0,0,1,154.183,18.676a24.44,24.44,0,0,1,34.46,28.958,220.12,220.12,0,0,0,54.8,220.923A218.746,218.746,0,0,0,399.085,333.2h0a220.2,220.2,0,0,0,65.277-9.846,24.439,24.439,0,0,1,28.959,34.461A252.256,252.256,0,0,1,268.279,496ZM153.31,55.781A219.3,219.3,0,0,0,48,243.718C48,365.181,146.816,464,268.279,464a219.3,219.3,0,0,0,187.938-105.31,252.912,252.912,0,0,1-57.13,6.513h0a250.539,250.539,0,0,1-178.268-74.016,252.147,252.147,0,0,1-67.509-235.4Z"
                                ></path>
                            </svg>
                            &nbsp;Dark
                        </button>
                    </li>
                    <li>
                        <button
                            class="dropdown-item d-flex align-items-center active"
                            data-coreui-theme-value="auto"
                            type="button"
                        >
                            <svg
                                class="theme-icon icon icon-lg"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512"
                            >
                                <path
                                    class="ci-primary"
                                    fill="var(--ci-primary-color, currentColor)"
                                    d="M256,16C123.452,16,16,123.452,16,256S123.452,496,256,496,496,388.548,496,256,388.548,16,256,16ZM234,462.849a208.346,208.346,0,0,1-169.667-125.9c-.364-.859-.706-1.724-1.057-2.587L234,429.939Zm0-69.582L50.889,290.76A209.848,209.848,0,0,1,48,256q0-9.912.922-19.67L234,339.939Zm0-90L54.819,202.96a206.385,206.385,0,0,1,9.514-27.913Q67.1,168.5,70.3,162.191L234,253.934Zm0-86.015L86.914,134.819a209.42,209.42,0,0,1,22.008-25.9q3.72-3.72,7.6-7.228L234,166.027Zm0-87.708L144.352,80.451A206.951,206.951,0,0,1,234,49.151ZM464,256A207.775,207.775,0,0,1,266,463.761V48.239A207.791,207.791,0,0,1,464,256Z"
                                ></path>
                            </svg>
                            &nbsp;Auto
                        </button>
                    </li>
                </ul>
            </li>
        </ul>
        <ul class="header-nav">
            <li class="nav-item dropdown">
                <button
                    class="btn btn-link nav-link d-flex align-items-center px-2 py-2"
                    data-coreui-toggle="dropdown"
                    type="button"
                    aria-expanded="false"
                >
                    <svg
                        class="icon icon-lg icon-tabler icons-tabler-outline icon-tabler-language"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 5h7" />
                        <path d="M9 3v2c0 4.418 -2.239 8 -5 8" />
                        <path d="M5 9c0 2.144 2.952 3.908 6.7 4" />
                        <path d="M12 20l4 -9l4 9" />
                        <path d="M19.1 18h-6.2" />
                    </svg>
                    &nbsp; {{ strtoupper(App::getLocale()) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem">
                    @foreach (config("app.available_locales") as $locale_code => $locale_name)
                        <li>
                            <a
                                class="dropdown-item d-flex align-items-center"
                                href="{{ route("language.switch", $locale_code) }}"
                            >
                                {{ $locale_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
        <ul class="header-nav">
            <li class="nav-item dropdown">
                <a
                    class="nav-link py-0 pe-0"
                    data-coreui-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    <div class="avatar avatar-md">
                        <img
                            class="avatar-img"
                            src="{{ asset(auth()->user()->avatar) }}"
                            alt="{{ asset(auth()->user()->name) }}"
                        />
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">
                        {{ __("Account") }}
                    </div>
                    <a class="dropdown-item" href="{{ route("backend.users.show", Auth::user()->id) }}">
                        <i class="fa-regular fa-user me-2"></i>
                        &nbsp;{{ Auth::user()->name }}
                    </a>
                    <a class="dropdown-item" href="{{ route("backend.users.show", Auth::user()->id) }}">
                        <i class="fa-solid fa-at me-2"></i>
                        &nbsp;{{ Auth::user()->email }}
                    </a>
                    <a class="dropdown-item" href="{{ route("backend.notifications.index", Auth::user()->id) }}">
                        <i class="fa-regular fa-bell me-2"></i>
                        &nbsp;
                        @lang("Notifications")
                        @if ($notifications_count)
                            &nbsp;
                            <span class="badge bg-danger ms-2">{{ $notifications_count }}</span>
                        @endif
                    </a>
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                        <div class="fw-semibold">@lang("Settings")</div>
                    </div>
                    <a
                        class="dropdown-item"
                        href="{{ route("logout") }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >
                        <i class="fa-solid fa-right-from-bracket me-2"></i>
                        &nbsp;
                        @lang("Logout")
                    </a>
                    <form id="logout-form" style="display: none" action="{{ route("logout") }}" method="POST">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                @yield("breadcrumbs")
            </ol>
        </nav>
        <div class="d-none d-sm-flex float-end flex-row">
            <div class="">{{ date_today() }}&nbsp;</div>
            <div class="clock" id="liveClock" onload="showTime()"></div>
        </div>
    </div>
</header>
