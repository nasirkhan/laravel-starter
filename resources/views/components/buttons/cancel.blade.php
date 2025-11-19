@props(["small" => ""])
<button
    onclick="window.history.back();"
    class="btn btn-warning {{ $small == "true" ? "btn-sm" : "" }} ms-1"
    data-toggle="tooltip"
    title="{{ __("Cancel") }}"
>
    <i class="fas fa-reply"></i>
    &nbsp;{{ $slot }}
</button>
