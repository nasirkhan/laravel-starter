@props([
    "route" => "",
    "icon" => "fa-solid fa-arrow-up-right-from-square",
    "title",
    "small" => "",
    "class" => "",
])

@if ($route)
    <a
        class="btn btn-success {{ $small == "true" ? "btn-sm" : "" }} {{ $class }} ms-1"
        data-toggle="tooltip"
        href="{{ $route }}"
        title="{{ $title }}"
        target="_blank"
    >
        <i class="{{ $icon }} fa-fw"></i>
        {!! $slot != "" ? "&nbsp;" . $slot : "" !!}
    </a>
@endif
