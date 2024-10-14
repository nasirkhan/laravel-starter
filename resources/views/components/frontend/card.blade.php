@props([
    "url" => null,
    "name",
    "image" => "",
])

<div class="flex flex-col rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-800">
    @if ($image)
        <div class="overflow-hidden rounded-t-lg">
            <a href="{{ $url }}">
                <img
                    class="transform rounded-t-lg duration-300 hover:scale-110"
                    src="{{ $image }}"
                    alt="{{ $name }}"
                />
            </a>
        </div>
    @endif

    <div class="mt-5 px-5">
        <a href="{{ $url }}">
            <h5 class="mb-2 text-lg font-semibold tracking-tight text-gray-900 dark:text-gray-300 sm:mb-4 sm:text-xl">
                {{ $name }}
            </h5>
        </a>
    </div>
    <div class="mb-2 flex-1 px-5 text-sm font-normal sm:mb-4 sm:text-base">
        {!! $slot !!}
    </div>
    @if ($url)
        <div class="px-5 pb-5 text-end">
            <a
                class="inline-flex items-center rounded bg-gray-200 px-3 py-2 text-sm text-gray-700 outline outline-1 outline-gray-800 hover:bg-gray-700 hover:text-gray-100 focus:outline-none dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                href="{{ $url }}"
            >
                View details
                <svg
                    class="-mr-1 ml-2 h-4 w-4"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
            </a>
        </div>
    @endif
</div>
