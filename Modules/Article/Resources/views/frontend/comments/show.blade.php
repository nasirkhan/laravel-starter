@extends('frontend.layouts.app')

@section('title')
{{$$module_name_singular->name}}
@stop


@section('content')
<div class="page-header page-header-small">

    <div class="page-header-image" data-parallax="true" style="background-image:url('{{asset('img/cover-01.jpg')}}');">
    </div>
    <div class="content-center">
        <div class="container">
            <h1 class="title">
                Comment: {{$$module_name_singular->name}}
            </h1>

            <div class="text-center">

                <button class="btn btn-primary btn-icon btn-round" data-sharer="facebook" data-hashtag="MuktoLibrary" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Facebook" data-original-title="Share on Facebook"><i class="fab fa-facebook-square"></i></button>

                <button class="btn btn-primary btn-icon btn-round" data-sharer="twitter" data-via="MuktoLibrary" data-title="{{$$module_name_singular->name}}" data-hashtags="MuktoLibrary" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Twitter" data-original-title="Share on Twitter"><i class="fab fa-twitter"></i></button>

                <button class="btn btn-primary btn-icon btn-round" data-sharer="whatsapp" data-title="{{$$module_name_singular->name}}" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Whatsapp" data-original-title="Share on Whatsapp" data-web=""><i class="fab fa-whatsapp"></i></button>

            </div>
        </div>
    </div>
</div>


<div class="section">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{$$module_name_singular->name}}</h4>
                        <hr>
                        <p class="card-text">
                            {!!$$module_name_singular->comment!!}
                        </p>

                        <p class="card-text">
                            <div class="row">
                                <div class="col">
                                    <div class="text-center">

                                        <button class="btn btn-primary btn-icon btn-round" data-sharer="facebook" data-hashtag="MuktoLibrary" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Facebook" data-original-title="Share on Facebook"><i class="fab fa-facebook-square"></i></button>

                                        <button class="btn btn-primary btn-icon btn-round" data-sharer="twitter" data-via="MuktoLibrary" data-title="{{$$module_name_singular->name}}" data-hashtags="MuktoLibrary" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Twitter" data-original-title="Share on Twitter"><i class="fab fa-twitter"></i></button>

                                        <button class="btn btn-primary btn-icon btn-round" data-sharer="whatsapp" data-title="{{$$module_name_singular->name}}" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Whatsapp" data-original-title="Share on Whatsapp" data-web=""><i class="fab fa-whatsapp"></i></button>

                                    </div>
                                </div>
                            </div>
                        </p>

                        <p class="card-text">
                            <small class="text-muted">{{$$module_name_singular->published_at_formatted}}</small>
                        </p>
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
                        {{$comment->comment}}
                        <br>
                        -- {{$comment->user_name}}
                        <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
