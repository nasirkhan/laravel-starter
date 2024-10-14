@props([
    "data" => "",
    "module_name",
    "module_path",
    "module_title" => "",
    "module_icon" => "",
    "module_action" => "",
])
<div class="card">
    @if ($slot != "")
        <div class="card-body">
            {{ $slot }}
        </div>
    @else
        <div class="card-body">
            <x-backend.section-header
                :data="$data"
                :module_name="$module_name"
                :module_title="$module_title"
                :module_icon="$module_icon"
                :module_action="$module_action"
            />

            <div class="row mt-4">
                <div class="col">
                    {{ html()->modelForm($data, "PATCH", route("backend.$module_name.update", $data))->acceptsFiles()->open() }}

                    @include("$module_path.$module_name.form")

                    <div class="row">
                        <div class="col-4 mt-4">
                            <x-backend.buttons.save />
                        </div>

                        <div class="col-8 mt-4">
                            <div class="float-end">
                                @can("delete_" . $module_name)
                                    <a
                                        href="{{ route("backend.$module_name.destroy", $data) }}"
                                        class="btn btn-danger"
                                        data-method="DELETE"
                                        data-token="{{ csrf_token() }}"
                                        data-toggle="tooltip"
                                        title="{{ __("Delete") }}"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                @endcan

                                <x-backend.buttons.cancel />
                            </div>
                        </div>
                    </div>

                    {{ html()->closeModelForm() }}
                </div>
            </div>
        </div>
    @endif

    <div class="card-footer">
        <div class="row">
            <div class="col">
                @if ($data != "")
                    <small class="text-muted float-end text-end">
                        @lang("Updated at")
                        : {{ $data->updated_at->diffForHumans() }},
                        <br class="d-block d-sm-none" />
                        @lang("Created at")
                        : {{ $data->created_at->isoFormat("LLLL") }}
                    </small>
                @endif
            </div>
        </div>
    </div>
</div>
