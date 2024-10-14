@props([
    "data" => "",
    "module_name",
    "module_path",
    "module_title" => "",
    "module_icon" => "",
    "module_action" => "Trash",
])
<div class="card">
    @if ($slot != "")
        <div class="card-body">
            {{ $slot }}
        </div>
    @else
        <div class="card-body">
            <x-backend.section-header>
                <i class="{{ $module_icon }}"></i>
                {{ __($module_title) }}
                <small class="text-muted">{{ __($module_action) }}</small>

                <x-slot name="toolbar">
                    <x-backend.buttons.return-back :small="true" />
                    <a
                        class="btn btn-secondary btn-sm"
                        data-toggle="tooltip"
                        href="{{ route("backend.$module_name.index") }}"
                        title="{{ __(ucwords($module_name)) }} @lang("List")"
                    >
                        <i class="fas fa-list"></i>
                        @lang("List")
                    </a>
                </x-slot>
            </x-backend.section-header>

            <div class="row mt-4">
                <div class="col-12">
                    @if (count($data) > 0)
                        <div class="table-responsive">
                            <table class="table-bordered table-hover table" id="datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Updated At</th>
                                        <th>Created By</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($data as $row)
                                        <tr>
                                            <td>
                                                {{ $row->id }}
                                            </td>
                                            <td>
                                                <strong>
                                                    {{ $row->name }}
                                                </strong>
                                            </td>
                                            <td>
                                                {{ $row->updated_at->isoFormat("llll") }}
                                            </td>
                                            <td>
                                                {{ $row->created_by }}
                                            </td>
                                            <td class="text-end">
                                                <a
                                                    class="btn btn-warning btn-sm"
                                                    data-method="PATCH"
                                                    data-token="{{ csrf_token() }}"
                                                    data-toggle="tooltip"
                                                    href="{{ route("backend.$module_name.restore", $row) }}"
                                                    title="{{ __("labels.backend.restore") }}"
                                                >
                                                    <i class="fa-solid fa-rotate-left"></i>
                                                    &nbsp;{{ __("labels.backend.restore") }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center">
                            <p>
                                @lang("No record found in trash!")
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="card-footer">
        @if (! empty($data))
            <div class="row">
                <div class="col-12 col-sm-7">
                    <div class="float-start">
                        <small>
                            @lang("Total")
                            {{ $data->total() }} {{ ucwords($module_name) }}
                        </small>
                    </div>
                </div>
                <div class="col-12 col-sm-5">
                    <div class="float-end">
                        {!! $data->render() !!}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
