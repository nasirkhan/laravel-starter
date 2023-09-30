@extends('frontend.layouts.app')

@section('title') {{ __("Comments") }} @endsection

@section('content')

<section class="bg-gray-100 text-gray-600 py-20">
    <div class="container mx-auto flex px-5 items-center justify-center flex-col">
        <div class="text-center lg:w-2/3 w-full">
            <h1 class="text-3xl sm:text-4xl mb-4 font-medium text-gray-800">
                {{ __("Comments") }}
            </h1>
            <p class="mb-8 leading-relaxed">
                The list of comments.
            </p>

            @include('frontend.includes.messages')
        </div>
    </div>
</section>

<section class="bg-white text-gray-600 p-6 sm:p-20">
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
        @foreach ($$module_name as $$module_name_singular)
        @php
        $details_url = route("frontend.$module_name.show",[encode_id($$module_name_singular->id), $$module_name_singular->slug]);
        @endphp

        <x-frontend.card :url="$details_url" :name="$$module_name_singular->name">
            <p class="mb-4 text-gray-700 dark:text-gray-400">
                {!! $$module_name_singular->comment !!}
            </p>
            <p class="mb-4">
                <small>{{$$module_name_singular->published_at_formatted}}</small>
            </p>

            <hr class="my-4">

            <h6>
                {{ __('Post') }}: <a class="underline hover:text-gray-800" href="{{route('frontend.posts.show', [encode_id($$module_name_singular->post->id), $$module_name_singular->post->slug])}}">{{$$module_name_singular->post->name}}</a>
            </h6>
        </x-frontend.card>

        <!-- <div class="">
            <div class=" bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="p-5 flex flex-col items-stretch">
                    <a href="{{$details_url}}">
                        <h2 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white">
                            {{$$module_name_singular->name}}
                        </h2>
                    </a>
                    <p class="mb-4 flex-1 h-full font-normal text-gray-700 dark:text-gray-400">
                        {!! $$module_name_singular->comment !!}
                    </p>
                    <p class="mb-4">
                        <small>{{$$module_name_singular->published_at_formatted}}</small>
                    </p>

                    <hr class="my-4">

                    <h6>
                        {{ __('Post') }}: <a class="underline hover:text-gray-800" href="{{route('frontend.posts.show', [encode_id($$module_name_singular->post_id), $$module_name_singular->post->slug])}}">{{$$module_name_singular->post->name}}</a>
                    </h6>
                </div>
            </div>
        </div> -->

        @endforeach
    </div>
    <div class="d-flex justify-content-center w-100 mt-3">
        {{$$module_name->links()}}
    </div>
</section>

@endsection