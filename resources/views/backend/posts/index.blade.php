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
<li class="active"><i class="{{ $module_icon }}"></i> {{ $module_title }}</li>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-5">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ $module_title }} <small class="text-muted">{{ $module_action }}</small>
                </h4>
                <div class="small text-muted">
                    {{ title_case($module_name) }} Management Dashboard
                </div>
            </div>
            <!--/.col-->
            <div class="col-7">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <a href="{{ route("backend.$module_name.create") }}" class="btn btn-success btn-sm ml-1" data-toggle="tooltip" title="Create New"><i class="fa fa-plus-circle"></i> Create</a>
                    &nbsp;
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle btn-sm" data-toggle="tooltip" title="Options" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ route("backend.$module_name.trashed") }}">
                                <i class="fa fa-eye-slash"></i> View trash
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col">
                <table id="datatable" class="table table-bordered table-hover table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Image
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Category
                            </th>
                            <th>
                                Type
                            </th>
                            <th>
                                Updated At
                            </th>
                            <th>
                                Featured
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
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
                                <img src="{{ $module_name_singular->featured_image }}" alt="" class=" img-thumbnail" style="height:80px;">
                            </td>
                            <td>
                                <a href="{{ url("admin/$module_name", $module_name_singular->id) }}">{{ $module_name_singular->title }}</a>
                                <br />
                                {{ $module_name_singular->slug }}
                            </td>
                            <td>
                                {{ $module_name_singular->category }}
                            </td>
                            <td>
                                @if ($module_name_singular->type == 'News')
                                <div class="p-2 bg-primary text-white text-center">{{ $module_name_singular->type }}</div>
                                @elseif ($module_name_singular->type == 'Achievement')
                                <div class="p-2 bg-success text-white text-center">{{ $module_name_singular->type }}</div>
                                @elseif ($module_name_singular->type == 'Achievement')
                                <div class="p-2 bg-info text-white text-center">{{ $module_name_singular->type }}</div>
                                @else
                                <div class="p-2 bg-dark text-white text-center">{{ $module_name_singular->type }}</div>
                                @endif
                            </td>
                            <td>
                                {{ $module_name_singular->updated_at->diffForHumans() }}
                            </td>
                            <td>
                                @if ($module_name_singular->is_featured == 'Yes')
                                <div class="p-2 bg-dark text-white text-center">{{ $module_name_singular->is_featured }}</div>
                                @else
                                <!-- <div class="p-2 bg-dark text-white text-center">{{ $module_name_singular->is_featured }}</div> -->
                                @endif
                            </td>
                            <td>
                                {!! show_post_status($module_name_singular, 'badge') !!}
                            </td>
                            <td>
                                <a href='{!!route("backend.$module_name.edit", $module_name_singular->id)!!}' class='btn btn-sm btn-primary' data-toggle="tooltip" title="Edit {{ title_case($module_name) }}"><i class="fa fa-wrench"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    Total {!! $$module_name->total() !!} {{$module_name}}
                </div>
            </div>
            <div class="col-5">
                <div class="float-right">
                    {!! $$module_name->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@stop
