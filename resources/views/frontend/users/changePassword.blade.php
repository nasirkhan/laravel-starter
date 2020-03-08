@extends('frontend.layouts.app')

@section('title')
{{auth()->user()->name}}'s Profile  | {{ app_name() }}
@stop


@section('content')

<div class="page-header page-header-small" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image: url('{{asset('img/cover-01.jpg')}}');">
    </div>
    <div class="container">
        <div class="content-center">
            <div class="photo-container">
                <img src="{{asset($user->avatar)}}" alt="{{auth()->user()->name}}">
            </div>
            <h3 class="title">{{auth()->user()->name}}</h3>
            <p class="category">{{auth()->user()->email}}</p>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="button-container">
            <a href="{{ route('frontend.users.profile', auth()->user()->username) }}" class="btn btn-primary btn-round btn-lg">Edit Profile</a>
            <a href="#" class="btn btn-default btn-round btn-lg btn-icon" rel="tooltip" title="" data-original-title="Follow me on Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="btn btn-default btn-round btn-lg btn-icon" rel="tooltip" title="" data-original-title="Follow me on Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
        <h3 class="title">Change Password</h3>

        <div class="row mt-4 mb-4">
            <div class="col">
                {{ html()->form('PATCH', route('frontend.users.changePasswordUpdate', auth()->user()->username))->class('form-horizontal')->open() }}

                <div class="form-group row">
                    {{ html()->label(__('labels.backend.users.fields.password'))->class('col-md-3 form-control-label')->for('password') }}

                    <div class="col-md-9">
                        {{ html()->password('password')
                            ->class('form-control')
                            ->placeholder(__('labels.backend.users.fields.password'))
                            ->required() }}
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    {{ html()->label(__('labels.backend.users.fields.password_confirmation'))->class('col-md-3 form-control-label')->for('password_confirmation') }}

                    <div class="col-md-9">
                        {{ html()->password('password_confirmation')
                            ->class('form-control')
                            ->placeholder(__('labels.backend.users.fields.password_confirmation'))
                            ->required() }}
                    </div>
                </div><!--form-group-->

                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    {{ html()->button($text = "<i class='fas fa-save'></i>&nbsp;Save", $type = 'submit')->class('btn btn-success') }}

                                    <a href="{{ route("frontend.$module_name.profile", auth()->user()->username) }}" class="btn btn-warning" data-toggle="tooltip" title="{{__('labels.backend.cancel')}}"><i class="fas fa-reply"></i>&nbsp;Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ html()->closeModelForm() }}
            </div>
            <!--/.col-->
        </div>

    </div>
</div>

@endsection
