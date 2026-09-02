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
            <small class="text-gray-500 dark:text-gray-400">{{ __($module_action) }}</small>

            <x-slot name="toolbar">
                <x-cube::backend-button-return-back :small="true" />
            </x-slot>
        </x-cube::backend-section-header>

        {{ html()->form("POST", route("backend.roles.store"))->open() }}

        <div class="mb-3">
            <?php
            $field_name = "name";
            $field_lable = __("labels.backend.roles.fields.name");
            $field_placeholder = $field_lable;
            $required = "required";
            ?>

            {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
            {!! field_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
        </div>

        <div class="mb-3">
            <?php
            $field_name = "name";
            $field_lable = __("Abilities");
            $field_placeholder = $field_lable;
            $required = "";
            ?>

            {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white") }}
            {!! field_required($required) !!}

            <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">{{ __("Select permissions from the list:") }}</p>

            @if ($permissions->count())
                @foreach ($permissions as $permission)
                    <div class="flex items-center gap-2 mb-2">
                        {{ html()->checkbox("permissions[]", old("permissions") && in_array($permission->name, old("permissions")) ? true : false, $permission->name)->id("permission-" . $permission->id)->class("w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600")->attributes(["aria-label" => $permission->name]) }}
                        {{ html()->label($permission->name)->for("permission-" . $permission->id)->class("text-sm font-medium text-gray-900 dark:text-gray-300") }}
                    </div>
                @endforeach
            @endif
        </div>

        <div class="mb-4">
            <x-backend-button-create title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}">
                {{ __("Create") }}
            </x-backend-button-create>
        </div>

        {{ html()->form()->close() }}

        <!-- Cancel button outside the form to prevent accidental form submission -->
        <div class="flex justify-end mt-3">
            <x-backend-button-cancel />
        </div>
    </x-cube::backend-layout-create>
@endsection
