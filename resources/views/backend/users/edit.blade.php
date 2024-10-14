@extends("backend.layouts.app")

@section("title")
    {{ $$module_name_singular->name }} - {{ $$module_name_singular->username }} - {{ __($module_action) }}
    {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-backend.breadcrumbs>
        <x-backend.breadcrumb-item route='{{ route("backend.$module_name.index") }}' icon="{{ $module_icon }}">
            {{ $$module_name_singular->name }}
        </x-backend.breadcrumb-item>

        <x-backend.breadcrumb-item type="active">
            {{ __($module_title) }}
            {{ __($module_action) }}
        </x-backend.breadcrumb-item>
    </x-backend.breadcrumbs>
@endsection

@section("content")
    <x-backend.layouts.edit :data="$user">
        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i>
            {{ $$module_name_singular->name }}
            <small class="text-muted">{{ __($module_title) }} {{ __($module_action) }}</small>

            <x-slot name="toolbar">
                <x-backend.buttons.return-back :small="true" />
                <x-backend.buttons.show
                    class="ms-1"
                    title="{{ __('Show') }} {{ ucwords(Str::singular($module_name)) }}"
                    route='{!! route("backend.$module_name.show", $$module_name_singular) !!}'
                    :small="true"
                />
            </x-slot>
        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col">
                {{ html()->modelForm($user, "PATCH", route("backend.users.update", $user->id))->class("form-horizontal")->acceptsFiles()->open() }}

                <div class="form-group row">
                    {{ html()->label(__("labels.backend.users.fields.avatar"))->class("col-md-2 form-label")->for("name") }}

                    <div class="col-md-5 mb-3">
                        <img
                            class="user-profile-image img-fluid img-thumbnail"
                            src="{{ asset($$module_name_singular->avatar) }}"
                            style="max-height: 200px; max-width: 200px"
                        />
                    </div>
                    <div class="col-md-5 mb-3">
                        <input id="file-multiple-input" name="avatar" type="file" multiple="" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "first_name";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "last_name";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "email";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                            {{ html()->email($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "mobile";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 mb-3">
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

                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class("form-select")->attributes(["$required"]) }}
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "date_of_birth";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                            {{ html()->date($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-6 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "address";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-3">
                        <div class="form-group">
                            <?php
                            $field_name = "bio";
                            $field_lable = __(label_case($field_name));
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
                        </div>
                    </div>
                </div>

                @php
                    $socialFieldsNames = $$module_name_singular->socialFieldsNames();
                @endphp

                <div class="row">
                    @foreach ($$module_name_singular->socialFieldsNames() as $item)
                        <div class="col-12 col-sm-6 mb-3">
                            <div class="form-group">
                                <?php
                                $field_name = "social_profiles[" . $item . "]";
                                $field_lable = label_case($item);
                                $field_placeholder = $field_lable;
                                $required = "";
                                ?>

                                {{ html()->label($field_lable, $field_name)->class("form-label") }}
                                {!! field_required($required) !!}
                                {{ html()->text($field_name)->placeholder($field_placeholder)->class("form-control")->attributes(["$required"]) }}
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

                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                        </div>
                    </div>
                    <div class="col-12 col-sm-10">
                        <div class="form-group">
                            <a
                                class="btn btn-outline-primary btn-sm"
                                href="{{ route("backend.users.changePassword", $user->id) }}"
                            >
                                <i class="fas fa-key"></i>
                                Change password
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

                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                        </div>
                    </div>
                    <div class="col-12 col-sm-10">
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

                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class("form-label") }}
                            {!! field_required($required) !!}
                        </div>
                    </div>
                    <div class="col-12 col-sm-10">
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
                                                                    />
                                                                    <label
                                                                        class="form-check-label"
                                                                        for="{{ "role-" . $role->id }}"
                                                                    >
                                                                        {{ label_case($role->name) . " (" . $role->name . ")" }}
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
                                                        />
                                                        <label
                                                            class="form-check-label"
                                                            for="{{ "permission-" . $permission->id }}"
                                                        >
                                                            {{ label_case($permission->name) . " (" . $permission->name . ")" }}
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
                            <x-backend.buttons.save />
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

                            <x-backend.buttons.return-back>@lang("Cancel")</x-backend.buttons.return-back>
                        </div>
                    </div>
                </div>
                {{ html()->closeModelForm() }}
            </div>
            <!--/.col-->
        </div>
    </x-backend.layouts.edit>
@endsection
