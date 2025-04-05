@props([
    "type" => "",
    "href" => "#",
])
<a
    href="{{ $href }}"
    {{ $attributes->merge(["class" => "inline-flex items-center border border-transparent hover:underline cursor-pointer font-semibold tracking-widest transition ease-in-out duration-150"]) }}
>
    {{ $slot }}
</a>
