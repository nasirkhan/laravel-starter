@extends('backend.layouts.app')

@section('title')
{{ $module_action }} {{ $module_title }} | {{ app_name() }}
@stop

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{!!route('backend.dashboard')!!}"><i class="icon-speedometer"></i> Dashboard</a></li>
<li class="breadcrumb-item active"><i class="{{ $module_icon }}"></i> {{ $module_title }}</li>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ $module_title }} <small class="text-muted">{{ $module_action }}</small>
                </h4>
                <div class="small text-muted">
                    {{ Str::title($module_name) }} Management Dashboard
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="float-right">
                    <a href="{{ route("backend.$module_name.create") }}" class="btn btn-success m-1 btn-sm" data-toggle="tooltip" title="Create New"><i class="fas fa-plus-circle"></i> Create New Backup</a>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col">

                @if (count($backups))
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                File
                            </th>
                            <th>
                                Size
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                Age
                            </th>
                            <th class="text-right">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($backups as $key => $backup)
                        <tr>
                            <td>
                                {{ ++$key }}
                            </td>
                            <td>
                                {{ $backup['file_name'] }}
                            </td>
                            <td>
                                {{ $backup['file_size'] }}
                            </td>
                            <td>
                                {{ $backup['date_created'] }}
                            </td>
                            <td>
                                {{ $backup['date_ago'] }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route("backend.$module_name.download", $backup['file_name']) }}" class="btn btn-primary m-1 btn-sm" data-toggle="tooltip" title="Download Backup File"><i class="fas fa-cloud-download-alt"></i> Download</a>

                                <a href="{{ route("backend.$module_name.delete", $backup['file_name']) }}" class="btn btn-danger m-1 btn-sm" data-toggle="tooltip" title="Delete Backup File"><i class="fas fa-trash"></i> Delete</a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="text-center">
                        <h4>There are no backups</h4>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@stop
