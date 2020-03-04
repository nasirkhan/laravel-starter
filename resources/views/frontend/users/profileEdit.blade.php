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
        <h3 class="title">{{$$module_name_singular->name}} <br>Username:{{$$module_name_singular->username}}</h3>
        <p class="category">
            @if ($$module_name_singular->email_verified_at == null)
            <a href="{{route('frontend.users.emailConfirmationResend', $$module_name_singular->id)}}">Confirm Email</a>
            @endif
        </p>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="button-container">
            <a href="{{ route('frontend.users.profile', $$module_name_singular->username) }}" class="btn btn-primary btn-round btn-lg">View Profile</a>
            <!-- <a href="#" class="btn btn-default btn-round btn-lg btn-icon" rel="tooltip" title="" data-original-title="Follow me on Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="btn btn-default btn-round btn-lg btn-icon" rel="tooltip" title="" data-original-title="Follow me on Instagram">
                <i class="fab fa-instagram"></i>
            </a> -->
        </div>
        <h3 class="title">Edit Profile</h3>

        <div class="row mt-4 mb-4">
            <div class="col">
                {{ html()->modelForm($userprofile, 'PATCH', route('frontend.users.profileUpdate', $$module_name_singular->username))->class('form-horizontal')->acceptsFiles()->open() }}

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
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <?php
                                $field_name = 'father_name';
                                $field_lable = label_case($field_name);
                                $field_placeholder = $field_lable;
                                $required = "";
                                ?>
                                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <?php
                                $field_name = 'mother_name';
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php
                                $field_name = 'date_of_birth';
                                $field_lable = label_case($field_name);
                                $field_placeholder = $field_lable;
                                $required = "";
                                ?>
                                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                <div class="input-group date datetime" id="{{$field_name}}" data-target-input="nearest">
                                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                                    <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
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
                                {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
                            </div>
                        </div>



                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <?php
                                $field_name = 'profile_privecy';
                                $field_lable = label_case($field_name);
                                $field_placeholder = "-- Select an option --";
                                $required = "";
                                $select_options = [
                                    'Public'=>'Public',
                                    'Private'=>'Private',
                                ];
                                ?>
                                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <?php
                                $field_name = 'institute_name';
                                $field_lable = label_case($field_name);
                                $field_placeholder = $field_lable;
                                $required = "required";
                                ?>
                                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <?php
                                $field_name = 'class';
                                $field_lable = label_case($field_name);
                                $field_placeholder = "-- Select an option --";
                                $required = "required";
                                $select_options = [
                                    'Class 3' => 'Class 3',
                                    'Class 4' => 'Class 4',
                                    'Class 5' => 'Class 5',
                                    'Class 6' => 'Class 6',
                                    'Class 7' => 'Class 7',
                                    'Class 8' => 'Class 8',
                                    'Class 9' => 'Class 9',
                                    'Class 10' => 'Class 10',
                                    'Class 11' => 'Class 11',
                                    'Class 12' => 'Class 12',
                                ];
                                ?>
                                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required", 'disabled']) }}
                            </div>
                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <?php
                                $field_name = 'institute_address';
                                $field_lable = label_case($field_name);
                                $field_placeholder = $field_lable;
                                $required = "required";
                                ?>
                                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
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
                        <div class="col-6">
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
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <?php
                                $field_name = 'url_1';
                                $field_lable = label_case($field_name);
                                $field_placeholder = $field_lable;
                                $required = "";
                                ?>
                                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <?php
                                $field_name = 'url_2';
                                $field_lable = label_case($field_name);
                                $field_placeholder = $field_lable;
                                $required = "";
                                ?>
                                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                                {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <?php
                                $field_name = 'url_3';
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
                            <a href="{{ route('frontend.users.changePassword', $$module_name_singular->username) }}" class="btn btn-outline-primary btn-sm">Change password</a>
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

@push('after-styles')

<!-- Select2 Bootstrap 4 Core UI -->
<link href="{{ asset('vendor/select2/select2-coreui-bootstrap4.min.css') }}" rel="stylesheet" />

<!-- Date Time Picker -->
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-4-datetime-picker/css/tempusdominus-bootstrap-4.min.css') }}" />

@endpush

@push ('after-scripts')
<!-- Select2 Bootstrap 4 Core UI -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.select2').select2({
        theme: "bootstrap",
        placeholder: "-- Select an option --",
        allowClear: true,
    });
});
</script>

<!-- Date Time Picker & Moment Js-->
<script type="text/javascript" src="{{ asset('vendor/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap-4-datetime-picker/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<script type="text/javascript">
$(function() {
    $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD',
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar-alt',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'far fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'fas fa-times'
        }
    });
});
</script>
@endpush
