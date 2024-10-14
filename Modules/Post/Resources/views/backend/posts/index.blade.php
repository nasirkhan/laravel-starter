@extends("backend.layouts.app")

@section("title")
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item type="active" icon="{{ $module_icon }}">
            {{ __($module_title) }}
        </x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section("content")
    <div class="card">
        <div class="card-body">
            <x-backend.section-header
                :module_name="$module_name"
                :module_title="$module_title"
                :module_icon="$module_icon"
                :module_action="$module_action"
            />

            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table-bordered table-hover table-responsive-sm table" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>
                                        @lang("post::text.name")
                                    </th>
                                    <th>
                                        @lang("post::text.slug")
                                    </th>
                                    <th>
                                        @lang("post::text.updated_at")
                                    </th>
                                    <th>
                                        @lang("post::text.created_by")
                                    </th>
                                    <th class="text-end">
                                        @lang("post::text.action")
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
                                            <a href="{{ url("admin/$module_name", $module_name_singular->id) }}">
                                                {{ $module_name_singular->name }}
                                            </a>
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
                                            <a
                                                class="btn btn-sm btn-primary mt-1"
                                                data-toggle="tooltip"
                                                href="{!! route("backend.$module_name.edit", $module_name_singular) !!}"
                                                title="Edit {{ ucwords(Str::singular($module_name)) }}"
                                            >
                                                <i class="fas fa-wrench"></i>
                                            </a>
                                            <a
                                                class="btn btn-sm btn-success mt-1"
                                                data-toggle="tooltip"
                                                href="{!! route("backend.$module_name.show", $module_name_singular) !!}"
                                                title="Show {{ ucwords(Str::singular($module_name)) }}"
                                            >
                                                <i class="fas fa-tv"></i>
                                            </a>
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
                    <div class="float-left">Total {{ $$module_name->total() }} {{ ucwords($module_name) }}</div>
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
