<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <use xlink:href="/fonts/free.svg#cil-menu"></use>
            </svg>
        </button>
        <a class="header-brand d-md-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
                <use xlink:href="assets/brand/coreui.svg#full"></use>
            </svg>
        </a>
        <ul class="header-nav d-none d-md-flex">
            <li class="nav-item"><a class="nav-link" href="#">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
        </ul>
        <ul class="header-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="/fonts/free.svg#cil-bell"></use>
                    </svg></a></li>
            <li class="nav-item"><a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="/fonts/free.svg#cil-list-rich"></use>
                    </svg></a></li>
            <li class="nav-item"><a class="nav-link" href="#">
                    <svg class="icon icon-lg">
                        <use xlink:href="/fonts/free.svg#cil-envelope-open"></use>
                    </svg></a></li>
        </ul>
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="c-icon cil-language"></i>&nbsp; {{strtoupper(App::getLocale())}}
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">{{ __('Change language') }}</div>
                    </div>

                    <a class="dropdown-item" href="{{route("language.switch", "bn")}}">
                        বাংলা (BN)
                    </a>
                    <a class="dropdown-item" href="{{route("language.switch", "en")}}">
                        English (EN)
                    </a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <img class="avatar-img" src="{{ asset(auth()->user()->avatar) }}" alt="{{ asset(auth()->user()->name) }}">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">{{ __('Account') }}</div>
                    </div>

                    <?php
                    $notifications = optional(auth()->user())->unreadNotifications;
                    $notifications_count = optional($notifications)->count();
                    $notifications_latest = optional($notifications)->take(5);
                    ?>

                    <a class="dropdown-item" href="{{route('backend.users.profile', Auth::user()->id)}}">
                        <i class="cil-user me-2"></i>&nbsp;{{ Auth::user()->name }}
                    </a>
                    <a class="dropdown-item" href="{{route('backend.users.profile', Auth::user()->id)}}">
                        <i class="cil-at me-2"></i>&nbsp;{{ Auth::user()->email }}
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route("backend.notifications.index") }}">
                        <i class="cil-bell me-2"></i>&nbsp;
                        @lang('Notifications') <span class="badge badge-danger ml-auto">{{$notifications_count}}</span>
                    </a>

                    <div class="dropdown-header bg-light py-2"><strong>@lang('Settings')</strong></div>

                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="cil-account-logout me-2"></i>&nbsp;
                        @lang('Logout')
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>

                </div>
            </li>
        </ul>
    </div>

    <div class="header-divider"></div>

    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                @yield('breadcrumbs')
            </ol>
        </nav>
        <div class="d-flex flex-row float-right">
            <div class="">{{ date_today() }}&nbsp;</div>
            <div id="liveClock" class="clock" onload="showTime()"></div>
        </div>
    </div>
</header>

@push('after-scripts')
<script type="text/javascript">
    $(function() {
        // Show the time
        showTime();
    })

    function showTime() {
        var date = new Date();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();

        var session = hours >= 12 ? 'pm' : 'am';

        hours = hours % 12;
        hours = hours ? hours : 12;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        var time = hours + ":" + minutes + ":" + seconds + " " + session;
        document.getElementById("liveClock").innerText = time;
        document.getElementById("liveClock").textContent = time;

        setTimeout(showTime, 1000);
    }
</script>
@endpush