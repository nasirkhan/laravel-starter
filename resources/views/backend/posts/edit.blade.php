@extends('backend.layouts.app')

@section('title')
{{ $module_action }} {{ $module_title }} | {{ app_name() }}
@stop

@section('page_heading')
<h1>
    <i class="{{ $module_icon }}"></i> {{ $module_title }}
    <small>{{ $module_action }}</small>
</h1>
@stop

@section('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li><a href='{!!route("backend.$module_name.index")!!}'><i class="{{ $module_icon }}"></i> {{ $module_title }}</a></li>
<li class="active"> {{ $module_action }}</li>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-5">
                <h4 class="card-title mb-0">
                    {{ $module_title }} <small class="text-muted">{{ $module_action }}</small>
                </h4>
                <div class="small text-muted">
                    {{ title_case($module_name) }} Management Dashboard
                </div>
            </div>
            <!--/.col-->
            <div class="col-7">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <a href="{{ route("backend.$module_name.show", $$module_name_singular->id) }}" class="btn btn-primary ml-1 btn-sm" data-toggle="tooltip" title="Create New"><i class="fa fa-desktop"></i> Show</a>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <hr>

        <div class="row mt-4">
            <div class="col">
                {!! Form::model($$module_name_singular, ['method' => 'PATCH', 'url' => ["admin/$module_name", $$module_name_singular->id], 'files' => true, 'class' => 'form']) !!}

                {!! csrf_field() !!}

                @include ("backend.$module_name.form")

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            {!! Form::button("<i class='fa fa-save'></i> Save", ['class' => 'btn btn-primary', 'type'=>'submit']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}

                    <div class="col-8">
                        <div class="pull-right">
                            {!! Form::model($$module_name_singular, ['method' => 'delete', 'url' => ["admin/$module_name", $$module_name_singular->id]]) !!}
                            <div class="form-group">
                                {!! Form::button("<i class='fa fa-trash'></i>", ['class' => 'btn btn-danger', 'type'=>'submit']) !!}

                                <a class="btn btn-warning" href="{{ route("backend.$module_name.index") }}">
                                    <i class="fa fa-reply"></i> Cancel
                                </a>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    Updated: {{$$module_name_singular->updated_at->diffForHumans()}},
                    Created at: {{$$module_name_singular->created_at->toCookieString()}}
                </small>
            </div>
        </div>
    </div>
</div>

@stop
