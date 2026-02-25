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
            <small class="text-muted">{{ __($module_title) }} {{ __($module_action) }}</small>

            <x-slot name="toolbar">
                <x-cube::backend-button-return-back :small="true" />
                <x-cube::backend-button-show
                    class="ms-1"
                    title="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
                    route='{!! route("backend.$module_name.show", $$module_name_singular) !!}'
                    :small="true"
                />
            </x-slot>
        </x-cube::backend-section-header>

        <div class="row mt-4">
            <div class="col">
                {{ html()->modelForm($user, "PATCH", route("backend.users.update", $user->id))->class("form-horizontal")->acceptsFiles()->open() }}

                <div class="form-group row">
                    {{ html()->label(__("labels.backend.users.fields.avatar"))->class("col-md-2 form-label")->for("name")->id("avatar-label") }}

<div class="col-md-5 mb-3">
    <img
        class="user-profile-image img-fluid img-thumbnail"
        src="{{ asset($$module_name_singular->avatar) }}"
        style="max-height: 200px; max-width: 200px"
        aria-labelledby="avatar-label"
    />
</div>
<div class="col-md-5 mb-3">
    <input id="file-multiple-input" name="avatar" type="file" multiple="" aria-labelledby="avatar-label" />
</div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "first_name";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                        </div>
                    </div>
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "last_name";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                        </div>
                    </div>
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "email";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->email($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                        </div>
                    </div>
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "mobile";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="form-group">
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

                            {{ html()->label($field_lable, $field_name)->class("form-label")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class("form-select")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                        </div>
                    </div>

                    <div class="col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "date_of_birth";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->date($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "address";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->textarea($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                        </div>
                    </div>
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "bio";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->textarea($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                        </div>
                    </div>
                </div>

                @php
                    $socialFieldsNames = $$module_name_singular->socialFieldsNames();
                @endphp

                <div class="row">
                    @foreach ($$module_name_singular->socialFieldsNames() as $item)
                        <div class="col-sm-6 col-12 mb-3">
                            <div class="form-group">
                                <?php
                                $field_name = "social_profiles[" . $item . "]";
                                $field_lable = label_case($item);
                                $field_placeholder = $field_lable;
                                $required = "";
                                ?>

                                {{ html()->label($field_lable, $field_name)->class("form-label")->id("{$field_name}-label") }}
{!! field_required($required) !!}
{{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required", "aria-labelledby" => "{$field_name}-label"]) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mb-3">
                    <?php
                    $field_name = "password";
                    $field_lable = __("labels.backend.users.fields.password");
                    $field_placeholder = $field_lable;
                    $required = "required";
                    ?>

                    <div class="col-sm-2 col-12">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                        </div>
                    </div>
                    <div class="col-sm-10 col-12">
                        <div class="form-group">
                            <a
                                class="btn btn-outline-primary btn-sm"
                                href="{{ route("backend.users.changePassword", $user->id) }}"
                            >
                                <i class="fas fa-key"></i>
                                &nbsp;
                                @lang("Change Password")
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <?php
                    $field_name = "confirmed";
                    $field_lable = __("labels.backend.users.fields.confirmed");
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>

                    <div class="col-sm-2 col-12">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                        </div>
                    </div>
                    <div class="col-sm-10 col-12">
                        <div class="form-group">
                            @if ($user->email_verified_at == null)
                                <a
                                    class="btn btn-outline-primary btn-sm"
                                    data-toggle="tooltip"
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
                </div>

                <div class="row mb-3">
                    <?php
                    $field_name = "social";
                    $field_lable = __("labels.backend.users.fields.social");
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>

                    <div class="col-sm-2 col-12">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                        </div>
                    </div>
                    <div class="col-sm-10 col-12">
                        <div class="form-group">
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
                </div>

                @can("edit_users_permissions")
                    <div class="form-group row mb-3">
                        {{ html()->label(__("Abilities"))->class("col-sm-2 form-label") }}
                        <div class="col">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <div class="card card-accent-primary">
                                        <div class="card-header">
                                            @lang("Roles")
                                        </div>
                                        <div class="card-body">
                                            @if ($roles->count())
                                                @foreach ($roles as $role)
                                                    <div class="card mb-3">
                                                        <div class="card-header">
                                                            <div class="checkbox">
    <div class="form-check">
        <input
            class="form-check-input"
            id="{{ "role-" . $role->id }}"
            name="roles[]"
            type="checkbox"
            value="{{ $role->name }}"
            {{ in_array($role->name, $userRoles) ? "checked" : "" }}
            aria-label="{{ label_case($role->name) . " (" . $role->name . ")" }}"
        />
        <label
            class="form-check-label"
            for="{{ "role-" . $role->id }}"
        >
            &nbsp;{{ label_case($role->name) . " (" . $role->name . ")" }}
        </label>
    </div>
</div>
                                                        </div>
                                                        <div class="card-body">
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
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="card card-accent-info">
                                        <div class="card-header">
                                            @lang("Permissions")
                                        </div>
                                        <div class="card-body">
                                            @if ($permissions->count())
                                                @foreach ($permissions as $permission)
                                                    <div class="mb-2">
    <input
        class="form-check-input"
        id="{{ "permission-" . $permission->id }}"
        name="permissions[]"
        type="checkbox"
        value="{{ $permission->name }}"
        {{ in_array($permission->name, $userPermissions) ? "checked" : "" }}
        aria-label="{{ label_case($permission->name) . " (" . $permission->name . ")" }}"
    />
    <label
        class="form-check-label"
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
                        </div>
                    </div>
                @endcan

                <div class="row">
                    <div class="col-4 mb-3">
                        <div class="form-group">
                            <x-cube::backend-button-save />
                        </div>
                    </div>

                    <div class="col-8 mb-3">
                        <div class="float-end">
                            @if ($$module_name_singular->status != 2 && $$module_name_singular->id != 1)
                                <a
                                    class="btn btn-danger"
                                    data-method="PATCH"
                                    data-token="{{ csrf_token() }}"
                                    data-toggle="tooltip"
                                    data-confirm="Are you sure?"
                                    href="{{ route("backend.users.block", $$module_name_singular) }}"
                                    title="{{ __("labels.backend.block") }}"
                                >
                                    <i class="fas fa-ban"></i>
                                </a>
                            @endif

                            @if ($$module_name_singular->status == 2)
                                <a
                                    class="btn btn-info"
                                    data-method="PATCH"
                                    data-token="{{ csrf_token() }}"
                                    data-toggle="tooltip"
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
                                    class="btn btn-primary"
                                    data-toggle="tooltip"
                                    href="{{ route("backend.users.emailConfirmationResend", $$module_name_singular->id) }}"
                                    title="Send Confirmation Email"
                                >
                                    <i class="fas fa-envelope"></i>
                                </a>
                            @endif

                            @can("delete_" . $module_name)
                                @if ($$module_name_singular->id != 1)
                                    <a
                                        class="btn btn-danger"
                                        data-method="DELETE"
                                        data-token="{{ csrf_token() }}"
                                        data-toggle="tooltip"
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
                </div>
                {{ html()->closeModelForm() }}
                
                <!-- Cancel button outside the form to prevent accidental form submission -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="float-end">
                            <x-cube::backend-button-return-back>@lang("Cancel")</x-cube::backend-button-return-back>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
    </x-cube::backend-layout-edit>
@endsection
