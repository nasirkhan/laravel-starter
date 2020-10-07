@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}}'s Profile @endsection

@section('content')

<section class="section-header bg-primary text-white pb-7 pb-lg-11">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-2 mb-4">
                    {{$$module_name_singular->name}}
                    
                    @auth
                    @if(auth()->user()->id == $$module_name_singular->id)
                    <small>
                        <a href="{{ route('frontend.users.profile', $$module_name_singular->id) }}" class="btn btn-secondary btn-sm">Show</a>
                    </small>
                    @endif
                    @endauth
                </h1>
                <p class="lead">
                    Username:{{$$module_name_singular->username}}
                </p>
                @if ($$module_name_singular->email_verified_at == null)
                <p class="lead">
                    <a href="{{route('frontend.users.emailConfirmationResend', $$module_name_singular->id)}}">Confirm Email</a>
                </p>
                @endif

                @include('frontend.includes.messages')
            </div>
        </div>
    </div>
    <div class="pattern bottom"></div>
</section>
<section class="section section-lg line-bottom-light">
    <div class="container mt-n7 mt-lg-n12 z-2">
        <div class="row">
            <div class="col-lg-12 mb-5">
                <div class="card bg-white border-light shadow-soft flex-md-row no-gutters p-4">
                    <div class="card-body d-flex flex-column justify-content-between col-auto py-4 p-lg-5">

                        {{ html()->modelForm($userprofile, 'PATCH', route('frontend.users.profileUpdate', $$module_name_singular->id))->class('form-horizontal')->acceptsFiles()->open() }}

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
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'first_name';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = $field_lable;
                                    $required = "required";
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'last_name';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = $field_lable;
                                    $required = "required";
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'email';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = $field_lable;
                                    $required = "";
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->email($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"])->disabled() }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'mobile';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = $field_lable;
                                    $required = "";
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'date_of_birth';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = $field_lable;
                                    $value = ($userprofile->$field_name != "")? $userprofile->$field_name->toDateString() : "";
                                    $required = "required";
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->value($value)->attributes(["$required", 'type'=>'date']) }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'gender';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = "-- Select an option --";
                                    $required = "";
                                    $select_options = [
                                        'Female' => 'Female',
                                        'Male' => 'Male',
                                        'Other' => 'Other',
                                    ];
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control ')->attributes(["$required"]) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'address';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = $field_lable;
                                    $required = "";
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'bio';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = $field_lable;
                                    $required = "";
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-3">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'url_website';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = $field_lable;
                                    $required = "";
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'url_facebook';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = $field_lable;
                                    $required = "";
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'url_twitter';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = $field_lable;
                                    $required = "";
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="form-group">
                                    <?php
                                    $field_name = 'url_linkedin';
                                    $field_lable = label_case($field_name);
                                    $field_placeholder = $field_lable;
                                    $required = "";
                                    ?>
                                    {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            {{ html()->label(__('labels.backend.users.fields.password'))->class('col-md-2 form-control-label')->for('password') }}

                            <div class="col-md-10">
                                <a href="{{ route('frontend.users.changePassword', $$module_name_singular->id) }}" class="btn btn-outline-primary btn-sm"><i class="now-ui-icons objects_key-25"></i>&nbsp;Change password</a>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col">
                                <div class="form-group">
                                    {!! Form::button("<i class='fas fa-save'></i>&nbsp;Save", ['class' => 'btn btn-success', 'type'=>'submit']) !!}
                                </div>
                            </div>
                        </div>

                    {{ html()->closeModelForm() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
