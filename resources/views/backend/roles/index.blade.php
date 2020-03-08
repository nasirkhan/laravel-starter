@extends ('backend.layouts.app')

@section('title')
{{ $module_action }} {{ $module_title }} | {{ app_name() }}
@stop

@section('breadcrumbs')
@backendBreadcrumbs
    @slot('level_1')
        <li class="breadcrumb-item active"><i class="{{ $module_icon }}"></i> {{ $module_title }}</li>
    @endslot
@endbackendBreadcrumbs
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ $module_title }} <small class="text-muted">Data Table {{ $module_action }}</small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.roles.index.sub-title') }}
                </div>
            </div>

            <div class="col-4">
                <div class="float-right">
                    <a href="{{ route("backend.$module_name.create") }}" class="btn btn-success m-1 btn-sm" data-toggle="tooltip" title="Create New"><i class="fas fa-plus-circle"></i> Create</a>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col">
                <table class="table table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>{{ __("labels.backend.$module_name.fields.name") }}</th>
                            <th>{{ __("labels.backend.$module_name.fields.permissions") }}</th>
                            <th class="text-right">{{ __("labels.backend.action") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($$module_name as $module_name_singular)
                        <tr>
                            <td>
                                <strong>
                                    {{ $module_name_singular->name }}
                                </strong>
                            </td>
                            <td>
                                @foreach ($module_name_singular->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                                @endforeach
                            </td>
                            <td class="text-right">
                                <a href="{{route("backend.$module_name.show", $module_name_singular)}}" class="btn btn-success btn-sm mt-1" data-toggle="tooltip" title="{{__('labels.backend.show')}}"><i class="fas fa-desktop"></i></a>
                                <a href="{{route("backend.$module_name.edit", $module_name_singular)}}" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip" title="{{__('labels.backend.edit')}}"><i class="fas fa-pencil-alt"></i></a>
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
                    {!! $$module_name->total() !!} {{ __('labels.backend.total') }}
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

@endsection
