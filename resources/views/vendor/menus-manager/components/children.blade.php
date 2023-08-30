<div x-show="open" {{ $attributes }}>
    @foreach($items as $item)
        @if ($item->isDivider())
        <x-menus-divider :item="$item" class="py-2 px-16 border-0 bg-gray-500 text-gray-500 h-px" />
        @else
            @if($item->isActive())
            <x-menus-item :item="$item" class="w-full inline-flex items-center py-3 px-6 text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100 border-l-4 border-purple-700" />
            @else
            <x-menus-item :item="$item" class="w-full inline-flex items-center py-3 px-6 text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" />
            @endif
        @endif
    @endforeach
</div>
