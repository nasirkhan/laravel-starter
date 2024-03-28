@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section class="bg-white dark:bg-gray-900">
    <div class="py-20 px-4 mx-auto max-w-screen-xl text-center sm:px-12 sm:mt-6">
        <div class="flex justify-center m-6">
            <img class="h-24 rounded" alt="{{ app_name() }}" src="{{ asset('img/logo-square.jpg') }}">
        </div>
        <h1 class="mb-6 text-4xl font-extrabold tracking-tight leading-none text-gray-900 sm:text-6xl dark:text-white">
            {{ app_name() }}
        </h1>
        <p class="mb-10 text-lg font-normal text-gray-500 sm:text-2xl sm:px-16 xl:px-48 dark:text-gray-400">
            {!! setting('app_description') !!}
        </p>
        <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
            <a href="https://github.com/nasirkhan/laravel-starter" target="_blank" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center rounded-lg text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-github"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" /></svg>
                <span class="ms-2">
                    Github
                </span>
            </a>
            <a href="https://nasirkhn.com" target="_blank" class="bg-white inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-world-www"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 7a9 9 0 0 0 -7.5 -4a8.991 8.991 0 0 0 -7.484 4" /><path d="M11.5 3a16.989 16.989 0 0 0 -1.826 4" /><path d="M12.5 3a16.989 16.989 0 0 1 1.828 4" /><path d="M19.5 17a9 9 0 0 1 -7.5 4a8.991 8.991 0 0 1 -7.484 -4" /><path d="M11.5 21a16.989 16.989 0 0 1 -1.826 -4" /><path d="M12.5 21a16.989 16.989 0 0 0 1.828 -4" /><path d="M2 10l1 4l1.5 -4l1.5 4l1 -4" /><path d="M17 10l1 4l1.5 -4l1.5 4l1 -4" /><path d="M9.5 10l1 4l1.5 -4l1.5 4l1 -4" /></svg>
                <span class="ms-2">
                    Website
                </span>
            </a>  
        </div>

        @include('frontend.includes.messages')
    </div>
</section>


<section class="bg-gray-50">
    <div class="container mx-auto flex px-5 py-10 items-center justify-center flex-col">
        <div class="text-center lg:w-2/3 w-full">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-800">
                Screenshots of the project
            </h1>
            <p class="mb-8 leading-relaxed">
                In the following section we listed a number of screenshots of different parts of the project, Laravel Starter.
            </p>
        </div>
    </div>
</section>

<section class="pb-20 bg-gray-50">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-5">
        <div class="shadow-lg p-3 sm:p-10 rounded-lg">
            <img src="https://github.com/nasirkhan/laravel-starter/assets/396987/b9ca9cd8-fa7c-43f0-b54f-47e7c4966d9c" alt="Page preview">
        </div>
        <div class="shadow-lg p-3 sm:p-10 rounded-lg row-span-2">
            <img src="https://github.com/nasirkhan/laravel-starter/assets/396987/b067e211-1208-49a6-859b-7a6810e3f3bb" alt="Page preview">
        </div>
        <div class="shadow-lg p-3 sm:p-10 rounded-lg">
            <img src="https://github.com/nasirkhan/laravel-starter/assets/396987/413b3c75-4a1f-47e3-8885-bc6bd475213c" alt="Page preview">
        </div>
    </div>
</section>

@endsection