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
            <x-backend.section-header>
                <i class="{{ $module_icon }}"></i>
                {{ __($module_title) }}
                <small class="text-muted">{{ __($module_action) }}</small>

                <x-slot name="toolbar">
                    <x-backend.buttons.create
                        title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}"
                        route='{{ route("backend.$module_name.create") }}'
                        :small="true"
                    />
                </x-slot>
            </x-backend.section-header>

            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table-hover table-bordered table">
                            <thead>
                                <tr>
                                    <th>{{ __("labels.backend.$module_name.fields.name") }}</th>
                                    <th>{{ __("labels.backend.$module_name.fields.permissions") }}</th>
                                    <th class="text-end">{{ __("labels.backend.action") }}</th>
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
                                            <ul>
                                                @foreach ($module_name_singular->permissions as $permission)
                                                    <li>{{ $permission->name }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="text-end">
                                            @can("edit_" . $module_name)
                                                <x-backend.buttons.edit
                                                    title="{{ __('Edit') }} {{ ucwords(Str::singular($module_name)) }}"
                                                    route='{!! route("backend.$module_name.edit", $module_name_singular) !!}'
                                                    small="true"
                                                />
                                            @endcan

                                            <x-backend.buttons.show
                                                title="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
                                                route='{!! route("backend.$module_name.show", $module_name_singular) !!}'
                                                small="true"
                                            />
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
                <div class="col-12 col-sm-7">
                    <div class="float-left">{!! $$module_name->total() !!} {{ __("labels.backend.total") }}</div>
                </div>
                <div class="col-12 col-sm-5">
                    <div class="float-end">
                        {{ $$module_name->links("pagination::bootstrap-5") }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
