<?php
$notifications = optional(auth()->user())->unreadNotifications;
$notifications_count = optional($notifications)->count();
$notifications_latest = optional($notifications)->take(5);
?>

<header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
    <div class="container-xl">
        <button
            class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#navbar-menu"
            type="button"
            aria-controls="navbar-menu"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav order-md-last flex-row">
            <div class="d-flex">
                <div class="align-self-center">
                    <div class="d-flex float-end flex-row">
                        <div class="">{{ date_today() }}&nbsp;</div>
                        <div class="clock" id="liveClock" onload="showTime()"></div>
                    </div>
                </div>
                <button
                    class="nav-link hide-theme-dark px-0"
                    data-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-original-title="Enable dark mode"
                    data-coreui-theme-value="dark"
                    aria-label="Enable dark mode"
                >
                    <svg
                        class="icon"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"></path>
                    </svg>
                </button>
                <button
                    class="nav-link hide-theme-light px-0"
                    data-toggle="tooltip"
                    data-bs-placement="bottom"
                    data-bs-original-title="Enable light mode"
                    data-coreui-theme-value="light"
                    aria-label="Enable light mode"
                >
                    <svg
                        class="icon"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                        <path
                            d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"
                        ></path>
                    </svg>
                </button>
                <div class="nav-item dropdown d-flex me-3">
                    <a
                        class="nav-link px-0"
                        data-bs-toggle="dropdown"
                        href="#"
                        aria-label="Show notifications"
                        tabindex="-1"
                    >
                        <svg
                            class="icon"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"
                            ></path>
                            <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                        </svg>
                        <span class="badge bg-red"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route("backend.notifications.index") }}">
                                        @lang("All Notifications")
                                        @if ($notifications_count)
                                            <span class="badge bg-red ms-2">{{ $notifications_count }}</span>
                                        @endif
                                    </a>
                                </h3>
                            </div>
                            <div class="list-group list-group-flush list-group-hoverable">
                                @if ($notifications_latest)
                                    @foreach ($notifications_latest as $notification)
                                        @php
                                            $notification_text = isset($notification->data["title"])
                                                ? $notification->data["title"]
                                                : $notification->data["module"];
                                        @endphp

                                        {{--
                                            <a class="dropdown-item" href="{{route("backend.notifications.show", $notification)}}">
                                            <i class="{{isset($notification->data['icon'])? $notification->data['icon'] : 'fa-solid fa-bullhorn'}} "></i>&nbsp;{{$notification_text}}
                                            </a>
                                        --}}
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="status-dot status-dot-animated bg-red d-block"></span>
                                                </div>
                                                <div class="col text-truncate">
                                                    <a
                                                        class="text-body d-block"
                                                        href="{{ route("backend.notifications.show", $notification) }}"
                                                    >
                                                        {{ $notification_text }}
                                                    </a>
                                                    <div class="d-block text-secondary text-truncate mt-n1">
                                                        {{ $notification_text }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a class="list-group-item-actions" href="#">
                                                        <svg
                                                            class="icon text-muted"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="24"
                                                            height="24"
                                                            viewBox="0 0 24 24"
                                                            stroke-width="2"
                                                            stroke="currentColor"
                                                            fill="none"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                        >
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path
                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"
                                                            ></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- language menu --}}
            <x-backend.includes.menu-language />

            {{-- user menu --}}
            <x-backend.includes.menu-user />
        </div>
        <div class="navbar-collapse collapse" id="navbar-menu">
            <div>
                <form action="./" method="get" autocomplete="off" novalidate="">
                    <div class="input-icon">
                        <span class="input-icon-addon">
                            <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                            <svg
                                class="icon"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                                stroke="currentColor"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                <path d="M21 21l-6 -6"></path>
                            </svg>
                        </span>
                        <input
                            class="form-control"
                            type="text"
                            value=""
                            aria-label="Search in website"
                            placeholder="Search…"
                        />
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
