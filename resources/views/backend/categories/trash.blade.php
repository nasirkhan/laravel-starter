@extends ('backend.layouts.master')

<?php
$module_name_singular = str_singular($module_name);
?>

@section ('title', ucfirst($module_name) . ' ' . ucfirst($module_action))

@section('page_heading')
<h1>
    <i class="{{ $module_icon }}"></i> {{ ucfirst($module_name) }}
    <small>
        {{ ucfirst($module_action) }}
    </small>
</h1>
@stop

@section('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
<li class="active"><i class="{{ $module_icon }}"></i> {{ $module_title }}</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ ucfirst($module_title) }} {{ ucfirst($module_action) }}</h3>

        <div class="box-tools pull-right">
            <a href="{{ route("backend.$module_name.index") }}" class="btn btn-primary pull-right btn-sm">
                <i class="fa fa-th-list"></i> List
            </a>
        </div>
    </div>
    <div class="box-body">
        <table id="datatable" class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Description
                    </th>
                    <th>
                        Updated At
                    </th>
                    <th>
                        Created By
                    </th>
                    <th>
                        Status
                    </th>
                    <th class="text-right">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach($$module_name as $module_name_singular)
                <tr>
                    <td>
                        {{ $module_name_singular->id }}
                    </td>
                    <td>
                        <strong>
                            {{ $module_name_singular->name }}
                        </strong>
                    </td>
                    <td>
                        {{ $module_name_singular->description }}
                    </td>
                    <td>
                        {{ $module_name_singular->updated_at }}
                    </td>
                    <td>
                        {{ $module_name_singular->user->name }}
                    </td>
                    <td>
                        {{ $module_name_singular->status }}
                    </td>
                    <td class="text-right">

                        {!! Form::open(["url" => "admin/$module_name/trashed/$module_name_singular->id"]) !!}

                        <div class="form-group">
                            {!! Form::button("<i class='fa fa-undo'></i> Restore", ['class' => 'btn btn-danger ', 'type'=>'submit']) !!}
                        </div>

                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {!! $$module_name->render() !!}

    </div>
</div>

@stop
@section ('after-scripts-end')

@stop
