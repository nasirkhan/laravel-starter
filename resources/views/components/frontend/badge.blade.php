@props([
    "url" => "",
    "text",
])

<?php
// Determine if URL is internal (doesn't start with http:// or https:// or other protocols)
$isInternalUrl = $url && !preg_match('/^(https?:|mailto:|tel:|#)/', $url);
?>

<span class="m-1 inline-flex wrap-break-word">
    @if ($url)
        <a
            class="mb-1 me-1 rounded-sm border border-gray-300 bg-white px-5 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-hidden focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-800 dark:focus:ring-gray-700"
            href="{{ $url }}"
            @if($isInternalUrl) wire:navigate @endif
        >
            {{ $text }}
        </a>
    @else
        <span
            class="mb-1 me-1 rounded-sm border border-gray-300 bg-white px-5 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-hidden focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-800 dark:focus:ring-gray-700"
        >
            {{ $text }}
        </span>
    @endif
</span>
