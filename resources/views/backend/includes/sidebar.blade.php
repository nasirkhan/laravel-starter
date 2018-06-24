<div class="sidebar">
    <nav class="sidebar-nav">

        {!! $admin_sidebar->asUl( ['class' => 'nav'], ['class' => 'nav-dropdown-items'] ) !!}

        <!-- <ul class="nav">

            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}" href="{{ route('backend.dashboard') }}"><i class="icon-speedometer"></i> Dashboard <span class="badge badge-primary">NEW</span></a>
            </li>
            <li class="nav-title">
                Modules
            </li>
            <?php $articles_uri_paterns = [
                'admin/posts/*',
                'admin/categories/*',
                'admin/tags/*',
            ]; ?>
            <li class="nav-item nav-dropdown {{ active_class(if_uri_pattern($articles_uri_paterns), 'open') }}">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="fas fa-file"></i> Articles</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(if_uri_pattern('admin/posts/*')) }}" href="{{ route('backend.posts.index') }}">
                            <i class="fas fa-file-alt"></i> Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(if_uri_pattern('admin/categories/*')) }}" href="{{ route('backend.categories.index') }}">
                            <i class="fas fa-sitemap"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(if_uri_pattern('admin/tags/*')) }}" href="{{ route('backend.tags.index') }}">
                            <i class="fas fa-tags"></i> Tags
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-title">
                Access Management

                <?php $ccess_uri_paterns = [
                    'admin/users/*',
                    'admin/roles/*',
                ]; ?>
            </li>
            <li class="nav-item nav-dropdown {{ active_class(if_uri_pattern($ccess_uri_paterns), 'open') }}">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-key"></i> Access Control</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(if_uri_pattern('admin/users/*')) }}" href="{{ route('backend.users.index') }}"><i class="icon-people"></i> Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(if_uri_pattern('admin/roles/*')) }}" href="{{ route('backend.roles.index') }}"><i class="icon-user-following"></i> Roles</a>
                    </li>
                </ul>
            </li>
        </ul> -->
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
