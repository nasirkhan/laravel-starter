@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}} - {{ __("Comments") }} @endsection


@section('content')

<section class="bg-gray-100 text-gray-600 py-10 sm:py-20">
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


<section class="bg-white text-gray-600 p-6 sm:p-20 sm:pb-0">
    <div class="grid grid-cols-1 gap-6">
        <div class="">
            <div class=" bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="p-5 flex flex-col items-stretch">
                    <h2 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white">
                        {{$$module_name_singular->name}}
                    </h2>
                    <p class="my-4 flex-1 h-full font-normal text-gray-700 dark:text-gray-400">
                        {!! $$module_name_singular->comment !!}
                    </p>
                    <p class="my-4">
                        <small>{{$$module_name_singular->published_at_formatted}}</small>
                    </p>

                    <hr class="my-4">

                    <h6>
                        {{ __('Post') }}: <a class="underline hover:text-gray-800" href="{{route('frontend.posts.show', [encode_id($$module_name_singular->post->id), $$module_name_singular->post->slug])}}">{{$$module_name_singular->post->name}}</a>
                    </h6>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white text-gray-600 p-6 sm:p-20">
    <div class="flex flex-col mb-4">
        <h2 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white text-center">
            Post of {{$$module_name_singular->name}}
        </h2>
        <hr class="w-1/2 mx-auto">
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="col-span-1">
            @php
            $post = $$module_name_singular->post;
            $post_details_url = route("frontend.posts.show",[encode_id($post->id), $post->slug]);
            @endphp
            <x-frontend.card :url="$post_details_url" :name="$post->name" :image="$post->featured_image">
                @if($post->created_by_alias)
                <div class="flex flex-row items-center my-4">
                    <img class="w-5 h-5 sm:w-8 sm:h-8 rounded-full" src="{{asset('img/avatars/'.rand(1, 8).'.jpg')}}" alt="Author profile image">
                    <h6 class="text-muted text-sm small ml-2 mb-0">
                        {{ $post->created_by_alias }}
                    </h6>
                </div>
                @else
                <div class="flex flex-row items-center my-4">
                    <img class="w-5 h-5 sm:w-8 sm:h-8 rounded-full" src="{{asset('img/avatars/'.rand(1, 8).'.jpg')}}" alt="">

                    <a href="{{ route('frontend.users.profile', $post->created_by) }}">
                        <h6 class="text-muted text-sm small ml-2 mb-0">
                            {{ $post->created_by_name }}
                        </h6>
                    </a>
                </div>
                @endif

                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                    {{$post->intro}}
                </p>
                <p>
                    <x-frontend.badge :url="route('frontend.categories.show', [encode_id($post->category_id)])" :text="$post->category_name" />
                </p>
                <p>
                    @foreach ($post->tags as $tag)
                    <x-frontend.badge :url="route('frontend.tags.show', [encode_id($tag->id), $tag->slug])" :text="$tag->name" />
                    @endforeach
                </p>
            </x-frontend.card>
        </div>

        <div class="col-span-1">
            <div class=" bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="p-5 flex flex-col items-stretch">
                    <h3 class="mb-2 text-xl tracking-tight text-gray-900 dark:text-white">
                        Other Comments of the this post
                    </h3>
                    
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