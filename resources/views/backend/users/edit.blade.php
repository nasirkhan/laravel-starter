@extends ('backend.layouts.app')

<?php
$module_name_singular = str_singular($module_name);
?>

@section ('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.edit'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.users.edit.title') }}
                    <small class="text-muted">{{ __('labels.backend.users.edit.action') }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.edit.sub-title') }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-sm-7">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <button onclick="window.history.back();"class="btn btn-warning ml-1" data-toggle="tooltip" title="Return Back"><i class="fa fa-reply"></i></button>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
        <hr>
        <div class="row mt-4 mb-4">
            <div class="col">
                {!! Form::model($$module_name_singular, ['method' => 'PATCH', 'url' => ["admin/$module_name", $$module_name_singular->id], 'class' => 'form-horizontal']) !!}

                {!! csrf_field() !!}

                <div class="row form-group">
                    <div class="col-3">
                        <strong>
                            {!! Form::label('name', 'Name' , ['class' => 'control-label']) !!}
                        </strong>
                    </div>
                    <div class="col-9">
                        {!! Form::text('name', old('name') , ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-3">
                        <strong>
                            {!! Form::label('email', 'Email' , ['class' => 'control-label']) !!}
                        </strong>
                    </div>

                    <div class="col-9">
                        {!! Form::text('email', old('email') , ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-3">
                        <strong>
                            Ablities
                        </strong>
                    </div>

                    <div class="col-9">
                        {!! Form::select('roles_list[]', $roles, null, ['class' => 'form-control', 'multiple']) !!}
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <a href="{{route('backend.users.index')}}" class="btn btn-danger"><i class="fa fa-reply"></i> {{__('labels.buttons.general.cancel')}}</a>

                        <button type="submit" name="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> {{__('labels.buttons.general.save')}}</button>
                    </div>
                </div>


                {!! Form::close() !!}

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
