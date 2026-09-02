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
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <x-cube::backend-section-header>
                <i class="{{ $module_icon }}"></i>
                {{ __($module_title) }}
                <small class="text-gray-500 dark:text-gray-400">{{ __($module_action) }}</small>

                <x-slot name="toolbar">
                    <x-cube::backend-button-return-back :small="true" />
                    <x-backend-button-show
                        class="ml-1"
                        title="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
                        route='{!! route("backend.$module_name.show", $$module_name_singular) !!}'
                        :small="true"
                    />
                </x-slot>
            </x-cube::backend-section-header>

            @if ($is_protected_role ?? false)
                <div class="flex items-center gap-3 p-4 mb-4 text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400 dark:border-yellow-800" role="alert">
                    <i class="fas fa-lock fa-lg"></i>
                    <div>
                        <strong>{{ __('Protected Role') }}</strong> &mdash;
                        {{ __('This role is protected and cannot be updated.') }}
                    </div>
                </div>
                <a href="{{ route("backend.$module_name.index") }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800">
                    <i class="fas fa-arrow-left"></i> {{ __('Back to Roles') }}
                </a>
            @else
                {{ html()->modelForm($$module_name_singular, "PATCH", route("backend.$module_name.update", $$module_name_singular->id))->open() }}

                <div class="mb-3">
                    <?php
                    $field_name = "name";
                    $field_lable = __("labels.backend.roles.fields.name");
                    $field_placeholder = $field_lable;
                    $required = "required";
                    $name_locked = ($role_users_count ?? 0) > 0;
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
                    {!! field_required($required) !!}

                    @if ($name_locked)
                        {{ html()->hidden($field_name, $$module_name_singular->name) }}
                        {{ html()->text($field_name, $$module_name_singular->name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["disabled", "aria-labelledby" => "{$field_name}-label"]) }}
                        <small class="text-yellow-600 dark:text-yellow-400">
                            <i class="fas fa-lock"></i>
                            {{ __('Role name cannot be changed because :count user(s) are assigned to this role.', ['count' => $role_users_count]) }}
                        </small>
                    @else
                        {{ html()->text($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                    @endif
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
                                {{ html()->checkbox("permissions[]", in_array($permission->name, $$module_name_singular->permissions->pluck("name")->all()), $permission->name)->id("permission-" . $permission->id)->class("w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600")->attributes(["aria-label" => $permission->name]) }}
                                {{ html()->label($permission->name)->for("permission-" . $permission->id)->class("text-sm font-medium text-gray-900 dark:text-gray-300") }}
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="flex items-center justify-between mb-3">
                    <div>
                        <x-cube::backend-button-save />
                    </div>

                    <div>
                        @can("delete_" . $module_name)
                        <a
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
                            data-method="DELETE"
                            data-token="{{ csrf_token() }}"
                            href="{{ route("backend.$module_name.destroy", $$module_name_singular) }}"
                            title="{{ __("labels.backend.delete") }}"
                        >
                            <i class="fas fa-trash-alt"></i>
                        </a>
                        @endcan
                    </div>
                </div>

                {{ html()->form()->close() }}

                <!-- Cancel button outside the form to prevent accidental form submission -->
                <div class="flex justify-end mt-3">
                    <x-cube::backend-button-return-back>Cancel</x-cube::backend-button-return-back>
                </div>
            @endif
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-3">
            <small class="text-gray-500 dark:text-gray-400 float-right">
                Updated: {{ $$module_name_singular->updated_at->diffForHumans() }}, Created at:
                {{ $$module_name_singular->created_at->isoFormat("LLLL") }}
            </small>
        </div>
    </div>
@endsection
