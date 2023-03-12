@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}} - {{ __("Tags") }} @endsection

@section('content')

<section class="bg-gray-100 text-gray-600 py-20">
    <div class="container mx-auto flex px-5 items-center justify-center flex-col">
        <div class="text-center lg:w-2/3 w-full">
            <p class="mb-8 leading-relaxed">
                <a href="{{route('frontend.tags.index')}}" class="outline outline-1 outline-gray-800 bg-gray-200 hover:bg-gray-100 text-gray-800 text-sm font-semibold mr-2 px-3 py-1 rounded dark:bg-gray-700 dark:text-gray-300">
                    {{ __("Tags") }}
                </a>
            </p>
            <h1 class="text-3xl sm:text-4xl mb-4 font-medium text-gray-800">
                {{$$module_name_singular->name}}
            </h1>
            <p class="mb-8 leading-relaxed">
                {{$$module_name_singular->description}}
            </p>

            @include('frontend.includes.messages')
        </div>
    </div>
</section>

<section class="bg-white text-gray-600 py-20 px-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        @foreach ($posts as $post)
        @php
        $details_url = route("frontend.posts.show",[encode_id($post->id), $post->slug]);
        @endphp

        <div class="">
            <div class=" bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <a href="{{$details_url}}">
                    <img class="rounded-t-lg" src="{{$post->featured_image}}" alt="{{$post->name}}" />
                </a>
                <div class="p-5 flex flex-col items-stretch">
                    <a href="{{$details_url}}">
                        <h2 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white">
                            {{$post->name}}
                        </h2>
                    </a>
                    <p class="flex-1 h-full mb-3 font-normal text-gray-700 dark:text-gray-400">
                        {{$post->intro}}
                    </p>

                    <div class="text-end">
                        <a href="{{$details_url}}" class="inline-flex items-center text-sm outline outline-1 outline-gray-800 text-gray-700 hover:text-gray-100 bg-gray-200 hover:bg-gray-700 py-2 px-3 focus:outline-none rounded">
                            Read more
                            <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>
    <div class="d-flex justify-content-center w-100 mt-4">
        {{$posts->links()}}
    </div>
</section>

@endsection