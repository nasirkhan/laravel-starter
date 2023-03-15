@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}} @endsection

@section('content')

<section class="bg-gray-100 text-gray-600 body-font px-20">
    <div class="container mx-auto flex px-5 py-8 sm:py-16 md:flex-row flex-col items-center">
        <div class="lg:flex-grow sm:w-4/12 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
            <h1 class="sm:text-4xl text-3xl mb-4 font-medium text-gray-800">
                {{$$module_name_singular->name}}
            </h1>
            @if($$module_name_singular->intro != "")
            <p class="mb-8 leading-relaxed">
                {{$$module_name_singular->intro}}
            </p>
            @endif

            @include('frontend.includes.messages')
        </div>
        <div class="sm:w-8/12">
            <img class="object-cover object-center rounded shadow-md" alt="{{$$module_name_singular->name}}" src="{{$$module_name_singular->featured_image}}">
        </div>
    </div>
</section>

<section class="py-10 px-20">
    <div class="container mx-auto flex px-5 py-10 md:flex-row flex-col">
        <div class="flex flex-col lg:flex-grow sm:w-8/12 sm:pr-8">
            <div class="pb-5">
                <p>
                    {!!$$module_name_singular->content!!}
                </p>
            </div>

            <hr>

            <div class="py-5">
                <div class="flex justify-between font-bold">
                    <div>
                        {{__('Written by')}}: {{isset($$module_name_singular->created_by_alias)? $$module_name_singular->created_by_alias : $$module_name_singular->created_by_name}}
                    </div>
                    <div>
                        {{__('Published at')}}: {{$$module_name_singular->published_at->isoFormat('llll')}}
                    </div>
                </div>
            </div>

            <div class="flex flex-row justify-between content-center items-center py-5">
                <p>
                    <span class="font-weight-bold">
                        @lang('Category'):
                    </span>

                    <a href="{{route('frontend.categories.show', [encode_id($$module_name_singular->category_id), $$module_name_singular->category->slug])}}" class="m-2 p-2 bg-gray-100 rounded border-transparent border hover:border-gray-800 transition ease-out duration-300">{{$$module_name_singular->category_name}}</a>
                </p>

                @if (count($$module_name_singular->tags))
                <p>
                    <span class="font-weight-bold">
                        @lang('Tags'):
                    </span>

                    @foreach ($$module_name_singular->tags as $tag)
                    <a href="{{route('frontend.tags.show', [encode_id($tag->id), $tag->slug])}}" class="m-2 p-2 bg-gray-100 rounded border-transparent border hover:border-gray-800 transition ease-out duration-300">{{$tag->name}}</a>
                    @endforeach
                </p>
                @endif
            </div>

            <div class="py-5">
                <div class="flex flex-row justify-around content-center items-center ">
                    <h6 class="">Share with others</h6>

                    <div>
                        @php $title_text = $$module_name_singular->name; @endphp

                        <button data-title='Share on Twitter' data-placement="top" class="tooltip p-2 m-2 hover:shadow-lg transition ease-out duration-300 border border-gray-400 hover:border-gray-600 hover:bg-gray-100 rounded-sm" data-sharer="twitter" data-via="muktolibrary" data-title="{{$title_text}}" data-hashtags="muktolibrary" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Twitter" data-original-title="Share on Twitter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                            </svg>
                        </button>

                        <button data-title='Share on Facebook' data-placement="top" class="tooltip p-2 m-2 hover:shadow-lg transition ease-out duration-300 border border-gray-400 hover:border-gray-600 hover:bg-gray-100 rounded-sm" data-sharer="facebook" data-hashtag="muktolibrary" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Facebook" data-original-title="Share on Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="py-5">
                @include('article::frontend.posts.blocks.comments')
            </div>
        </div>

        <div class="flex flex-col sm:w-4/12">
            <div class="py-5 sm:pt-0">
                <livewire:recent-posts />
            </div>
        </div>
    </div>
</section>

@endsection

@push ("after-style")

@endpush

@push ("after-scripts")
<script type="module" src="https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js"></script>
@endpush