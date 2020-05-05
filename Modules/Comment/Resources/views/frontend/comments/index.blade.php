@extends('frontend.layouts.app')

@section('title')
Comments
@stop

@section('content')
<div class="page-header page-header-small">

    <div class="page-header-image" data-parallax="true" style="background-image:url('{{asset('img/cover-01.jpg')}}');">
    </div>
    <div class="content-center">
        <div class="container">
            <h1 class="title">
                Comments
            </h1>

            <div class="text-center">
                @php $title_text = 'Tags - Mukto Library'; @endphp

                <button class="btn btn-primary btn-icon btn-round" data-sharer="facebook" data-hashtag="MuktoLibrary" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Facebook" data-original-title="Share on Facebook"><i class="fab fa-facebook-square"></i></button>

                <button class="btn btn-primary btn-icon btn-round" data-sharer="twitter" data-via="MuktoLibrary" data-title="{{$title_text}}" data-hashtags="MuktoLibrary" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Twitter" data-original-title="Share on Twitter"><i class="fab fa-twitter"></i></button>

                <button class="btn btn-primary btn-icon btn-round" data-sharer="whatsapp" data-title="{{$title_text}}" data-url="{{url()->full()}}" data-toggle="tooltip" title="Share on Whatsapp" data-original-title="Share on Whatsapp" data-web=""><i class="fab fa-whatsapp"></i></button>

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

                    <div class="card-body">
                        <a href="{{$post_details_url}}">
                            <h4 class="card-title">{{$$module_name_singular->name}}</h4>
                        </a>
                        <hr>
                        <p class="card-text">
                            {{$$module_name_singular->comment}}
                        </p>
                        <hr>

                        <h6>
                            Post: <a href="{{route('frontend.posts.show', [encode_id($$module_name_singular->post_id), $$module_name_singular->post->slug])}}">{{$$module_name_singular->post->name}}</a>
                        </h6>

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
