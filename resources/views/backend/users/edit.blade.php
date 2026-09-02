@extends("backend.layouts.app")

@section("title")
    {{ $$module_name_singular->name }} - {{ $$module_name_singular->username }} - {{ __($module_action) }}
    {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-cube::backend-breadcrumbs>
        <x-cube::backend-breadcrumb-item route='{{ route("backend.$module_name.index") }}' icon="{{ $module_icon }}">
            {{ $$module_name_singular->name }}
        </x-cube::backend-breadcrumb-item>

        <x-cube::backend-breadcrumb-item type="active">
            {{ __($module_title) }}
            {{ __($module_action) }}
        </x-cube::backend-breadcrumb-item>
    </x-cube::backend-breadcrumbs>
@endsection

@section("content")
    <x-cube::backend-layout-edit :data="$user">
        <x-cube::backend-section-header>
            <i class="{{ $module_icon }}"></i>
            {{ $$module_name_singular->name }}
            <small class="text-gray-500 dark:text-gray-400">{{ __($module_title) }} {{ __($module_action) }}</small>

            <x-slot name="toolbar">
                <x-cube::backend-button-return-back :small="true" />
                <x-cube::backend-button-show
                    class="ml-1"
                    title="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
                    route='{!! route("backend.$module_name.show", $$module_name_singular) !!}'
                    :small="true"
                />
            </x-slot>
        </x-cube::backend-section-header>

        <div class="mt-4">
            {{ html()->modelForm($user, "PATCH", route("backend.users.update", $user->id))->acceptsFiles()->open() }}

            <div class="mb-4">
                {{ html()->label(__("labels.backend.users.fields.avatar"))->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->for("name")->id("avatar-label") }}
                <div class="flex flex-wrap gap-4 items-start">
                    <img
                        class="max-w-full rounded-lg border border-gray-300 dark:border-gray-600"
                        src="{{ asset($$module_name_singular->avatar) }}"
                        style="max-height: 200px; max-width: 200px"
                        aria-labelledby="avatar-label"
                    />
                    <div>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file-multiple-input" name="avatar" type="file" multiple="" aria-labelledby="avatar-label" />
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <?php
                    $field_name = "first_name";
                    $field_lable = __(label_case($field_name));
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
                    $field_lable = __(label_case($field_name));
                    $field_placeholder = $field_lable;
                    $required = "required";
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->text($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                </div>
                <div>
                    <?php
                    $field_name = "email";
                    $field_lable = __(label_case($field_name));
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
                    $field_lable = __(label_case($field_name));
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
                    $field_name = "gender";
                    $field_lable = __(label_case($field_name));
                    $field_placeholder = "-- Select an option --";
                    $required = "";
                    $select_options = [
                        "Female" => "Female",
                        "Male" => "Male",
                        "Other" => "Other",
                    ];
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class("appearance-none block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                </div>

                <div>
                    <?php
                    $field_name = "date_of_birth";
                    $field_lable = __(label_case($field_name));
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->date($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <?php
                    $field_name = "address";
                    $field_lable = __(label_case($field_name));
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->textarea($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                </div>
                <div>
                    <?php
                    $field_name = "bio";
                    $field_lable = __(label_case($field_name));
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>

                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->textarea($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                </div>
            </div>

            @php
                $socialFieldsNames = $$module_name_singular->socialFieldsNames();
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                @foreach ($$module_name_singular->socialFieldsNames() as $item)
                    <div>
                        <?php
                        $field_name = "social_profiles[" . $item . "]";
                        $field_lable = label_case($item);
                        $field_placeholder = $field_lable;
                        $required = "";
                        ?>

                        {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->text($field_name)->placeholder($field_placeholder)->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                    </div>
                @endforeach
            </div>

            <div class="flex flex-wrap items-center gap-4 mb-3">
                <?php
                $field_name = "password";
                $field_lable = __("labels.backend.users.fields.password");
                $field_placeholder = $field_lable;
                $required = "required";
                ?>

                <div>
                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white") }}
                    {!! field_required($required) !!}
                </div>
                <div>
                    <a
                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-50 dark:border-blue-400 dark:text-blue-400"
                        href="{{ route("backend.users.changePassword", $user->id) }}"
                    >
                        <i class="fas fa-key"></i>
                        &nbsp;
                        @lang("Change Password")
                    </a>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4 mb-3">
                <?php
                $field_name = "confirmed";
                $field_lable = __("labels.backend.users.fields.confirmed");
                $field_placeholder = $field_lable;
                $required = "";
                ?>

                <div>
                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white") }}
                    {!! field_required($required) !!}
                </div>
                <div>
                    @if ($user->email_verified_at == null)
                        <a
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-50 dark:border-blue-400 dark:text-blue-400"
                            href="{{ route("backend.users.emailConfirmationResend", $user->id) }}"
                            title="Send Confirmation Email"
                        >
                            <i class="fas fa-envelope"></i>
                            Send Confirmation Email
                        </a>
                    @else
                        {!! $user->confirmed_label !!}
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4 mb-3">
                <?php
                $field_name = "social";
                $field_lable = __("labels.backend.users.fields.social");
                $field_placeholder = $field_lable;
                $required = "";
                ?>

                <div>
                    {{ html()->label($field_lable, $field_name)->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white") }}
                    {!! field_required($required) !!}
                </div>
                <div>
                    @forelse ($user->providers as $provider)
                        <li>
                            <i class="fab fa-{{ $provider->provider }} fa-fw"></i>
                            {{ label_case($provider->provider) }}
                        </li>
                    @empty
                        {{ __("No social profile added!") }}
                    @endforelse
                </div>
            </div>

            @can("edit_users_permissions")
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
                                                    <input
                                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                                        id="{{ "role-" . $role->id }}"
                                                        name="roles[]"
                                                        type="checkbox"
                                                        value="{{ $role->name }}"
                                                        {{ in_array($role->name, $userRoles) ? "checked" : "" }}
                                                        aria-label="{{ label_case($role->name) . " (" . $role->name . ")" }}"
                                                    />
                                                    <label
                                                        class="text-sm font-medium text-gray-900 dark:text-gray-300"
                                                        for="{{ "role-" . $role->id }}"
                                                    >
                                                        &nbsp;{{ label_case($role->name) . " (" . $role->name . ")" }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="p-4 text-sm text-gray-600 dark:text-gray-400">
                                                @if ($role->id != 1)
                                                    @if ($role->permissions->count())
                                                        @foreach ($role->permissions as $permission)
                                                            <i class="far fa-check-circle fa-fw mr-1"></i>
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
                                            <input
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                                id="{{ "permission-" . $permission->id }}"
                                                name="permissions[]"
                                                type="checkbox"
                                                value="{{ $permission->name }}"
                                                {{ in_array($permission->name, $userPermissions) ? "checked" : "" }}
                                                aria-label="{{ label_case($permission->name) . " (" . $permission->name . ")" }}"
                                            />
                                            <label
                                                class="text-sm font-medium text-gray-900 dark:text-gray-300"
                                                for="{{ "permission-" . $permission->id }}"
                                            >
                                                &nbsp;{{ label_case($permission->name) . " (" . $permission->name . ")" }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="flex items-center justify-between mb-3">
                <div>
                    <x-cube::backend-button-save />
                </div>

                <div class="flex items-center gap-2">
                    @if ($$module_name_singular->status != 2 && $$module_name_singular->id != 1)
                        <a
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
                            data-method="PATCH"
                            data-token="{{ csrf_token() }}"
                            data-confirm="Are you sure?"
                            href="{{ route("backend.users.block", $$module_name_singular) }}"
                            title="{{ __("labels.backend.block") }}"
                        >
                            <i class="fas fa-ban"></i>
                        </a>
                    @endif

                    @if ($$module_name_singular->status == 2)
                        <a
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-sky-500 rounded-lg hover:bg-sky-600"
                            data-method="PATCH"
                            data-token="{{ csrf_token() }}"
                            data-confirm="Are you sure?"
                            href="{{ route("backend.users.unblock", $$module_name_singular) }}"
                            title="{{ __("labels.backend.unblock") }}"
                        >
                            <i class="fas fa-check"></i>
                            Unblock
                        </a>
                    @endif

                    @if ($$module_name_singular->email_verified_at == null)
                        <a
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                            href="{{ route("backend.users.emailConfirmationResend", $$module_name_singular->id) }}"
                            title="Send Confirmation Email"
                        >
                            <i class="fas fa-envelope"></i>
                        </a>
                    @endif

                    @can("delete_" . $module_name)
                        @if ($$module_name_singular->id != 1)
                            <a
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
                                data-method="DELETE"
                                data-token="{{ csrf_token() }}"
                                href="{{ route("backend.$module_name.destroy", $$module_name_singular) }}"
                                title="{{ __("labels.backend.delete") }}"
                            >
                                <i class="fas fa-trash-alt"></i>
                                Delete
                            </a>
                        @endif
                    @endcan
                </div>
            </div>

            {{ html()->closeModelForm() }}

            <!-- Cancel button outside the form to prevent accidental form submission -->
            <div class="flex justify-end mb-3">
                <x-cube::backend-button-return-back>@lang("Cancel")</x-cube::backend-button-return-back>
            </div>
        </div>
    </x-cube::backend-layout-edit>
@endsection
