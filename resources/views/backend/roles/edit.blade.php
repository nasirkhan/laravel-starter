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
    <x-cube::backend-layout-edit :data="$$module_name_singular">
        <x-cube::backend-section-header>
            <i class="{{ $module_icon }}"></i>
            {{ __($module_title) }}
            <small class="text-gray-500 dark:text-gray-400">{{ __($module_action) }}</small>

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
            @php $name_locked = ($role_users_count ?? 0) > 0; @endphp

            <form method="POST" action="{{ route("backend.$module_name.update", $$module_name_singular->id) }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <x-cube::label for="name" :value="__('labels.backend.roles.fields.name')" required />

                    @if ($name_locked)
                        <input type="hidden" name="name" value="{{ $$module_name_singular->name }}" />
                        <div class="mt-1">
                            <x-cube::input type="text" name="name" :value="$$module_name_singular->name" :placeholder="__('labels.backend.roles.fields.name')" disabled />
                        </div>
                        <small class="text-yellow-600 dark:text-yellow-400">
                            <i class="fas fa-lock"></i>
                            {{ __('Role name cannot be changed because :count user(s) are assigned to this role.', ['count' => $role_users_count]) }}
                        </small>
                    @else
                        <div class="mt-1">
                            <x-cube::input type="text" name="name" :value="old('name', $$module_name_singular->name)" :placeholder="__('labels.backend.roles.fields.name')" required />
                        </div>
                        <x-cube::error :messages="$errors->get('name')" class="mt-2" />
                    @endif
                </div>

                <div class="mb-3">
                    <x-cube::label :value="__('Abilities')" />
                    <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">{{ __("Select permissions from the list:") }}</p>

                    @if ($permissions->count())
                        @foreach ($permissions as $permission)
                            <div class="mb-2">
                                <x-cube::checkbox
                                    name="permissions[]"
                                    value="{{ $permission->name }}"
                                    id="permission-{{ $permission->id }}"
                                    :checked="in_array($permission->name, $$module_name_singular->permissions->pluck('name')->all())"
                                >{{ $permission->name }}</x-cube::checkbox>
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
            </form>

            <!-- Cancel button outside the form to prevent accidental form submission -->
            <div class="flex justify-end mt-3">
                <x-cube::backend-button-return-back>Cancel</x-cube::backend-button-return-back>
            </div>
        @endif
    </x-cube::backend-layout-edit>
@endsection
