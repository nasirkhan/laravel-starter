@props(['item', 'optimized' => false])

@php
    $url = $item->getFullUrl();
    $isActive = $item->isCurrentlyActive();
    // Use optimized children check that doesn't trigger database queries
    $hasChildren = isset($item->children) && $item->children instanceof \Illuminate\Support\Collection && $item->children->isNotEmpty();
    $target = $item->opens_new_tab ? '_blank' : null;
    $htmlAttributes = $item->html_attributes ?? [];
    
    // Use the existing nav-item component styling by default
    $baseCssClasses = '';
    
    // Merge additional HTML attributes
    $attributes = array_merge($htmlAttributes, [
        'class' => $baseCssClasses
    ]);
    
    if ($target) {
        $attributes['target'] = $target;
    }
@endphp

@switch($item->type)
    @case('divider')
        <li class="border-t border-gray-200 dark:border-gray-600 my-1"></li>
        @break
    
    @case('heading')
        <li>
            <span class="block px-4 py-2 text-sm font-semibold text-gray-600 uppercase dark:text-gray-400">
                {{ $item->getDisplayTitle() }}
            </span>
        </li>
        @break
    
    @case('dropdown')
        @if($hasChildren)
            <li class="relative group">
                <button
                    type="button"
                    class="border-transparent dark:border-transparent cursor-pointer flex items-center justify-between w-full md:w-auto border-b-2 px-3 py-2 font-semibold text-gray-800 transition duration-200 ease-in hover:border-gray-700 hover:opacity-75 dark:text-white dark:hover:border-gray-300 dark:hover:opacity-75 sm:my-0 sm:py-1"
                    data-dropdown-toggle="dropdown-{{ $item->id }}"
                    aria-expanded="false"
                    aria-haspopup="true"
                    aria-label="Toggle {{ $item->getDisplayTitle() }} submenu"
                >
                    {{ $item->getDisplayTitle() }}
                    <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdown-{{ $item->id }}" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-1" role="menu" aria-label="{{ $item->getDisplayTitle() }} submenu">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" role="none">
                        @foreach(($item->children ?? collect()) as $childItem)
                            {{-- Skip permission check if optimized mode (already filtered by parent) --}}
                            @if($optimized || $childItem->userCanSee())
                                <li>
                                    @if($childItem->type === 'divider')
                                        <div class="border-t border-gray-200 dark:border-gray-600 mx-2"></div>
                                    @elseif($childItem->type === 'heading')
                                        <span class="block px-4 py-2 text-xs font-semibold text-gray-600 uppercase dark:text-gray-400">
                                            {{ $childItem->getDisplayTitle() }}
                                        </span>
                                    @else
                                        <a href="{{ $childItem->getFullUrl() }}" 
                                           @if($childItem->opens_new_tab) target="_blank" @else wire:navigate @endif
                                           class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white {{ $childItem->isCurrentlyActive() ? 'text-blue-700 dark:text-blue-500' : '' }}"
                                           @if($childItem->opens_new_tab) aria-label="{{ $childItem->getDisplayTitle() }} (opens in new tab)" @endif>
                                            {{ $childItem->getDisplayTitle() }}
                                            @if($childItem->opens_new_tab)
                                                <span class="sr-only">(opens in new tab)</span>
                                            @endif
                                        </a>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </li>
        @else
            <!-- Dropdown without children, treat as regular link -->
            <x-frontend.nav-item 
                :href="$url" 
                :active="$isActive"
                :target="$target"
            >
                {{ $item->getDisplayTitle() }}
            </x-frontend.nav-item>
        @endif
        @break
    
    @case('external')
    @case('link')
    @default
        <x-frontend.nav-item 
            :href="$url" 
            :active="$isActive"
            :target="$target"
        >
            {{ $item->getDisplayTitle() }}
        </x-frontend.nav-item>
        @break
@endswitch