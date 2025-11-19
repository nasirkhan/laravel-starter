@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <h1 class="text-2xl text-zink-800 font-semibold">{{ $title }}</h1>
    <h3 class="">{{ $description }}</h3>
</div>
