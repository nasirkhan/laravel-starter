<?php
$notifications = optional(auth()->user())->unreadNotifications;
$notifications_count = optional($notifications)->count();
$notifications_latest = optional($notifications)->take(5);
?>

<div class="nav-item dropdown">
    <a class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" href="#" aria-label="Open user menu">
        <span class="avatar avatar-sm" style="background-image: url({{ asset("img/favicon.png") }})"></span>
        <div class="d-none d-xl-block ps-2">
            <div>{{ auth()->user()->name }}</div>
            <div class="small text-muted mt-1">{{ Auth::user()->email }}</div>
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <a class="dropdown-item" href="{{ route("backend.users.show", Auth::user()->id) }}">
            <i class="fa-regular fa-user me-2"></i>
            &nbsp;{{ Auth::user()->name }}
        </a>
        <a class="dropdown-item" href="{{ route("backend.notifications.index") }}">
            <i class="fa-regular fa-bell me-2"></i>
            &nbsp;
            @lang("Notifications")
            @if ($notifications_count)
                <span class="badge bg-yellow ms-2">{{ $notifications_count }}</span>
            @endif
        </a>
        <div class="dropdown-divider"></div>
        <a
            class="dropdown-item"
            href="{{ route("logout") }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        >
            <i class="fa-solid fa-right-from-bracket me-2"></i>
            &nbsp;
            @lang("Logout")
        </a>
        <form id="logout-form" style="display: none" action="{{ route("logout") }}" method="POST">@csrf</form>
    </div>
</div>
