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
                Category: {{$$module_name_singular->name}}
            </h1>

            <div class="text-center">
                <a href="#pablo" class="btn btn-primary btn-icon btn-round">
                    <i class="fab fa-facebook-square"></i>
                </a>
                <a href="#pablo" class="btn btn-primary btn-icon btn-round">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#pablo" class="btn btn-primary btn-icon btn-round">
                    <i class="fab fa-google-plus"></i>
                </a>
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
                            {!!$$module_name_singular->description!!}
                        </p>

                        <p class="card-text">
                            <div class="row">
                                <div class="col">
                                    <div class="text-center">
                                        <a href="#pablo" class="btn btn-primary btn-icon btn-round">
                                            <i class="fab fa-facebook-square"></i>
                                        </a>
                                        <a href="#pablo" class="btn btn-primary btn-icon btn-round">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="#pablo" class="btn btn-primary btn-icon btn-round">
                                            <i class="fab fa-google-plus"></i>
                                        </a>
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
                    Posts in {{$$module_name_singular->name}} (Total {{$$module_name_singular->posts->count()}})
                </h3>
            </div>
        </div>
        <div class="row">
            @foreach ($posts as $post)
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
                                        <a href="{{$post_details_url}}" class="btn btn-primary">Continue Reading</a>
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
            @endforeach
        </div>
        <div class="row">
            <div class="col">
                {{$posts->links()}}
            </div>
        </div>
    </div>
</div>


@endsection
