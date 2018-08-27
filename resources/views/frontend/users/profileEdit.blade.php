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
                <img src="{{asset('photos/avatars/'.auth()->user()->avatar)}}" alt="{{auth()->user()->name}}">
            </div>
            <h3 class="title">{{auth()->user()->name}}</h3>
            <p class="category">{{auth()->user()->email}}</p>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="button-container">
            <a href="{{ route('frontend.users.profileEdit') }}" class="btn btn-primary btn-round btn-lg">Edit Profile</a>
            <a href="#" class="btn btn-default btn-round btn-lg btn-icon" rel="tooltip" title="" data-original-title="Follow me on Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="btn btn-default btn-round btn-lg btn-icon" rel="tooltip" title="" data-original-title="Follow me on Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
        <h3 class="title">Edit Profile</h3>

        <div class="row mt-4 mb-4">
            <div class="col">
                {{ html()->modelForm($user, 'PATCH', route('frontend.users.profileUpdate'))->class('form-horizontal')->acceptsFiles()->open() }}

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.avatar'))->class('col-md-2 form-control-label')->for('name') }}

                        <div class="col-md-5">
                            <img src="{{ asset('photos/avatars/'.$user->avatar) }}" class="user-profile-image img-fluid img-thumbnail" style="max-height:200px; max-width:200px;" />
                        </div>
                        <div class="col-md-5">
                            <input id="file-multiple-input" name="avatar" multiple="" type="file">
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.name'))->class('col-md-2 form-control-label')->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.name'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.email'))->class('col-md-2 form-control-label')->for('email') }}

                        <div class="col-md-10">
                            {{ $user->email }}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.password'))->class('col-md-2 form-control-label')->for('password') }}

                        <div class="col-md-10">
                            <a href="{{ route('frontend.users.changePassword') }}" class="btn btn-outline-primary btn-sm">Change password</a>
                        </div>
                    </div><!--form-group-->

                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        {!! Form::button("<i class='fas fa-save'></i>&nbsp;Save", ['class' => 'btn btn-success', 'type'=>'submit']) !!}
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
