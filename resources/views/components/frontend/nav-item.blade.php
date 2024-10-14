@props([
    "href" => route("home"),
    "title",
    "active" => "",
    "target" => "_self",
])

<?php
$active_classes = "border-transparent dark:border-transparent";

if ($active) {
    $active_classes =
        "rounded border-gray-700 bg-gray-200 hover:opacity-75 dark:border-gray-300 dark:bg-gray-700 sm:rounded-none sm:bg-transparent dark:sm:rounded-none dark:sm:bg-transparent";
}
?>

<li>
    <a
        class="{{ $active_classes }} block border-b-2 px-3 py-2 font-semibold text-gray-800 transition duration-200 ease-in hover:border-gray-700 hover:opacity-75 dark:text-white dark:hover:border-gray-300 dark:hover:opacity-75 sm:my-0 sm:py-1"
        href="{{ $href }}"
        target="{{ $target }}"
    >
        {{ $slot }}
    </a>
</li>
