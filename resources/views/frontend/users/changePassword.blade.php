@extends("frontend.layouts.app")

@section("title")
    @lang("Change Password: ")
    {{ $$module_name_singular->name }}
@endsection

@section("content")
    <div class="container mx-auto flex justify-center">
        @include("frontend.includes.messages")
    </div>

    <div class="container mx-auto max-w-7xl px-4 py-10 sm:px-6">
        <div class="mb-10 md:grid md:grid-cols-3 md:gap-6">
            <div class="sm:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-xl font-semibold leading-6 text-gray-800 dark:text-gray-200">
                        @lang("Change Password")
                    </h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        @lang("Use the following form to change your account password!")
                    </p>

                    <div class="pt-4 text-center">
                        <a href="{{ route("frontend.users.profile") }}">
                            <div
                                class="w-full rounded border-2 border-gray-900 px-6 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in hover:bg-gray-800 hover:text-white focus:outline-none dark:border-gray-500"
                            >
                                @lang(" View Profile")
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:col-span-2 md:mt-0">
                {{ html()->form("PATCH", route("frontend.users.changePasswordUpdate"))->class("form-horizontal")->open() }}
                <div class="mb-8 rounded-lg border bg-white p-6 shadow-lg dark:bg-gray-100">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <?php
                            $field_name = "password";
                            $field_lable = __("labels.backend.users.fields." . $field_name);
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("block-inline text-sm font-medium text-gray-700") }}
                            {!! field_required($required) !!}
                            {{ html()->password($field_name)->placeholder($field_placeholder)->class("mt-1 border-gray-300 w-full py-2 px-4 bg-white dark:bg-gray-100 text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent")->attributes(["$required"]) }}
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <?php
                            $field_name = "password_confirmation";
                            $field_lable = __("labels.backend.users.fields." . $field_name);
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>

                            {{ html()->label($field_lable, $field_name)->class("block-inline text-sm font-medium text-gray-700") }}
                            {!! field_required($required) !!}
                            {{ html()->password($field_name)->placeholder($field_placeholder)->class("mt-1 border-gray-300 w-full py-2 px-4 bg-white dark:bg-gray-100 text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent")->attributes(["$required"]) }}
                        </div>
                        <div class="col-span-6 bg-gray-50 px-4 py-3 text-end sm:px-6">
                            <button
                                class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                type="submit"
                            >
                                @lang("Update Password")
                            </button>
                        </div>
                    </div>
                </div>
                {{ html()->closeModelForm() }}
            </div>
        </div>

        <div class="mb-10 mt-10 sm:mt-0">
            <div class="grid grid-cols-1 sm:grid-cols-3 sm:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-800 dark:text-gray-200">
                            @lang("Edit Profile")
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            @lang("Update account information.")
                        </p>
                    </div>
                </div>
                <div class="mt-5 sm:col-span-2 md:mt-0">
                    <div class="mb-8 rounded-lg border bg-white p-6 shadow-lg dark:bg-gray-100">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 text-center">
                                <a href="{{ route("frontend.users.profileEdit") }}">
                                    <div
                                        class="w-full rounded border-2 border-gray-900 px-6 py-2 text-sm font-semibold text-gray-500 transition duration-200 ease-in hover:bg-gray-800 hover:text-white focus:outline-none"
                                    >
                                        @lang("Edit Profile")
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
