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
    <x-cube::backend-layout-show :data="$user">
        <x-cube::backend-section-header>
            <i class="{{ $module_icon }}"></i>
            {{ $$module_name_singular->name }}
            <small class="text-gray-500 dark:text-gray-400">{{ __($module_title) }} {{ __($module_action) }}</small>

            <x-slot name="toolbar">
                <x-cube::backend-button-return-back :small="true" />
                <a
                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 m-0.5"
                    href="{{ route("backend.users.index") }}"
                    title="List"
                >
                    <i class="fas fa-list"></i>
                    List
                </a>
                <x-backend-button-edit
                    title="{{ __('Edit') }} {{ ucwords(Str::singular($module_name)) }}"
                    route='{!! route("backend.$module_name.edit", $$module_name_singular) !!}'
                    :small="true"
                />
            </x-slot>
        </x-cube::backend-section-header>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                <tr>
                    <th class="px-4 py-3">{{ __("labels.backend.users.fields.avatar") }}</th>
                    <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <img
                            class="max-w-full rounded-lg border border-gray-300 dark:border-gray-600"
                            src="{{ asset($$module_name_singular->avatar) }}"
                            style="max-height: 200px; max-width: 200px"
                        />
                    </td>
                </tr>

                @php
                    $fields_array = [
                        ["name" => "username", "type" => "text"],
                        ["name" => "name", "type" => "text"],
                        ["name" => "email", "type" => "text"],
                        ["name" => "mobile", "type" => "text"],
                        ["name" => "gender", "type" => "text"],
                        ["name" => "date_of_birth", "type" => "date"],
                        ["name" => "address", "type" => "text"],
                        ["name" => "bio", "type" => "text"],
                        ["name" => "last_ip", "type" => "text"],
                        ["name" => "login_count", "type" => "text"],
                        ["name" => "last_login", "type" => "datetime"],
                    ];
                @endphp

                @foreach ($fields_array as $item)
                    @php
                        $field_name = $item["name"];
                    @endphp

                    <tr>
                        <th class="px-4 py-3">{{ __(label_case($field_name)) }}</th>
                        <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">{{ $user->$field_name }}</td>
                    </tr>
                @endforeach

                <tr>
                    <th class="px-4 py-3">{{ __("labels.backend.users.fields.password") }}</th>
                    <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <a
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-50 dark:border-blue-400 dark:text-blue-400"
                            href="{{ route("backend.users.changePassword", $user->id) }}"
                        >
                            Change password
                        </a>
                    </td>
                </tr>

                <tr>
                    <th class="px-4 py-3">{{ __("labels.backend.users.fields.social") }}</th>
                    <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        <ul>
                            @foreach ($user->providers as $provider)
                                <li>
                                    <i class="fab fa-{{ $provider->provider }}"></i>
                                    {{ label_case($provider->provider) }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>

                <tr>
                    <th class="px-4 py-3">{{ __("labels.backend.users.fields.status") }}</th>
                    <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">{!! $user->status_label !!}</td>
                </tr>

                <tr>
                    <th class="px-4 py-3">{{ __("labels.backend.users.fields.confirmed") }}</th>
                    <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        {!! $user->confirmed_label !!}
                        @if ($user->email_verified_at == null)
                                <a
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 m-0.5"
                                    href="{{ route("backend.users.emailConfirmationResend", $user->id) }}"
                                    title="Send Confirmation Email"
                                >
                                    <i class="fas fa-envelope"></i>
                                    Send Confirmation Reminder
                                </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="px-4 py-3">{{ __("labels.backend.users.fields.roles") }}</th>
                    <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        @if ($user->getRoleNames()->count() > 0)
                            <ul>
                                @foreach ($user->getRoleNames() as $role)
                                    <li>{{ ucwords($role) }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="px-4 py-3">{{ __("labels.backend.users.fields.permissions") }}</th>
                    <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        @if ($user->getAllPermissions()->count() > 0)
                            <ul>
                                @foreach ($user->getAllPermissions() as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th class="px-4 py-3">{{ __("labels.backend.users.fields.created_at") }}</th>
                    <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        {{ $user->created_at }} by User:{{ $user->created_by }}
                        <br />
                        <small>({{ $user->created_at->diffForHumans() }})</small>
                    </td>
                </tr>

                <tr>
                    <th class="px-4 py-3">{{ __("labels.backend.users.fields.updated_at") }}</th>
                    <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        {{ $user->updated_at }} by User:{{ $user->updated_by }}
                        <br />
                        <small>({{ $user->updated_at->diffForHumans() }})</small>
                    </td>
                </tr>

                <tr>
                    <th class="px-4 py-3">{{ __("Deleted At") }}</th>
                    <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                        @if ($user->deleted_at != null)
                                {{ $user->deleted_at }} by User:{{ $user->deleted_by }}
                                <br />
                                <small>({{ $user->deleted_at->diffForHumans() }})</small>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="py-4 text-end">
            @if ($user->status != 2)
                <a
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
                    data-method="PATCH"
                    data-token="{{ csrf_token() }}"
                    data-confirm="Are you sure?"
                    href="{{ route("backend.users.block", $user) }}"
                    title="{{ __("labels.backend.block") }}"
                >
                    <i class="fas fa-ban"></i>
                    @lang("Block")
                </a>
            @endif

            @if ($user->status == 2)
                <a
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-sky-500 rounded-lg hover:bg-sky-600"
                    data-method="PATCH"
                    data-token="{{ csrf_token() }}"
                    data-confirm="Are you sure?"
                    href="{{ route("backend.users.unblock", $user) }}"
                    title="{{ __("labels.backend.unblock") }}"
                >
                    <i class="fas fa-check"></i>
                    @lang("Unblock")
                </a>
            @endif

            <a
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
                data-method="DELETE"
                data-token="{{ csrf_token() }}"
                data-confirm="Are you sure?"
                href="{{ route("backend.users.destroy", $user) }}"
                title="{{ __("labels.backend.delete") }}"
            >
                <i class="fas fa-trash-alt"></i>
                @lang("Delete")
            </a>
            @if ($user->email_verified_at == null)
                <a
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                    href="{{ route("backend.users.emailConfirmationResend", $user->id) }}"
                    title="Send Confirmation Email"
                >
                    <i class="fas fa-envelope"></i>
                    @lang("Email Confirmation")
                </a>
            @endif
        </div>
    </x-cube::backend-layout-show>
@endsection
