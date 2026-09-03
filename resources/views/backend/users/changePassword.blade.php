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
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <x-cube::backend-section-header>
                <i class="{{ $module_icon }}"></i>
                {{ __($module_title) }}
                <small class="text-gray-500 dark:text-gray-400">{{ __($module_action) }}</small>

                <x-slot name="toolbar">
                    <x-cube::backend-button-return-back :small="true" />
                </x-slot>
            </x-cube::backend-section-header>

            <div class="flex flex-wrap gap-4 mb-3">
                <div>
                    <strong>@lang("Name"):</strong>
                    {{ $$module_name_singular->name }}
                </div>
                <div>
                    <strong>@lang("Email"):</strong>
                    {{ $$module_name_singular->email }}
                </div>
            </div>

            <div class="mt-4">
                <form method="POST" action="{{ route("backend.users.changePasswordUpdate", $$module_name_singular->id) }}">
                    @csrf
                    @method('PATCH')

                    <x-cube::group name="password" :label="__('labels.backend.users.fields.password')" required>
                        <x-cube::input type="password" name="password" :placeholder="__('labels.backend.users.fields.password')" required />
                    </x-cube::group>

                    <x-cube::group name="password_confirmation" :label="__('labels.backend.users.fields.password_confirmation')" required>
                        <x-cube::input type="password" name="password_confirmation" :placeholder="__('labels.backend.users.fields.password_confirmation')" required />
                    </x-cube::group>

                    <div class="mb-4">
                        <x-cube::backend-button-save />
                    </div>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-3">
            <x-cube::backend-section-footer>
                @lang("Updated")
                : {{ $$module_name_singular->updated_at->diffForHumans() }},
                @lang("Created at")
                : {{ $$module_name_singular->created_at->isoFormat("LLLL") }}
            </x-cube::backend-section-footer>
        </div>
    </div>
@endsection
