@extends('backend.layouts.app')

@section('title') {{ $module_action }} {{ $module_title }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}' >
        {{ $module_title }}
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">{{ $module_action }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ $module_title }} <small class="text-muted">{{ __($module_action) }}</small>
                </h4>
                <div class="small text-muted">
                    @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="float-right">
                    <a href="{{ route("backend.$module_name.create") }}" class="btn btn-success m-1 btn-sm" data-toggle="tooltip" title="Create New"><i class="fas fa-plus-circle"></i> @lang("Create new :module_name", ['module_name'=>Str::title($module_name)])</a>
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
                                @lang('File')
                            </th>
                            <th>
                                @lang('Size')
                            </th>
                            <th>
                                @lang('Date')
                            </th>
                            <th>
                                @lang('Age')
                            </th>
                            <th class="text-right">
                                @lang('Action')
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
                                <a href="{{ route("backend.$module_name.download", $backup['file_name']) }}" class="btn btn-primary m-1 btn-sm" data-toggle="tooltip" title="@lang('Download File')"><i class="fas fa-cloud-download-alt"></i>&nbsp;@lang('Download')</a>

                                <a href="{{ route("backend.$module_name.delete", $backup['file_name']) }}" class="btn btn-danger m-1 btn-sm" data-toggle="tooltip" title="@lang('Delete File')"><i class="fas fa-trash"></i>&nbsp;@lang('Delete')</a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="text-center">
                        <h4>@lang('There are no backups')</h4>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
