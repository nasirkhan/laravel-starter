@props(["href" => "", "small" => "true", "text" => "Public View"])
<a
    class="btn btn-light {{ $small == "true" ? "btn-sm" : "" }}"
    href="{{ $href }}"
    target="_blank"
>
    <i class="fa-solid fa-arrow-up-right-from-square"></i>
    {!! $text != "" ? "&nbsp;" . $text : "" !!}
    {!! $slot != "" ? "&nbsp;" . $slot : "" !!}
</a>
