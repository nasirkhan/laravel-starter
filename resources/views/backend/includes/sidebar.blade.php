<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('backend.dashboard') }}"><i class="icon-speedometer"></i> Dashboard <span class="badge badge-primary">NEW</span></a>
            </li>
            <li class="nav-title">
                Access Management
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('backend.categories.index') }}">
                    <i class="fas fa-sitemap"></i> Categories
                </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-key"></i> Access Control</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backend.users.index') }}"><i class="icon-people"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backend.roles.index') }}"><i class="icon-user-following"></i> Roles</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
