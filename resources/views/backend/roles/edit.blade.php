@extends("backend.layouts.app")

@section("title")
        {{ $$module_name_singular->name }} - {{ __($module_action) }} - {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-cube::backend-breadcrumbs>
        <x-cube::backend-breadcrumb-item route='{{ route("backend.$module_name.index") }}' icon="{{ $module_icon }}">
            {{ __($module_title) }}
        </x-cube::backend-breadcrumb-item>

        <x-cube::backend-breadcrumb-item type="active">{{ __($module_action) }}</x-cube::backend-breadcrumb-item>
    </x-cube::backend-breadcrumbs>
@endsection

@section("content")
    <div class="card">
        <div class="card-body">
            <x-cube::backend-section-header>
                <i class="{{ $module_icon }}"></i>
                {{ __($module_title) }}
                <small class="text-muted">{{ __($module_action) }}</small>

                <x-slot name="toolbar">
                    <x-cube::backend-button-return-back :small="true" />
                    <x-buttons.show
                        class="ms-1"
                        title="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
                        route='{!! route("backend.$module_name.show", $$module_name_singular) !!}'
                        :small="true"
                    />
                </x-slot>
            </x-cube::backend-section-header>

            <div class="row">
                <div class="col">
                    {{ html()->modelForm($$module_name_singular, "PATCH", route("backend.$module_name.update", $$module_name_singular->id))->class("form-horizontal")->open() }}

                    <div class="row mb-3">
                        <?php
                        $field_name = "name";
                        $field_lable = __("labels.backend.roles.fields.name");
                        $field_placeholder = $field_lable;
                        $required = "required";
                        ?>

                        <div class="col-12 col-sm-2">
                            <div class="form-group">
                                {{ html()->label($field_lable, $field_name)->class("form-label") }}
                                {!! field_required($required) !!}
                            </div>
                        </div>
                        <div class="col-12 col-sm-10">
                            <div class="form-group">
                                {{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <?php
                        $field_name = "name";
                        $field_lable = __("Abilities");
                        $field_placeholder = $field_lable;
                        $required = "";
                        ?>

                        <div class="col-12 col-sm-2">
                            <div class="form-group">
                                {{ html()->label($field_lable, $field_name)->class("form-label") }}
                                {!! field_required($required) !!}
                            </div>
                        </div>
                        <div class="col-12 col-sm-10">
                            <div class="form-group">
                                {{ __("Select permissions from the list:") }}

                                @if ($permissions->count())
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            {{ html()->label($permission->name)->for("permission-" . $permission->id)->class("form-check-label") }}
                                            {{ html()->checkbox("permissions[]", in_array($permission->name, $$module_name_singular->permissions->pluck("name")->all()), $permission->name)->id("permission-" . $permission->id)->class("form-check-input") }}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <x-cube::backend-button-save />
                            </div>
                        </div>
                        
                        <div class="col-8">
                            <div class="float-end">
                                @can("delete_" . $module_name)
                                <a
                                    class="btn btn-danger"
                                    data-method="DELETE"
                                    data-token="{{ csrf_token() }}"
                                    data-toggle="tooltip"
                                    href="{{ route("backend.$module_name.destroy", $$module_name_singular) }}"
                                    title="{{ __("labels.backend.delete") }}"
                                >
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    {{ html()->form()->close() }}
                    
                    <!-- Cancel button outside the form to prevent accidental form submission -->
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="float-end">
                                <x-cube::backend-button-return-back>Cancel</x-cube::backend-button-return-back>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <small class="text-muted float-end">
                        Updated: {{ $$module_name_singular->updated_at->diffForHumans() }}, Created at:
                        {{ $$module_name_singular->created_at->isoFormat("LLLL") }}
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
