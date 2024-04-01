@props(['route' => '', 'icon' => 'fas fa-plus', 'title' => 'Create', 'small' => '', 'class' => ''])

@if ($route)
    <a class='btn btn-success {{ $small == 'true' ? 'btn-sm' : '' }} {{ $class }}' data-bs-toggle="tooltip"
        href='{{ $route }}' title="{{ __($title) }}">
        <i class="{{ $icon }}"></i>
        {!! ($slot != "") ? '&nbsp;' . $slot : '' !!}
    </a>
@else
    <button class='btn btn-success {{ $small == 'true' ? 'btn-sm' : '' }} {{ $class }} m-1' data-bs-toggle="tooltip"
        type="submit" title="{{ __($title) }}">
        <i class="{{ $icon }}"></i>
        {!! ($slot != "") ? '&nbsp;' . $slot : '' !!}
    </button>
@endif
