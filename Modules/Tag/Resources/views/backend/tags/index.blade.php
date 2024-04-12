@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section('breadcrumbs')
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item type="active"
            icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            <x-backend.section-header>
                <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small
                    class="text-muted">{{ __($module_action) }}</small>

                <x-slot name="toolbar">
                    @can('add_' . $module_name)
                        <x-backend.buttons.create title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}"
                            small="true" route='{{ route("backend.$module_name.create") }}' />
                    @endcan

                    @can('restore_' . $module_name)
                        <div class="btn-group">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" data-coreui-toggle="dropdown"
                                type="button" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href='{{ route("backend.$module_name.trashed") }}'>
                                        <i class="fas fa-eye-slash"></i> @lang('View trash')
                                    </a>
                                </li>
                                <!-- <li>
                                    <hr class="dropdown-divider">
                                </li> -->
                            </ul>
                        </div>
                    @endcan
                </x-slot>
            </x-backend.section-header>

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table-bordered table-hover table-responsive-sm table" id="datatable">
                            <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        @lang('tag::text.name')
                                    </th>
                                    <th>
                                        @lang('tag::text.slug')
                                    </th>
                                    <th>
                                        @lang('tag::text.updated_at')
                                    </th>
                                    <th>
                                        @lang('tag::text.created_by')
                                    </th>
                                    <th class="text-end">
                                        @lang('tag::text.action')
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($$module_name as $module_name_singular)
                                    <tr>
                                        <td>
                                            {{ $module_name_singular->id }}
                                        </td>
                                        <td>
                                            <a
                                                href="{{ url("admin/$module_name", $module_name_singular->id) }}">{{ $module_name_singular->name }}</a>
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
                                            <a class='btn btn-sm btn-primary mt-1' data-toggle="tooltip"
                                                href='{!! route("backend.$module_name.edit", $module_name_singular) !!}'
                                                title="Edit {{ ucwords(Str::singular($module_name)) }}"><i
                                                    class="fas fa-wrench"></i></a>
                                            <a class='btn btn-sm btn-success mt-1' data-toggle="tooltip"
                                                href='{!! route("backend.$module_name.show", $module_name_singular) !!}'
                                                title="Show {{ ucwords(Str::singular($module_name)) }}"><i
                                                    class="fas fa-tv"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
