<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top bg-primary navbar-transparent" color-on-scroll="400">
    <div class="container">
        <div class="dropdown button-dropdown">
            <a href="#" class="dropdown-toggle" id="navbarDropdown" data-toggle="dropdown">
                <span class="button-bar"></span>
                <span class="button-bar"></span>
                <span class="button-bar"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#" target="_blank">About</a>
            </div>
        </div>
        <div class="navbar-translate">
            <a class="navbar-brand" href="/" rel="tooltip" title="{{ config('app.name', 'Laravel Starter') }} - Application Landing Page" data-placement="bottom">
                {{ config('app.name', 'Laravel Starter') }}
            </a>
            <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navigation" data-nav-image="{{asset('/vendor/now-ui-kit/img/blurred-image-1.jpg')}}">
            <ul class="navbar-nav">

                @can('view_backend')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('backend.dashboard') }}">
                        <i class="now-ui-icons tech_tv"></i>
                        Admin Dashboard
                    </a>
                </li>
                @endcan

                @guest
                @if(user_registration())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        Register
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="now-ui-icons objects_key-25"></i> Login
                    </a>
                </li>
                @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="now-ui-icons users_single-02"></i> {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('frontend.users.profile', auth()->user()->id) }}">Profile</a>
                        <a class="dropdown-item" href="#">Dashboard</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="now-ui-icons sport_user-run"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endguest

            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
