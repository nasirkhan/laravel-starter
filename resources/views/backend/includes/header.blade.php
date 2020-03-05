<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('backend.dashboard') }}">
        <img class="navbar-brand-full" src="{{ asset('img/logo.png') }}" width="89" height="25" alt="Logo">
        <img class="navbar-brand-minimized" src="{{ asset('img/favicon-cube.png') }}" width="30" height="30" alt="Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('frontend.index') }}" target="_blank"> {{ app_name() }} </a>
        </li>
    </ul>
    <?php
    $notifications = optional(auth()->user())->unreadNotifications;
    $notifications_count = optional($notifications)->count();
    $notifications_latest = optional($notifications)->take(5);
    ?>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown d-md-down-none">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
                <i class="icon-bell"></i>
                @if($notifications_count)<span class="badge badge-pill badge-danger">{{$notifications_count}}</span>@endif
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                <div class="dropdown-header text-center">
                    <strong>You have {{$notifications_count}} unread notifications!</strong>
                </div>
                @if($notifications_latest)
                @foreach($notifications_latest as $notification)
                @php
                $notification_text = isset($notification->data['title'])? $notification->data['title'] : $notification->data['module'];
                @endphp
                <a class="dropdown-item" href="#">
                    <i class="{{isset($notification->data['icon'])? $notification->data['icon'] : 'fas fa-flag'}}"></i> {{$notification_text}}
                </a>
                @endforeach
                @endif
                <a class="dropdown-item text-center" href="{{route('backend.notifications.index')}}">
                    View all
                </a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset(auth()->user()->avatar) }}" class="img-avatar" alt="{{ auth()->user()->name }}">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="{{route('backend.users.profile', Auth::user()->id)}}">
                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                </a>
                <a class="dropdown-item" href="{{route('backend.users.profile', Auth::user()->id)}}">
                    <i class="fas fa-at"></i> {{ Auth::user()->email }}
                </a>
                <a class="dropdown-item" href="{{ route("backend.notifications.index") }}">
                    <i class="fa fa-bell"></i> Notifications
                    <span class="badge badge-warning">{{$notifications_count}}</span>
                </a>
                <div class="dropdown-header text-center">
                    <strong>Settings</strong>
                </div>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-lock"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
    <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>
