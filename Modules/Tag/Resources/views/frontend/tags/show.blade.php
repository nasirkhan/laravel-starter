@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}} @endsection

@section('content')

<section class="section-header bg-primary text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <div class="mb-2">
                    <a href="{{route('frontend.tags.index')}}" class="badge badge-sm badge-warning text-uppercase px-3">
                        {{ __("Tags") }}
                    </a>
                </div>
                <h1 class="display-2 mb-4">
                    {{$$module_name_singular->name}}
                </h1>
                <p class="lead">
                    {{$$module_name_singular->description}}
                </p>

                @include('frontend.includes.messages')
            </div>
        </div>
    </div>
    <div class="pattern bottom"></div>
</section>

<section class="section section-lg line-bottom-light">
    <div class="container mt-n7 mt-lg-n12 z-2">
        <div class="row">

            @foreach ($posts as $post)
            @php
            $details_url = route("frontend.posts.show",[encode_id($post->id), $post->slug]);
            @endphp

            <div class="col-12 col-md-4 mb-4">
                <div class="card bg-white border-light shadow-soft p-4 rounded">
                    <a href="{{$details_url}}"><img src="{{$post->featured_image}}" class="card-img-top" alt=""></a>
                    <div class="card-body p-0 pt-4">
                        <a href="{{$details_url}}" class="h3">{{$post->name}}</a>
                        <div class="d-flex align-items-center my-4">
                            <img class="avatar avatar-sm rounded-circle" src="{{asset('img/avatars/'.rand(1, 8).'.jpg')}}" alt="">
                            {!!isset($post->created_by_alias)? $post->created_by_alias : '<a href="'.route('frontend.users.profile', $$module_name_singular->created_by).'"><h6 class="text-muted small ml-2 mb-0">'.$post->created_by_name.'</h6></a>'!!}
                        </div>
                        <p class="mb-3">{{$post->intro}}</p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="d-flex justify-content-center w-100 mt-3">
            {{$posts->links()}}
        </div>
    </div>
</section>

@endsection
