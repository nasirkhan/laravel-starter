@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}} @endsection


@section('content')
<section class="section-header bg-primary text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">
                    {{$$module_name_singular->name}}
                </h1>
                <p class="lead">
                    {!! $$module_name_singular->comment !!}
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
            @php
            $details_url = route("frontend.$module_name.show",[encode_id($$module_name_singular->id), $$module_name_singular->slug]);
            @endphp
            <div class="col mb-4">
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

                        <hr>

                        <h6>
                            Post: <a href="{{route('frontend.posts.show', [encode_id($$module_name_singular->post_id), $$module_name_singular->post->slug])}}">{{$$module_name_singular->post->name}}</a>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h3>
                    Post of {{$$module_name_singular->name}}
                </h3>
            </div>
        </div>
        <div class="row">
            @php
            $post = $$module_name_singular->post;
            @endphp

            <div class="col-12 col-sm-6">
                <div class="card">
                    @php
                    $post_details_url = route("frontend.posts.show",[encode_id($post->id), $post->slug]);
                    @endphp
                    <a href="{{$post_details_url}}">
                        <img class="card-img-top" src="{{$post->featured_image}}" alt="{{$post->name}}">
                    </a>
                    <div class="card-body">
                        <a href="{{$post_details_url}}">
                            <h4 class="card-title">{{$post->name}}</h4>
                        </a>
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{$post->author_name}}
                        </h6>
                        <hr>
                        <p class="card-text">
                            {{$post->intro}}
                        </p>
                        <hr>

                        <p class="card-text">
                            <a href="{{route('frontend.categories.show', [encode_id($post->category_id), $post->category->slug])}}" class="badge badge-primary">{{$post->category_name}}</a>
                        </p>

                        <p class="card-text">
                            @foreach ($post->tags as $tag)
                            <a href="{{route('frontend.tags.show', [encode_id($tag->id), $tag->slug])}}" class="badge badge-warning">{{$tag->name}}</a>
                            @endforeach
                        </p>

                        <p class="card-text">
                            <span class="badge badge-primary">
                                <i class="now-ui-icons ui-2_chat-round"></i> Total {{$post->comments->count()}} comments
                            </span>
                        </p>

                        <p class="card-text">
                            <div class="row">
                                <div class="col">
                                    <div class="float-right">
                                        <a href="{{$post_details_url}}" class="btn btn-primary"><i class="fas fa-long-arrow-alt-right"></i> Continue Reading</a>
                                    </div>
                                </div>
                            </div>
                        </p>

                        <p class="card-text">
                            <small class="text-muted">{{$post->published_at_formatted}}</small>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h3>
                            Other Comments of the this post
                        </h3>
                        @foreach ($post->comments as $comment)
                        <h6>
                            {{$comment->name}}
                        </h6>
                        {!! $comment->comment !!}
                        <br>
                        -- {{$comment->user_name}}
                        <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center w-100 mt-3">

        </div>
    </div>
</section>

@endsection
