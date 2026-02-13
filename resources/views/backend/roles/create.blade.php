@extends("backend.layouts.app")

@section("title")
    {{ __($module_action) }} {{ __($module_title) }}
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
    <x-cube::backend-layout-create>
        <x-cube::backend-section-header>
            <i class="{{ $module_icon }}"></i>
            {{ __($module_title) }}
            <small class="text-muted">{{ __($module_action) }}</small>

            <x-slot name="toolbar">
                <x-cube::backend-button-return-back :small="true" />
            </x-slot>
        </x-cube::backend-section-header>

        <div class="row">
            <div class="col">
                {{ html()->form("POST", route("backend.roles.store"))->class("form-horizontal")->open() }}

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
                                        {{ html()->checkbox("permissions[]", old("permissions") && in_array($permission->name, old("permissions")) ? true : false, $permission->name)->id("permission-" . $permission->id)->class("form-check-input") }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <x-backend-button-create title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}">
                                {{ __("Create") }}
                            </x-backend-button-create>
                        </div>
                    </div>
                </div>
                {{ html()->form()->close() }}
                
                <!-- Cancel button outside the form to prevent accidental form submission -->
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="float-end">
                            <div class="form-group">
                                <x-backend-button-cancel />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-cube::backend-layout-create>
@endsection
