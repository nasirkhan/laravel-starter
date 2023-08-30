<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <a href="{{route('backend.dashboard')}}">
            <img class="sidebar-brand-full" src="{{asset('img/backend-logo.jpg')}}" height="46" alt="{{ app_name() }}">
            <img class="sidebar-brand-narrow" src="{{asset('img/backend-logo-square.jpg')}}" height="46" alt="{{ app_name() }}">
        </a>
    </div>

    <x-menus-menu name="backend_sidebar" data-coreui="navigation" />

    <ul class="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="nav-icon cil-speedometer"></i> Nav item
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="nav-icon cil-speedometer"></i> With badge
                <span class="badge bg-primary">NEW</span>
            </a>
        </li>
        <li class="nav-item nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <i class="nav-icon cil-puzzle"></i> Nav dropdown
            </a>
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon cil-puzzle"></i> Nav dropdown item
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="nav-icon cil-puzzle"></i> Nav dropdown item
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item mt-auto">
            <a class="nav-link nav-link-success" href="https://coreui.io">
                <i class="nav-icon cil-cloud-download"></i> Download CoreUI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link nav-link-danger" href="https://coreui.io/pro/">
                <i class="nav-icon cil-layers"></i> Try CoreUI
                <strong>PRO</strong>
            </a>
        </li>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>