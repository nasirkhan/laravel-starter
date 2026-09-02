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
                    <strong>
                        @lang("Name")
                        :
                    </strong>
                    {{ $$module_name_singular->name }}
                </div>
                <div>
                    <strong>
                        @lang("Email")
                        :
                    </strong>
                    {{ $$module_name_singular->email }}
                </div>
            </div>

            <div class="mt-4">
                {{ html()->form("PATCH", route("backend.users.changePasswordUpdate", $$module_name_singular->id))->open() }}

                <div class="mb-4">
                    {{ html()->label(__("labels.backend.users.fields.password"))->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->for("password")->id("password-label") }}
                    {{ html()->password("password")->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->placeholder(__("labels.backend.users.fields.password"))->required()->attributes(["aria-labelledby" => "password-label"]) }}
                </div>

                <div class="mb-4">
                    {{ html()->label(__("labels.backend.users.fields.password_confirmation"))->class("block mb-2 text-sm font-medium text-gray-900 dark:text-white")->for("password_confirmation")->id("password_confirmation-label") }}
                    {{ html()->password("password_confirmation")->class("block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500")->placeholder(__("labels.backend.users.fields.password_confirmation"))->required()->attributes(["aria-labelledby" => "password_confirmation-label"]) }}
                </div>

                <div class="mb-4">
                    {{ html()->button($text = "<i class='fas fa-save'></i> Save", $type = "submit")->class("inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700") }}
                </div>

                {{ html()->closeModelForm() }}
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
