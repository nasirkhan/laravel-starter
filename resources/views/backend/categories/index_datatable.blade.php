@extends('backend.layouts.master')

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
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $module_title }} {{ $module_action }}</h3>
        <div class="pull-right">
            <a href='{!! route("backend.$module_name.create") !!}' class='btn btn-success'><i class='fa fa-plus'></i> Create</a>

            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-cog"></i>  Options <span class="caret"></span>
                </button>

                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{{ route("backend.$module_name.trashed") }}">
                            <i class="fa fa-eye-slash"></i> View trash
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div><!-- /.box-header -->
    <div class="box-body">

        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
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
                                    Code
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
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div><!-- /.box-body -->
</div><!--box box-success-->
@stop

@section ('after-styles-end')

<!--<link rel="stylesheet" href="{{ asset('vendor/dataTables/css/jquery.dataTables.min.css') }}">-->
<link rel="stylesheet" href="{{ asset('vendor/dataTables/css/dataTables.bootstrap.min.css') }}">

@stop

@section ('after-scripts-end')
<script type="text/javascript" src="{{ asset('vendor/dataTables/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/dataTables/js/dataTables.bootstrap.min.js') }}"></script>

<script type="text/javascript">

    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        ajax: '{{ route("backend.$module_name.index-data") }}',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'created_by', name: 'created_by'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
</script>
@stop
