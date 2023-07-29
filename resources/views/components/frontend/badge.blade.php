@props(['url'=>'', 'text'])

<span class="break-words inline-flex m-1">
    @if ($url)
    <a href="{{ $url }}" class="group bg-gray-100 text-gray-800 px-2.5 py-1 rounded dark:bg-gray-700 dark:text-gray-300 border hover:border-gray-800 transition ease-out duration-300">
        {{ $text }}
    </a>
    @else
    <span class="group bg-gray-100 text-gray-800 px-2.5 py-1 rounded dark:bg-gray-700 dark:text-gray-300 border border-gray-300 transition ease-out duration-300">
        {{ $text }}
    </span>
    @endif

</span>