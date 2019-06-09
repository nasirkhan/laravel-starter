@extends('frontend.layouts.app')

@section('title')
{{$$module_name_singular->title}}
@stop


@section('content')
<div class="page-header page-header-small">

    <div class="page-header-image" data-parallax="true" style="background-image:url('{{asset($$module_name_singular->featured_image)}}');">
    </div>
    <div class="content-center">
        <div class="container">
            <h1 class="title">
                {{$$module_name_singular->title}}
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
                    @php
                    $post_details_url = route('frontend.posts.show',[encode_id($$module_name_singular->id), $$module_name_singular->slug]);
                    @endphp
                    <img class="card-img-top" src="{{$$module_name_singular->featured_image}}" alt="{{$$module_name_singular->title}}">
                    <div class="card-body">
                        <a href="{{$post_details_url}}">
                            <h4 class="card-title">{{$$module_name_singular->title}}</h4>
                        </a>
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{$$module_name_singular->author_name}}
                        </h6>
                        <hr>
                        <p class="card-text">
                            {!!$$module_name_singular->content!!}
                        </p>
                        <hr>

                        <p class="card-text">
                            <a href="{{route('frontend.categories.show', $$module_name_singular->category_id)}}" class="badge badge-primary">{{$$module_name_singular->category_name}}</a>
                        </p>

                        <p class="card-text">
                            @foreach ($$module_name_singular->tags as $tag)
                            <a href="{{route('frontend.tags.show', encode_id($tag->id))}}" class="badge badge-warning">{{$tag->name}}</a>
                            @endforeach
                        </p>

                        <p class="card-text">
                            Comments (Total {{$$module_name_singular->comments->count()}})
                            <br>
                            @foreach ($$module_name_singular->comments as $comment)
                            <blockquote>
                                <p class="blockquote blockquote-primary">
                                    <a href="{{route('frontend.comments.show', encode_id($comment->id))}}">
                                        <i class="now-ui-icons ui-2_chat-round"></i>
                                    </a>
                                    {{$comment->name}}
                                    <br>

                                    {{$comment->comment}}

                                    <br>
                                    <br>

                                    <small>
                                        - {{$comment->user_name}}
                                    </small>
                                </p>

                            </blockquote>
                            @endforeach
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
    </div>
</div>


@endsection
