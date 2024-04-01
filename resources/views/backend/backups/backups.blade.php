@extends('backend.layouts.app')

@section('title')
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section('content')
    <x-backend.page-wrapper>
        <x-slot name="breadcrumbs">
            <x-backend.breadcrumbs>
                <x-backend.breadcrumb-item route='{{ route("backend.$module_name.index") }}' icon='{{ $module_icon }}'>
                    {{ __($module_title) }}
                </x-backend.breadcrumb-item>
                <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
            </x-backend.breadcrumbs>
        </x-slot>

        <x-slot name="title">
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }}
        </x-slot>

        <x-slot name="toolbar">
            @can('add_' . $module_name)
                <x-backend.buttons.create title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}"
                    route='{{ route("backend.$module_name.create") }}' />
            @endcan
        </x-slot>
        <div class="row row-cards">
            <div class="col">

                @if (count($backups))
                    <div class="table-responsive">
                        <table class="table-bordered table-hover table" id="datatable">
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
                                    <th class="text-end">
                                        @lang('Action')
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($backups as $key => $backup)
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
                                        <td class="text-end">
                                            <a class="btn btn-primary btn-sm m-1" data-bs-toggle="tooltip"
                                                href="{{ route("backend.$module_name.download", $backup['file_name']) }}"
                                                title="@lang('Download File')"><i
                                                    class="fas fa-cloud-download-alt"></i>&nbsp;@lang('Download')</a>

                                            <a class="btn btn-danger btn-sm m-1" data-bs-toggle="tooltip"
                                                href="{{ route("backend.$module_name.delete", $backup['file_name']) }}"
                                                title="@lang('Delete File')"><i
                                                    class="fas fa-trash"></i>&nbsp;@lang('Delete')</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <p>@lang('No backup has been created yet!')</p>
                                <x-backend.buttons.create title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}"
                    route='{{ route("backend.$module_name.create") }}'>@lang('Create a backup')</x-backend.buttons.create>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </x-backend.page-wrapper>
@endsection
