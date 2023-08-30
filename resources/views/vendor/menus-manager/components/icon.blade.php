<div {{ $attributes->merge($item->attributes) }}>
    @isset($slot)
    {{ $slot }}b
    @else
    {{ $icon }}a
    @endif
</div>