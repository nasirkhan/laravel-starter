@extends('frontend.layouts.app')

@section('title')
{{$$module_name_singular->name}}
@stop


@section('content')
<div class="page-header page-header-small">

    <div class="page-header-image" data-parallax="true" style="background-image:url('{{asset($$module_name_singular->featured_image)}}');">
    </div>
    <div class="content-center">
        <div class="container">
            <h1 class="title">
                {{$$module_name_singular->name}}
                <br>
                <small>{{isset($$module_name_singular->created_by_alias)? $$module_name_singular->created_by_alias : $$module_name_singular->created_by_name}}</small>
            </h1>

            @include('flash::message')

            <!-- Errors block -->
            @include('frontend.includes.errors')
            <!-- / Errors block -->

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
                    @php
                    $post_details_url = route('frontend.posts.show',[encode_id($$module_name_singular->id), $$module_name_singular->slug]);
                    @endphp
                    <img class="card-img-top" src="{{$$module_name_singular->featured_image}}" alt="{{$$module_name_singular->name}}">
                    <div class="card-body">
                        <a href="{{$post_details_url}}">
                            <h4 class="card-title">{{$$module_name_singular->name}}</h4>
                        </a>
                        <h6 class="card-subtitle mb-2 text-muted">
                            {!!isset($$module_name_singular->created_by_alias)? $$module_name_singular->created_by_alias : '<a href="'.route('frontend.users.profile', $$module_name_singular->created_by).'">'.$$module_name_singular->created_by_name.'</a>'!!}
                        </h6>
                        <hr>
                        <p class="card-text">
                            {!!$$module_name_singular->content!!}
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
                            Comments (Total {{$$module_name_singular->comments->count()}})
                            <br>
                            <?php
                            $comments_all = $$module_name_singular->comments;
                            $comments_level1 = $comments_all->where('parent_id','');
                            ?>
                            @foreach ($comments_level1 as $comment)
                            <blockquote>
                                <div class="blockquote blockquote-primary">
                                    <a href="{{route('frontend.comments.show', encode_id($comment->id))}}">
                                        <!-- <i class="now-ui-icons ui-2_chat-round"></i> -->
                                        <i class="far fa-comment-alt"></i>
                                    </a>
                                    {{$comment->name}}
                                    <br>

                                    {!!$comment->comment!!}

                                    <!-- <br>
                                    <br> -->

                                    <small>
                                        - {{$comment->user_name}}
                                    </small>

                                    @guest
                                    <a href="{{route('frontend.auth.login')}}?redirectTo={{url()->current()}}" class="btn btn-primary btn-sm float-right m-0"><i class="fas fa-user-shield"></i> Login & Reply</a>
                                    @endguest

                                    @auth
                                    <button type="button" id="replyBtn{{encode_id($comment->id)}}" class="btn btn-primary btn-sm float-right m-0" data-toggle="collapse" href="#replyForm{{encode_id($comment->id)}}" role="button" aria-expanded="false" aria-controls="replyForm{{encode_id($comment->id)}}">Reply</button>
                                    @endauth

                                    <?php
                                    $comments_of_comment = $comments_all->where('parent_id', $comment->id);
                                    ?>
                                    @if ($comments_of_comment)
                                    <hr>
                                    <strong>Replies</strong>
                                    <ul>
                                        @foreach ($comments_of_comment as $comment_reply)
                                        <li>
                                            {!!$comment_reply->comment!!} - {{$comment->user_name}}
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                @auth
                                <div class="collapse multi-collapse" id="replyForm{{encode_id($comment->id)}}">
                                    <p>
                                        {{ html()->form('POST', route("frontend.comments.store"))->class('form')->open() }}

                                        <?php
                                        $field_name = 'parent_id';
                                        $field_lable = label_case($field_name);
                                        $field_placeholder = $field_lable;
                                        $required = "required";
                                        ?>
                                        {{ html()->hidden($field_name)->value(encode_id($comment->id))->attributes(["$required"]) }}

                                        <?php
                                        $field_name = 'post_id';
                                        $field_lable = label_case($field_name);
                                        $field_placeholder = $field_lable;
                                        $required = "required";
                                        ?>
                                        {{ html()->hidden($field_name)->value(encode_id($$module_name_singular->id))->attributes(["$required"]) }}

                                        <?php
                                        $field_name = 'user_id';
                                        $field_lable = label_case($field_name);
                                        $field_placeholder = $field_lable;
                                        $required = "required";
                                        ?>
                                        {{ html()->hidden($field_name)->value(encode_id(auth()->user()->id))->attributes(["$required"]) }}

                                        <?php
                                        $field_name = 'name';
                                        $field_lable = label_case($field_name);
                                        $field_placeholder = $field_lable;
                                        $required = "required";
                                        ?>
                                        {{ html()->hidden($field_name)->value("Reply of ".$comment->name)->attributes(["$required"]) }}

                                        <div class="row">
                                            <div class="col-1">
                                                &nbsp;
                                            </div>
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <?php
                                                    $field_name = 'comment';
                                                    $field_lable = "Reply";
                                                    $field_placeholder = $field_lable;
                                                    $required = "required";
                                                    ?>
                                                    <!-- {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!} -->
                                                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group">
                                                    {{ html()->button($text = "<i class='fas fa-save'></i> Submit", $type = 'submit')->class('btn btn-success m-0') }}
                                                </div>
                                            </div>
                                        </div>

                                        {{ html()->form()->close() }}
                                    </p>
                                </div>
                                @endauth

                            </blockquote>
                            @endforeach
                        </p>
                        <div class="row justify-content-md-center">
                            @auth
                            <div class="col-4 align-self-center">
                                <p>
                                    <a class="btn btn-primary btn-lg btn-block" data-toggle="collapse" href="#commentForm" role="button" aria-expanded="false" aria-controls="commentForm"><i class="far fa-comment-alt"></i> Write new comment</a>
                                </p>
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col-12 col-sm-8 align-self-center">
                                    <div class="collapse multi-collapse" id="commentForm">
                                        <div class="card card-body">
                                            <p>
                                                Your comment will be in the moderation queue. If your comment will be approved, you will get notification and it will be displayed here.
                                                <br>
                                                Please submit once & wait till published.
                                            </p>

                                            {{ html()->form('POST', route("frontend.comments.store"))->class('form')->open() }}
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'name';
                                                        $field_lable = "Subject";
                                                        $field_placeholder = $field_lable;
                                                        $required = "required";
                                                        ?>
                                                        {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                                        {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php
                                                        $field_name = 'comment';
                                                        $field_lable = "Details Comment";
                                                        $field_placeholder = $field_lable;
                                                        $required = "required";
                                                        ?>
                                                        {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                                        {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            $field_name = 'post_id';
                                            $field_lable = label_case($field_name);
                                            $field_placeholder = $field_lable;
                                            $required = "required";
                                            ?>
                                            {{ html()->hidden($field_name)->value(encode_id($$module_name_singular->id))->attributes(["$required"]) }}

                                            <?php
                                            $field_name = 'user_id';
                                            $field_lable = label_case($field_name);
                                            $field_placeholder = $field_lable;
                                            $required = "required";
                                            ?>
                                            {{ html()->hidden($field_name)->value(encode_id(auth()->user()->id))->attributes(["$required"]) }}

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        {{ html()->button($text = "<i class='fas fa-save'></i> Submit", $type = 'submit')->class('btn btn-success') }}
                                                    </div>
                                                </div>
                                            </div>

                                            {{ html()->form()->close() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endauth
                            @guest
                            <div class="col-12 col-sm-4 align-self-center">
                                <p>
                                    <a href="{{route('frontend.auth.login')}}?redirectTo={{url()->current()}}" class="btn btn-primary btn-lg btn-block"><i class="fas fa-user-shield"></i> Login & Write new comment</a>
                                </p>
                            </div>
                            @endguest
                        </div>

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
