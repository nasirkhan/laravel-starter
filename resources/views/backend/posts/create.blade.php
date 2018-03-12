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
                    <a href="{{ route("backend.$module_name.index") }}" class="btn btn-primary ml-1 btn-sm" data-toggle="tooltip" title="List"><i class="fa fa-list"></i> List</a>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <hr>

        <div class="row mt-4">
            <div class="col">
                {!! Form::open(['url' => "admin/$module_name", 'files' => true, 'class' => 'form']) !!}

                {!! csrf_field() !!}

                @include ("backend.$module_name.form")

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            {!! Form::button("<i class='fa fa-plus-circle'></i> " . ucfirst($module_action) . "", ['class' => 'btn btn-primary', 'type'=>'submit']) !!}
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="pull-right">
                            <div class="form-group">
                                <button type="button" class="btn btn-warning" onclick="history.back(-1)"><i class="fa fa-reply"></i> Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col">

            </div>
        </div>
    </div>
</div>


@stop
