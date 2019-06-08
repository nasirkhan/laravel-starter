@extends('frontend.layouts.app')

@section('title')
{{$$module_name_singular->title}}
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
                        <hr>

                        <p class="card-text">
                            <h6>
                                Posts (Total {{$$module_name_singular->posts->count()}})
                            </h6>
                            <ul>
                                @foreach ($$module_name_singular->posts as $post)
                                <li>
                                    <a href="{{route("frontend.posts.show",[encode_id($post->id), $post->slug])}}">{{$post->title}}</a>
                                </li>
                                @endforeach
                            </ul>
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
