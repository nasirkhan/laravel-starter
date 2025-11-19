@props(["route" => "", "icon" => "fas fa-list", "title" => "List", "small" => "", "class" => ""])

@if ($route)
    <a
        class="btn btn-outline-secondary {{ $small == "true" ? "btn-sm" : "" }} {{ $class }} m-1"
        data-toggle="tooltip"
        href="{{ $route }}"
        title="{{ __($title) }}"
    >
        <i class="{{ $icon }} fa-fw"></i>
        {!! $slot != "" ? "&nbsp;" . $slot : "" !!}
    </a>
@else
    <button
        class="btn btn-outline-secondary {{ $small == "true" ? "btn-sm" : "" }} {{ $class }} m-1"
        data-toggle="tooltip"
        type="submit"
        title="{{ __($title) }}"
    >
        <i class="{{ $icon }} fa-fw"></i>
        {!! $slot != "" ? "&nbsp;" . $slot : "" !!}
    </button>
@endif