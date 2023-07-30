@extends('frontend.layouts.app')

@section('title') {{ __("Categories") }} @endsection

@section('content')

<section class="bg-gray-100 text-gray-600 py-20">
    <div class="container mx-auto flex px-5 items-center justify-center flex-col">
        <div class="text-center lg:w-2/3 w-full">
            <h1 class="text-3xl sm:text-4xl mb-4 font-medium text-gray-800">
                {{ __("Categories") }}
            </h1>
            <p class="mb-8 leading-relaxed">
                The list of categories.
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
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                {{$$module_name_singular->description}}
            </p>
            <p class="mb-3 font-weight-bold">
                Total {{$$module_name_singular->posts->count()}} posts.
            </p>
        </x-frontend.card>

        @endforeach
    </div>
    <div class="d-flex justify-content-center w-100 mt-3">
        {{$$module_name->links()}}
    </div>
</section>

@endsection