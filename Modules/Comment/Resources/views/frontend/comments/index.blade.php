@extends('frontend.layouts.app')

@section('title') @lang('Comments') @endsection

@section('content')

<section class="section-header bg-primary text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">
                    @lang('Comments')
                </h1>
                <p class="lead">
                    The list of Comments.
                </p>
                <div class="text-center">
                    @php $title_text = __('Comments'); @endphp

                    <button class="btn btn-outline-white" data-sharer="facebook" data-hashtag="LaravelStarter" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Facebook" data-original-title="Share on Facebook"><i class="fab fa-facebook-square"></i></button>

                    <button class="btn btn-outline-white" data-sharer="twitter" data-via="LaravelStarter" data-title="{{$title_text}}" data-hashtags="LaravelStarter" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Twitter" data-original-title="Share on Twitter"><i class="fab fa-twitter"></i></button>

                    <button class="btn btn-outline-white" data-sharer="whatsapp" data-title="{{$title_text}}" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Whatsapp" data-original-title="Share on Whatsapp" data-web=""><i class="fab fa-whatsapp"></i></button>

                </div>

                @include('frontend.includes.messages')
            </div>
        </div>
    </div>
    <div class="pattern bottom"></div>
</section>

<section class="section section-lg line-bottom-light">
    <div class="container mt-n7 mt-lg-n12 z-2">
        <div class="row">
            @foreach ($$module_name as $$module_name_singular)
            @php
            $details_url = route("frontend.$module_name.show",[encode_id($$module_name_singular->id), $$module_name_singular->slug]);
            @endphp
            <div class="col-12 col-md-4 mb-4">
                <div class="card bg-white border-light shadow-soft p-4 rounded">
                    <div class="card-body p-0 pt-4">
                        <a href="{{$details_url}}">
                            <h4 class="card-title">{{$$module_name_singular->name}}</h4>
                        </a>
                        <hr>
                        <p class="card-text">
                            {!! $$module_name_singular->comment !!}
                        </p>
                        <p>
                            <small class="text-muted">{{$$module_name_singular->published_at_formatted}}</small>
                        </p>
                        <p>
                            <a href="{{$details_url}}" class="btn btn-outline-primary btn-sm">Continue Reading</a>
                        </p>

                        <hr>

                        <h6>
                            Post: <a href="{{route('frontend.posts.show', [encode_id($$module_name_singular->post_id), $$module_name_singular->post->slug])}}">{{$$module_name_singular->post->name}}</a>
                        </h6>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="d-flex justify-content-center w-100 mt-3">
            {{$$module_name->links()}}
        </div>
    </div>
</section>

@endsection
