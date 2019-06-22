@extends('frontend.layouts.app')

@section('title')
Posts
@stop


@section('content')
<div class="page-header page-header-small">

    <div class="page-header-image" data-parallax="true" style="background-image:url('{{asset('img/cover-01.jpg')}}');">
    </div>
    <div class="content-center">
        <div class="container">
            <h1 class="title">
                Posts
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
            @foreach ($$module_name as $$module_name_singular)
            <div class="col-12 col-sm-6">
                <div class="card">
                    @php
                    $post_details_url = route("frontend.$module_name.show",[encode_id($$module_name_singular->id), $$module_name_singular->slug]);
                    @endphp
                    <a href="{{$post_details_url}}">
                        <img class="card-img-top" src="{{$$module_name_singular->featured_image}}" alt="{{$$module_name_singular->name}}">
                    </a>
                    <div class="card-body">
                        <a href="{{$post_details_url}}">
                            <h4 class="card-title">{{$$module_name_singular->name}}</h4>
                        </a>
                        <h6 class="card-subtitle mb-2 text-muted">
                            {{$$module_name_singular->author_name}}
                        </h6>
                        <hr>
                        <p class="card-text">
                            {{$$module_name_singular->intro}}
                        </p>
                        <hr>

                        <p class="card-text">
                            <a href="{{route('frontend.categories.show', [encode_id($$module_name_singular->category_id), $$module_name_singular->category->slug])}}" class="badge badge-primary">{{$$module_name_singular->category_name}}</a>
                        </p>

                        <p class="card-text">
                            @foreach ($$module_name_singular->tags as $tag)
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
                            <small class="text-muted">{{$$module_name_singular->published_at_formatted}}</small>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col">
                {{$$module_name->links()}}
            </div>
        </div>
    </div>
</div>


@endsection
