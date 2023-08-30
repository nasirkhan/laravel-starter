<div x-data="{ open: {{ $item->isActive() ? 'true' : 'false' }} }">
    @if($item->haschildren())
    <button @click="open = !open" {{ $attributes->merge($item->attributes) }}>
        <span class="flex items-center">
            <x-menus-icon class="h-5 w-5" :item="$item" />
            <span class="mx-4">{{ $item->title }}</span>
        </span>

        <span>
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path x-show="!open" d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;"></path>
                <path x-show="open" d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </span>
    </button>

    <x-menus-children :items="$item->children()" class="bg-gray-100" />
    @else
    <div {{ $attributes->merge($item->attributes) }}>
        <x-menus-icon class="h-5 w-5" :item="$item" />
        <span class="mx-4 font-medium">{{ $item->title }}</span>
    </div>
    <li class="nav-title">Nav Title</li>

    @endif
</div>