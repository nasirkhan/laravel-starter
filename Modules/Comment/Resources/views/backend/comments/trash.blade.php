@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot>
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />
                <a href='{{ route("backend.$module_name.index") }}' class="btn btn-secondary" data-toggle="tooltip" title="{{ ucwords($module_name) }} List"><i class="fas fa-list"></i> List</a>
            </x-slot>
        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col">
                <table id="datatable" class="table table-bordered table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Page
                            </th>
                            <th>
                                Updated At
                            </th>
                            <th>
                                Created By
                            </th>
                            <th class="text-end">
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
                                <a href="{{ url("admin/$module_name", $module_name_singular->id) }}">{{ $module_name_singular->name }}</a>
                            </td>
                            <td>
                                {{ $module_name_singular->slug }}
                            </td>
                            <td>
                                {{ $module_name_singular->updated_at->diffForHumans() }}
                            </td>
                            <td>
                                {{ $module_name_singular->created_by }}
                            </td>
                            <td class="text-end">
                                <a href="{{route("backend.$module_name.restore", $module_name_singular)}}" class="btn btn-warning btn-sm" data-method="PATCH" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.restore')}}"><i class='fas fa-undo'></i> {{__('labels.backend.restore')}}</a>
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
                    Total {{ $$module_name->total() }} {{ ucwords($module_name) }}
                </div>
            </div>
            <div class="col-5">
                <div class="float-end">
                    {!! $$module_name->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection