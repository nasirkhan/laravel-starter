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

        <form method="POST" action="{{ route("backend.roles.store") }}">
            @csrf

            <x-cube::group name="name" :label="__('labels.backend.roles.fields.name')" required>
                <x-cube::input type="text" name="name" :value="old('name')" :placeholder="__('labels.backend.roles.fields.name')" required />
            </x-cube::group>

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
                                :checked="in_array($permission->name, old('permissions', []))"
                            >{{ $permission->name }}</x-cube::checkbox>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="mb-4">
                <x-cube::backend-button-create title="{{ __('Create') }} {{ ucwords(Str::singular($module_name)) }}">
                    {{ __("Create") }}
                </x-cube::backend-button-create>
            </div>
        </form>

        <!-- Cancel button outside the form to prevent accidental form submission -->
        <div class="flex justify-end mt-3">
            <x-cube::backend-button-cancel />
        </div>
    </x-cube::backend-layout-create>
@endsection
