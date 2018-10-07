@extends('frontend.layouts.app')

@section('title')
{{$$module_name_singular->name}}'s Profile  | {{ app_name() }}
@stop


@section('content')
<div class="page-header page-header-small clear-filter" filter-color="orange">
    <div class="page-header-image" data-parallax="true" style="background-image:url('{{asset('img/cover-01.jpg')}}');">
    </div>
    <div class="container">
        <div class="photo-container">
            <img src="{{asset($user->avatar)}}" alt="{{$$module_name_singular->name}}">
        </div>
        <h3 class="title">{{$$module_name_singular->name}}</h3>
        <p class="category">
            @if ($$module_name_singular->confirmed_at == null)
            <a href="{{route('frontend.users.emailConfirmationResend', $$module_name_singular->id)}}">Confirm Email</a>
            @endif
        </p>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="button-container">
            <a href="{{ route('frontend.users.profile', $$module_name_singular->id) }}" class="btn btn-primary btn-round btn-lg">Show Profile</a>
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
                {{ html()->modelForm($user, 'PATCH', route('frontend.users.profileUpdate', $$module_name_singular->id))->class('form-horizontal')->acceptsFiles()->open() }}

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.avatar'))->class('col-md-2 form-control-label')->for('name') }}

                        <div class="col-md-5">
                            <img src="{{asset($user->avatar)}}" class="user-profile-image img-fluid img-thumbnail" style="max-height:200px; max-width:200px;" />
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="file-multiple-input">Click here to update photo</label>
                                <input id="file-multiple-input" name="avatar" multiple="" type="file" class="form-control-file">
                            </div>
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
                        {{ html()->label(__('labels.backend.users.fields.mobile'))->class('col-md-2 form-control-label')->for('mobile') }}

                        <div class="col-md-10">
                            {{ html()->text('mobile')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.mobile'))
                                ->attribute('maxlength', 191)
                                ->required() }}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.gender'))->class('col-md-2 form-control-label')->for('gender') }}

                        <div class="col-md-10">
                            {{ html()->text('gender')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.gender'))
                                ->attribute('maxlength', 191) }}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.date_of_birth'))->class('col-md-2 form-control-label')->for('date_of_birth') }}

                        <div class="col-md-10">
                            {{ html()->text('date_of_birth')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.date_of_birth'))
                                ->attribute('maxlength', 191) }}
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.users.fields.password'))->class('col-md-2 form-control-label')->for('password') }}

                        <div class="col-md-10">
                            <a href="{{ route('frontend.users.changePassword', $$module_name_singular->id) }}" class="btn btn-outline-primary btn-sm">Change password</a>
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
