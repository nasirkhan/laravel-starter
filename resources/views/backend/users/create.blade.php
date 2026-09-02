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

        <div class="mt-4">
            {{ html()->form("POST", route("backend.$module_name.store"))->acceptsFiles()->open() }}

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <?php
                    $field_name = "first_name";
                    $field_lable = label_case($field_name);
                    $field_placeholder = $field_lable;
                    $required = "required";
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->text($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                </div>
                <div>
                    <?php
                    $field_name = "last_name";
                    $field_lable = label_case($field_name);
                    $field_placeholder = $field_lable;
                    $required = "required";
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->text($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <?php
                    $field_name = "email";
                    $field_lable = label_case($field_name);
                    $field_placeholder = $field_lable;
                    $required = "required";
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->email($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                </div>
                <div>
                    <?php
                    $field_name = "mobile";
                    $field_lable = label_case($field_name);
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->text($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <?php
                    $field_name = "password";
                    $field_lable = label_case($field_name);
                    $field_placeholder = $field_lable;
                    $required = "required";
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->password($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                </div>
                <div>
                    <?php
                    $field_name = "password_confirmation";
                    $field_lable = label_case($field_name);
                    $field_placeholder = $field_lable;
                    $required = "required";
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->password($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                </div>
            </div>

            <div class="flex items-center gap-3 mb-3">
                {{ html()->label(__("labels.backend.users.fields.status"))->class("text-sm font-medium text-gray-900 dark:text-white")->for("status")->id("status-label") }}
                {{ html()->checkbox("status", true, "1")->attributes(["aria-labelledby" => "status-label"]) }}
                @lang("Active")
            </div>

            <div class="flex items-center gap-3 mb-3">
                {{ html()->label(__("labels.backend.users.fields.confirmed"))->class("text-sm font-medium text-gray-900 dark:text-white")->for("confirmed")->id("confirmed-label") }}
                {{ html()->checkbox("confirmed", true, "1")->attributes(["aria-labelledby" => "confirmed-label"]) }}
                @lang("Email Confirmed")
            </div>

            <div class="flex items-center gap-3 mb-3">
                {{ html()->label(__("labels.backend.users.fields.email_credentials"))->class("text-sm font-medium text-gray-900 dark:text-white")->for("email_credentials")->id("email_credentials-label") }}
                {{ html()->checkbox("email_credentials", true, "1")->attributes(["aria-labelledby" => "email_credentials-label"]) }}
                @lang("Email Credentials")
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang("Abilities")</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white dark:bg-gray-800 border border-sky-200 dark:border-sky-800 rounded-lg">
                        <div class="px-4 py-3 border-b border-sky-200 dark:border-sky-800 font-semibold text-gray-900 dark:text-white">@lang("Roles")</div>
                        <div class="p-4 space-y-2">
                            @if ($roles->count())
                                @foreach ($roles as $role)
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg mb-3">
                                        <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                            <div class="flex items-center gap-2">
                                                {{ html()->checkbox("roles[]", old("roles") && in_array($role->name, old("roles")) ? true : false, $role->name)->id("role-" . $role->id)->class("w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600")->attributes(["aria-label" => ucwords($role->name) . " (" . $role->name . ")"]) }}
                                                <label for="role-{{ $role->id }}" class="text-sm font-medium text-gray-900 dark:text-gray-300">{{ ucwords($role->name) }} ({{ $role->name }})</label>
                                            </div>
                                        </div>
                                        <div class="p-4 text-sm text-gray-600 dark:text-gray-400">
                                            @if ($role->id != 1)
                                                @if ($role->permissions->count())
                                                    @foreach ($role->permissions as $permission)
                                                        <i class="far fa-check-circle mr-1"></i>
                                                        &nbsp;{{ $permission->name }}&nbsp;
                                                    @endforeach
                                                @else
                                                    @lang("None")
                                                @endif
                                            @else
                                                @lang("All Permissions")
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <div class="px-4 py-3 border-b border-blue-200 dark:border-blue-800 font-semibold text-gray-900 dark:text-white">@lang("Permissions")</div>
                        <div class="p-4 space-y-2">
                            @if ($permissions->count())
                                @foreach ($permissions as $permission)
                                    <div class="flex items-center gap-2 mb-2">
                                        {{ html()->checkbox("permissions[]", old("permissions") && in_array($permission->name, old("permissions")) ? true : false, $permission->name)->id("permission-" . $permission->id)->class("w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600")->attributes(["aria-label" => $permission->name]) }}
                                        <label for="permission-{{ $permission->id }}" class="text-sm font-medium text-gray-900 dark:text-gray-300">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <x-cube::backend-button-create>Create</x-cube::backend-button-create>
            </div>

            {{ html()->form()->close() }}

            <!-- Cancel button outside the form to prevent accidental form submission -->
            <div class="flex justify-end mt-3">
                <x-cube::backend-button-cancel />
            </div>
        </div>
    </x-cube::backend-layout-create>
@endsection
