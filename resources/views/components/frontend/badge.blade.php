@props([
    "url" => "",
    "text",
])

<span class="m-1 inline-flex break-words">
    @if ($url)
        <a
            class="mb-1 me-1 rounded border border-gray-300 bg-white px-5 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-800 dark:focus:ring-gray-700"
            href="{{ $url }}"
        >
            {{ $text }}
        </a>
    @else
        <span
            class="mb-1 me-1 rounded border border-gray-300 bg-white px-5 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-800 dark:focus:ring-gray-700"
        >
            {{ $text }}
        </span>
    @endif
</span>
