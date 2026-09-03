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
            <form method="POST" action="{{ route("backend.users.update", $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <x-cube::label for="avatar" :value="__('labels.backend.users.fields.avatar')" />
                    <div class="flex flex-wrap gap-4 items-start mt-1">
                        <img
                            class="max-w-full rounded-lg border border-gray-300 dark:border-gray-600"
                            src="{{ asset($$module_name_singular->avatar) }}"
                            style="max-height: 200px; max-width: 200px"
                            aria-labelledby="avatar-label"
                        />
                        <input
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="avatar"
                            name="avatar"
                            type="file"
                            aria-labelledby="avatar-label"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <x-cube::group name="first_name" :label="__(label_case('first_name'))" required>
                        <x-cube::input type="text" name="first_name" :value="old('first_name', $user->first_name)" :placeholder="__(label_case('first_name'))" required />
                    </x-cube::group>
                    <x-cube::group name="last_name" :label="__(label_case('last_name'))" required>
                        <x-cube::input type="text" name="last_name" :value="old('last_name', $user->last_name)" :placeholder="__(label_case('last_name'))" required />
                    </x-cube::group>
                    <x-cube::group name="email" :label="__(label_case('email'))" required>
                        <x-cube::input type="email" name="email" :value="old('email', $user->email)" :placeholder="__(label_case('email'))" required />
                    </x-cube::group>
                    <x-cube::group name="mobile" :label="__(label_case('mobile'))">
                        <x-cube::input type="text" name="mobile" :value="old('mobile', $user->mobile)" :placeholder="__(label_case('mobile'))" />
                    </x-cube::group>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <x-cube::group name="gender" :label="__(label_case('gender'))">
                        <x-cube::select name="gender">
                            <option value="">-- Select an option --</option>
                            @foreach(["Female" => "Female", "Male" => "Male", "Other" => "Other"] as $val => $label)
                                <option value="{{ $val }}" {{ old('gender', $user->gender) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </x-cube::select>
                    </x-cube::group>
                    <x-cube::group name="date_of_birth" :label="__(label_case('date_of_birth'))">
                        <x-cube::input type="date" name="date_of_birth" :value="old('date_of_birth', $user->date_of_birth)" />
                    </x-cube::group>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <x-cube::group name="address" :label="__(label_case('address'))">
                        <x-cube::textarea name="address" :placeholder="__(label_case('address'))">{{ old('address', $user->address) }}</x-cube::textarea>
                    </x-cube::group>
                    <x-cube::group name="bio" :label="__(label_case('bio'))">
                        <x-cube::textarea name="bio" :placeholder="__(label_case('bio'))">{{ old('bio', $user->bio) }}</x-cube::textarea>
                    </x-cube::group>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    @foreach ($$module_name_singular->socialFieldsNames() as $item)
                        <div class="mb-4">
                            <x-cube::label :for="'social_profiles[' . $item . ']'" :value="label_case($item)" />
                            <div class="mt-1">
                                <x-cube::input type="text" name="social_profiles[{{ $item }}]" :value="old('social_profiles.' . $item, $user->social_profiles[$item] ?? '')" :placeholder="label_case($item)" />
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-wrap items-center gap-4 mb-3">
                    <x-cube::label :value="__('labels.backend.users.fields.password')" />
                    <a
                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 border border-blue-700 rounded-lg hover:bg-blue-50 dark:border-blue-400 dark:text-blue-400"
                        href="{{ route("backend.users.changePassword", $user->id) }}"
                    >
                        <i class="fas fa-key"></i>
                        &nbsp;
                        @lang("Change Password")
                    </a>
                </div>

                <div class="flex flex-wrap items-center gap-4 mb-3">
                    <x-cube::label :value="__('labels.backend.users.fields.confirmed')" />
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
                    <x-cube::label :value="__('labels.backend.users.fields.social')" />
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
                        <x-cube::label :value="__('Abilities')" />
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-1">
                            <div class="bg-white dark:bg-gray-800 border border-sky-200 dark:border-sky-800 rounded-lg">
                                <div class="px-4 py-3 border-b border-sky-200 dark:border-sky-800 font-semibold text-gray-900 dark:text-white">@lang("Roles")</div>
                                <div class="p-4 space-y-2">
                                    @if ($roles->count())
                                        @foreach ($roles as $role)
                                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg mb-3">
                                                <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                                    <x-cube::checkbox
                                                        name="roles[]"
                                                        value="{{ $role->name }}"
                                                        id="role-{{ $role->id }}"
                                                        :checked="in_array($role->name, $userRoles)"
                                                    >{{ label_case($role->name) }} ({{ $role->name }})</x-cube::checkbox>
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
                                            <x-cube::checkbox
                                                name="permissions[]"
                                                value="{{ $permission->name }}"
                                                id="permission-{{ $permission->id }}"
                                                :checked="in_array($permission->name, $userPermissions)"
                                            >{{ label_case($permission->name) }} ({{ $permission->name }})</x-cube::checkbox>
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
            </form>

            <!-- Cancel button outside the form to prevent accidental form submission -->
            <div class="flex justify-end mb-3">
                <x-cube::backend-button-return-back>@lang("Cancel")</x-cube::backend-button-return-back>
            </div>
        </div>
    </x-cube::backend-layout-edit>
@endsection
