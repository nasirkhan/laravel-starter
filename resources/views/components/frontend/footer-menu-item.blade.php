@props(['item'])

@php
    $url = $item->getFullUrl();
    $isActive = $item->isCurrentlyActive();
    // Use optimized children check that doesn't trigger database queries when children are already loaded
    $hasChildren = isset($item->children) && $item->children instanceof \Illuminate\Support\Collection && $item->children->isNotEmpty();
    $target = $item->opens_new_tab ? '_blank' : null;
@endphp

@switch($item->type)
    @case('divider')
        {{-- Dividers don't make sense in footer context, skip --}}
        @break
    
    @case('heading')
        {{-- Headings in footer could be styled differently --}}
        <li>
            <span class="mx-2 text-sm font-semibold text-gray-600 uppercase dark:text-gray-400 md:mx-3">
                {{ $item->getDisplayTitle() }}
            </span>
        </li>
        @break
    
    @case('dropdown')
        @if($hasChildren)
            {{-- For footer, we'll render dropdown items as individual links --}}
            <li>
                <a class="mx-2 hover:underline md:mx-3 {{ $isActive ? 'font-semibold' : '' }}" 
                   href="{{ $url }}"
                   @if($target) target="{{ $target }}" @endif
                   @if($item->opens_new_tab && $url !== '#') wire:navigate.hover @endif>
                    {{ $item->getDisplayTitle() }}
                </a>
            </li>
            @foreach($item->children as $childItem)
                @if($childItem->userCanSee() && $childItem->type !== 'divider')
                    <li>
                        <a class="mx-2 hover:underline md:mx-3 text-sm {{ $childItem->isCurrentlyActive() ? 'font-semibold' : '' }}" 
                           href="{{ $childItem->getFullUrl() }}"
                           @if($childItem->opens_new_tab) target="_blank" @endif
                           @if(!$childItem->opens_new_tab && $childItem->getFullUrl() !== '#') wire:navigate.hover @endif>
                            {{ $childItem->getDisplayTitle() }}
                        </a>
                    </li>
                @endif
            @endforeach
        @else
            <li>
                <a class="mx-2 hover:underline md:mx-3 {{ $isActive ? 'font-semibold' : '' }}" 
                   href="{{ $url }}"
                   @if($target) target="{{ $target }}" @endif
                   @if(!$item->opens_new_tab && $url !== '#') wire:navigate.hover @endif>
                    {{ $item->getDisplayTitle() }}
                </a>
            </li>
        @endif
        @break
    
    @case('external')
    @case('link')
    @default
        <li>
            <a class="mx-2 hover:underline md:mx-3 {{ $isActive ? 'font-semibold' : '' }}" 
               href="{{ $url }}"
               @if($target) target="{{ $target }}" @endif
               @if(!$item->opens_new_tab && $url !== '#') wire:navigate.hover @endif>
                {{ $item->getDisplayTitle() }}
            </a>
        </li>
        @break
@endswitch