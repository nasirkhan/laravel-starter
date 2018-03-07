<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('backend.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard <span class="badge badge-primary">NEW</span></a>
            </li>

            <li class="nav-title">
                Access Management
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fas fa-key"></i> Access Control</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backend.users.index') }}"><i class="fas fa-users"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backend.roles.index') }}"><i class="fas fa-user-secret"></i> Roles</a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>
</div>
