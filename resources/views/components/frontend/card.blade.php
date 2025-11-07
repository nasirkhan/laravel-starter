@props([
    "url" => null,
    "name",
    "image" => "",
])

<?php
// Determine if URL is internal (doesn't start with http:// or https:// or other protocols)
$isInternalUrl = $url && !preg_match('/^(https?:|mailto:|tel:|#)/', $url);

$image = $image ? asset($image) : null;
?>

<div class="flex flex-col rounded-lg border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
    @if ($image)
        <div class="overflow-hidden rounded-t-lg">
            <a href="{{ $url }}" @if($isInternalUrl) wire:navigate @endif>
                <img
                    class="transform rounded-t-lg duration-300 hover:scale-110"
                    src="{{ $image }}"
                    alt="{{ $name }}"
                />
            </a>
        </div>
    @endif

    <div class="mt-5 px-5">
        <a href="{{ $url }}" @if($isInternalUrl) wire:navigate @endif>
            <h5 class="mb-2 text-lg font-semibold tracking-tight text-slate-900 dark:text-slate-300 sm:mb-4 sm:text-xl">
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
                class="inline-flex items-center rounded-sm bg-slate-200 px-3 py-2 text-sm text-slate-700 outline-1 outline-slate-800 hover:bg-slate-700 hover:text-slate-100 focus:outline-hidden dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600"
                href="{{ $url }}"
                @if($isInternalUrl) wire:navigate @endif
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
