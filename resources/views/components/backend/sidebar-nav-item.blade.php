@props(['url' => '/', 'icon' => 'fa-solid fa-cube', 'text' => 'Menu', 'permission' => 'view_backend'])

@can('view_circles')
    <li class="nav-item">
        <a class="nav-link" href="{{ $url }}">
            <i class="nav-icon {{ $icon }}"></i>&nbsp;{{ $text }}
        </a>
    </li>
@endcan
