@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}} - {{ __("Comments") }} @endsection


@section('content')

<section class="bg-gray-100 text-gray-600 py-20">
    <div class="container mx-auto flex px-5 items-center justify-center flex-col">
        <div class="text-center lg:w-2/3 w-full">
            <p class="mb-8 leading-relaxed">
                <a href="{{route('frontend.comments.index')}}" class="outline outline-1 outline-gray-800 bg-gray-200 hover:bg-gray-100 text-gray-800 text-sm font-semibold mr-2 px-3 py-1 rounded dark:bg-gray-700 dark:text-gray-300">
                    {{ __("Comments") }}
                </a>
            </p>
            <h1 class="text-3xl sm:text-4xl mb-4 font-medium text-gray-800">
                {{$$module_name_singular->name}}
            </h1>

            @include('frontend.includes.messages')
        </div>
    </div>
</section>


<section class="bg-white text-gray-600 py-20 px-20">
    <div class="grid grid-cols-1 gap-6">
        <div class="">
            <div class=" bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="p-5 flex flex-col items-stretch">
                    <h2 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white">
                        Post of {{$$module_name_singular->name}}
                    </h2>
                    <p class="my-4 flex-1 h-full font-normal text-gray-700 dark:text-gray-400">
                        {!! $$module_name_singular->comment !!}
                    </p>
                    <p class="my-4">
                        <small>{{$$module_name_singular->published_at_formatted}}</small>
                    </p>

                    <hr class="my-4">

                    <h6>
                        {{ __('Post') }}: <a class="underline hover:text-gray-800" href="{{route('frontend.posts.show', [encode_id($$module_name_singular->post_id), $$module_name_singular->post->slug])}}">{{$$module_name_singular->post->name}}</a>
                    </h6>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white text-gray-600 py-20 px-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="col-span-2">
            <h2 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white text-center">
                Post of {{$$module_name_singular->name}}
            </h2>
        </div>
        <div class="">
            @php
            $post = $$module_name_singular->post;
            $post_details_url = route("frontend.posts.show",[encode_id($post->id), $post->slug]);
            @endphp
            <div class=" bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col items-stretch">

                    <a href="{{ $post_details_url }}">
                        <img class="rounded-t-lg" src="{{$post->featured_image}}" alt="{{$post->name}}" />
                    </a>
                    <div class="p-5 flex flex-col items-stretch">
                        <a href="{{ $post_details_url }}">
                            <h2 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white">
                                {{$post->name}}
                            </h2>
                        </a>
                        <p class="flex-1 h-full mb-3 font-normal text-gray-700 dark:text-gray-400">
                            {{$post->intro}}
                        </p>
                        <p class="card-text">
                            <a href="{{route('frontend.categories.show', [encode_id($post->category_id), $post->category->slug])}}" class="badge bg-primary">{{$post->category_name}}</a>
                        </p>

                        <p class="card-text">
                            @foreach ($post->tags as $tag)
                            <a href="{{route('frontend.tags.show', [encode_id($tag->id), $tag->slug])}}" class="badge bg-warning text-dark">{{$tag->name}}</a>
                            @endforeach
                        </p>

                        <p class="card-text">
                            <span class="badge bg-primary">
                                <i class="now-ui-icons ui-2_chat-round"></i> Total {{$post->comments->count()}} comments
                            </span>
                        </p>

                        <p class="card-text">
                            <small class="text-muted">{{$post->published_at_formatted}}</small>
                        </p>

                        <div class="text-end">
                            <a href="{{ $post_details_url }}" class="inline-flex items-center text-sm outline outline-1 outline-gray-800 text-gray-700 hover:text-gray-100 bg-gray-200 hover:bg-gray-700 py-2 px-3 focus:outline-none rounded">
                                Read more
                                <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="">
            <div class=" bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="p-5 flex flex-col items-stretch">
                    <h3 class="mb-2 text-xl tracking-tight text-gray-900 dark:text-white">
                        Other Comments of the this post
                    </h3>
                    <!-- <p class="my-4 flex-1 h-full font-normal text-gray-700 dark:text-gray-400">
                        {!! $$module_name_singular->comment !!}
                    </p>
                    <p class="my-4">
                        <small>{{$$module_name_singular->published_at_formatted}}</small>
                    </p> -->

                    <hr>

                    @foreach ($post->comments as $comment)
                    <div class="pb-4">
                        <h6>
                            {{$comment->name}}
                        </h6>
                        {!! $comment->comment !!}
                        <br>
                        -- {{$comment->user_name}}
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@endsection