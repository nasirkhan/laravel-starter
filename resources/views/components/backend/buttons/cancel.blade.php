@props(["small" => ""])
<button
    onclick="window.history.back();"
    class="btn btn-warning {{ $small == "true" ? "btn-sm" : "" }} m-1"
    data-toggle="tooltip"
    title="{{ __("Cancel") }}"
>
    <i class="fas fa-reply fa-fw"></i>
    &nbsp;{!! $slot != "" ? "&nbsp;" . $slot : "" !!}
</button>
