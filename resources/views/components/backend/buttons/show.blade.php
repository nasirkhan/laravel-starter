@props([
    "route" => "",
    "icon" => "fas fa-desktop",
    "title",
    "small" => "",
    "class" => "",
])

@if ($route)
    <a
        class="btn btn-info {{ $small == "true" ? "btn-sm" : "" }} {{ $class }} m-1"
        data-toggle="tooltip"
        href="{{ $route }}"
        title="{{ $title }}"
    >
        <i class="{{ $icon }} fa-fw"></i>
        {!! $slot != "" ? "&nbsp;" . $slot : "" !!}
    </a>
@else
    <button
        class="btn btn-info {{ $small == "true" ? "btn-sm" : "" }} {{ $class }} m-1"
        data-toggle="tooltip"
        type="submit"
        title="{{ $title }}"
    >
        <i class="{{ $icon }} fa-fw"></i>
        {!! $slot != "" ? "&nbsp;" . $slot : "" !!}
    </button>
@endif
