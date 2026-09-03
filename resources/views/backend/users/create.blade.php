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
            <form method="POST" action="{{ route("backend.$module_name.store") }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <x-cube::group name="first_name" :label="label_case('first_name')" required>
                        <x-cube::input type="text" name="first_name" :value="old('first_name')" :placeholder="label_case('first_name')" required />
                    </x-cube::group>
                    <x-cube::group name="last_name" :label="label_case('last_name')" required>
                        <x-cube::input type="text" name="last_name" :value="old('last_name')" :placeholder="label_case('last_name')" required />
                    </x-cube::group>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <x-cube::group name="email" :label="label_case('email')" required>
                        <x-cube::input type="email" name="email" :value="old('email')" :placeholder="label_case('email')" required />
                    </x-cube::group>
                    <x-cube::group name="mobile" :label="label_case('mobile')">
                        <x-cube::input type="text" name="mobile" :value="old('mobile')" :placeholder="label_case('mobile')" />
                    </x-cube::group>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <x-cube::group name="password" :label="label_case('password')" required>
                        <x-cube::input type="password" name="password" :placeholder="label_case('password')" required />
                    </x-cube::group>
                    <x-cube::group name="password_confirmation" :label="label_case('password_confirmation')" required>
                        <x-cube::input type="password" name="password_confirmation" :placeholder="label_case('password_confirmation')" required />
                    </x-cube::group>
                </div>

                <div class="flex flex-col gap-2 mb-4">
                    <x-cube::checkbox name="status" value="1" :checked="old('status', true)">
                        @lang("Active")
                    </x-cube::checkbox>
                    <x-cube::checkbox name="confirmed" value="1" :checked="old('confirmed', true)">
                        @lang("Email Confirmed")
                    </x-cube::checkbox>
                    <x-cube::checkbox name="email_credentials" value="1" :checked="old('email_credentials', true)">
                        @lang("Email Credentials")
                    </x-cube::checkbox>
                </div>

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
                                                    :checked="in_array($role->name, old('roles', []))"
                                                >{{ ucwords($role->name) }} ({{ $role->name }})</x-cube::checkbox>
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
                                        <x-cube::checkbox
                                            name="permissions[]"
                                            value="{{ $permission->name }}"
                                            id="permission-{{ $permission->id }}"
                                            :checked="in_array($permission->name, old('permissions', []))"
                                        >{{ $permission->name }}</x-cube::checkbox>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <x-cube::backend-button-create>Create</x-cube::backend-button-create>
                </div>
            </form>

            <!-- Cancel button outside the form to prevent accidental form submission -->
            <div class="flex justify-end mt-3">
                <x-cube::backend-button-cancel />
            </div>
        </div>
    </x-cube::backend-layout-create>
@endsection
