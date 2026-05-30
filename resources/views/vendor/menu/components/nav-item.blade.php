{{-- Menu Module: Navigation Item Component --}}
{{-- Override active-state styling for frontend menu items --}}

@props([
    "href" => route("home"),
    "title",
    "active" => "",
    "target" => "_self",
])

<?php
$activeClasses = "border-transparent dark:border-transparent";

if ($active) {
    $activeClasses = "border-gray-700 text-gray-900 dark:border-gray-300 dark:text-white";
}

// Add wire:navigate for internal links only (not external or new tab)
$shouldNavigate = $target === '_self';
?>

<li>
    <a
        class="{{ $activeClasses }} block border-b-2 px-3 py-2 text-gray-800 transition duration-200 ease-in hover:border-gray-700 hover:opacity-75 dark:text-white dark:hover:border-gray-300 dark:hover:opacity-75 sm:my-0 sm:py-1"
        href="{{ $href }}"
        target="{{ $target }}"
        @if($shouldNavigate) wire:navigate @endif
        @if($target === '_blank') aria-label="{{ $slot }} (opens in new tab)" @endif
    >
        {{ $slot }}
        @if($target === '_blank')
            <span class="sr-only">(opens in new tab)</span>
        @endif
    </a>
</li>
