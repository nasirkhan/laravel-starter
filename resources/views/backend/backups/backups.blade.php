@extends("backend.layouts.app")

@section("title")
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item route='{{ route("backend.$module_name.index") }}' icon="{{ $module_icon }}">
            {{ __($module_title) }}
        </x-backend.breadcrumb-item>
        <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section("content")
    <div class="card">
        <div class="card-body">
            <x-backend.section-header>
                <i class="{{ $module_icon }}"></i>
                {{ __($module_title) }}
                <small class="text-muted">{{ __($module_action) }}</small>

                <x-slot name="toolbar">
                    <x-backend.buttons.return-back :small="true" />
                    @can("add_" . $module_name)
                        <x-backend.buttons.create
                            route='{{ route("backend.$module_name.create") }}'
                            title="{{ __(ucwords(Str::singular($module_name))) }} {{ __('Create') }}"
                            :small="true"
                        />
                    @endcan
                </x-slot>
            </x-backend.section-header>

            <div class="row mt-4">
                <div class="col">
                    @if (count($backups))
                        <div class="table-responsive">
                            <table id="datatable" class="table-bordered table-hover table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>
                                            @lang("File")
                                        </th>
                                        <th>
                                            @lang("Size")
                                        </th>
                                        <th>
                                            @lang("Date")
                                        </th>
                                        <th>
                                            @lang("Age")
                                        </th>
                                        <th class="text-end">
                                            @lang("Action")
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
                                                {{ $backup["file_name"] }}
                                            </td>
                                            <td>
                                                {{ $backup["file_size"] }}
                                            </td>
                                            <td>
                                                {{ $backup["date_created"] }}
                                            </td>
                                            <td>
                                                {{ $backup["date_ago"] }}
                                            </td>
                                            <td class="text-end">
                                                <a
                                                    href="{{ route("backend.$module_name.download", $backup["file_name"]) }}"
                                                    class="btn btn-primary btn-sm m-1"
                                                    data-toggle="tooltip"
                                                    title="@lang("Download File")"
                                                >
                                                    <i class="fas fa-cloud-download-alt"></i>
                                                    &nbsp;
                                                    @lang("Download")
                                                </a>

                                                <a
                                                    href="{{ route("backend.$module_name.delete", $backup["file_name"]) }}"
                                                    class="btn btn-danger btn-sm m-1"
                                                    data-toggle="tooltip"
                                                    title="@lang("Delete File")"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                    &nbsp;
                                                    @lang("Delete")
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <p>@lang("No backup has been created yet!")</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
