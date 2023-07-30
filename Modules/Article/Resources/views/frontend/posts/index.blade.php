@extends('frontend.layouts.app')

@section('title') {{ __("Posts") }} @endsection

@section('content')

<section class="bg-gray-100 text-gray-600 py-20">
    <div class="container mx-auto flex px-5 items-center justify-center flex-col">
        <div class="text-center lg:w-2/3 w-full">
            <h1 class="text-3xl sm:text-4xl mb-4 font-medium text-gray-800">
                {{ __("Articles") }}
            </h1>
            <p class="mb-8 leading-relaxed">
                We publish articles on a number of topics.
                <br>
                We encourage you to read our posts and let us know your feedback. It would be really help us to move forward.
            </p>

            @include('frontend.includes.messages')
        </div>
    </div>
</section>

<section class="bg-white text-gray-600 p-6 sm:p-20">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        @foreach ($$module_name as $$module_name_singular)
        @php
        $details_url = route("frontend.$module_name.show",[encode_id($$module_name_singular->id), $$module_name_singular->slug]);
        @endphp
        <x-frontend.card :url="$details_url" :name="$$module_name_singular->name" :image="$$module_name_singular->featured_image">
            @if($$module_name_singular->created_by_alias)
            <div class="flex flex-row items-center my-4">
                <img class="w-5 h-5 sm:w-8 sm:h-8 rounded-full" src="{{asset('img/avatars/'.rand(1, 8).'.jpg')}}" alt="Author profile image">
                <h6 class="text-muted text-sm small ml-2 mb-0">
                    {{ $$module_name_singular->created_by_alias }}
                </h6>
            </div>
            @else
            <div class="flex flex-row items-center my-4">
                <img class="w-5 h-5 sm:w-8 sm:h-8 rounded-full" src="{{asset('img/avatars/'.rand(1, 8).'.jpg')}}" alt="">

                <a href="{{ route('frontend.users.profile', $$module_name_singular->created_by) }}">
                    <h6 class="text-muted text-sm small ml-2 mb-0">
                        {{ $$module_name_singular->created_by_name }}
                    </h6>
                </a>
            </div>
            @endif

            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                {{$$module_name_singular->intro}}
            </p>
            <p>
                <x-frontend.badge :url="route('frontend.categories.show', [encode_id($$module_name_singular->category_id), $$module_name_singular->category->slug])" :text="$$module_name_singular->category_name" />
            </p>
            <p>
                @foreach ($$module_name_singular->tags as $tag)
                <x-frontend.badge :url="route('frontend.tags.show', [encode_id($tag->id), $tag->slug])" :text="$tag->name" />
                @endforeach
            </p>
        </x-frontend.card>
        @endforeach
    </div>
    <div class="d-flex justify-content-center w-100 mt-4">
        {{$$module_name->links()}}
    </div>
</section>
@endsection