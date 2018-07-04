<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="{{ route('frontend.index') }}"></a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('backend.users.profile') }}">Profile</a>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="icon-bell"></i><span class="badge badge-pill badge-danger">5</span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Account</strong>
                </div>
                <a class="dropdown-item" href="#"><i class="fa fa-bell-o"></i> Updates<span class="badge badge-info">42</span></a>
                <a class="dropdown-item" href="#"><i class="fa fa-envelope-o"></i> Messages<span class="badge badge-success">42</span></a>
                <a class="dropdown-item" href="#"><i class="fa fa-tasks"></i> Tasks<span class="badge badge-danger">42</span></a>
                <a class="dropdown-item" href="#"><i class="fa fa-comments"></i> Comments<span class="badge badge-warning">42</span></a>
            </div>
        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#"><i class="icon-list"></i></a>
        </li>
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#"><i class="icon-location-pin"></i></a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="{{ asset('photos/avatars/'.Auth::user()->avatar) }}" class="img-avatar" alt="{{ Auth::user()->name }}">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Settings</strong>
                </div>
                <a class="dropdown-item" href="{{ route('backend.users.profile') }}">
                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                </a>
                <span class="dropdown-item" href="#">
                    <i class="fas fa-at"></i> {{ Auth::user()->email }}
                </span>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-file"></i> Projects<span class="badge badge-primary">42</span>
                </a>
                <div class="divider"></div>
                <a class="dropdown-item" href="{{ route('frontend.auth.logout') }}">
                    <i class="fas fa-lock"></i> Logout
                </a>
            </div>
        </li>
    </ul>
    <button class="navbar-toggler aside-menu-toggler" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

</header>
