@props(['href' => route('home'), 'title', 'active' => '', 'target' => '_self'])
<?php
$active_classes = 'border-transparent dark:border-transparent';

if ($active) {
    $active_classes = "bg-gray-200 dark:bg-gray-700 rounded sm:bg-transparent sm:rounded-none dark:sm:bg-transparent dark:sm:rounded-none border-gray-700 dark:border-gray-300 hover:opacity-75";
}
?>
<li>
    <a class="block border-b-2 px-3 py-2 sm:py-1 sm:my-0 font-semibold text-gray-800 transition duration-200 ease-in hover:border-gray-700 hover:opacity-75 dark:text-white dark:hover:border-gray-300 dark:hover:opacity-75 {{$active_classes}}"
        href="{{$href}}" target="{{$target}}">{{ $slot }}</a>
</li>
