@extends ('backend.layouts.app')

<?php
$module_name_singular = str_singular($module_name);
?>

@section ('title', __("labels.backend.$module_name.".strtolower($module_action).".title") . " - " . __("labels.backend.$module_name.".strtolower($module_action).".action"))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{$module_icon}}"></i> Profile
                    <small class="text-muted">{{ __('labels.backend.users.edit.action') }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.edit.sub-title') }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button onclick="window.history.back();"class="btn btn-warning ml-1" data-toggle="tooltip" title="Return Back"><i class="fas fa-reply"></i></button>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
        <hr>
        <div class="row mt-4 mb-4">
            <div class="col">
                {{ html()->modelForm($user, 'PATCH', route('backend.users.profileUpdate'))->class('form-horizontal')->attributes(['enctype'=>"multipart/form-data"])->open() }}

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
                            {{ html()->email('email')
                                ->class('form-control')
                                ->placeholder(__('labels.backend.users.fields.email'))
                                ->attribute('maxlength', 191)
                                ->required() }}
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
                    
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        {!! Form::button("<i class='fas fa-save'></i> Save", ['class' => 'btn btn-success', 'type'=>'submit']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {{ html()->closeModelForm() }}
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    Updated: {{$user->updated_at->diffForHumans()}},
                    Created at: {{$user->created_at->toCookieString()}}
                </small>
            </div>
        </div>
    </div>
</div>

@endsection
