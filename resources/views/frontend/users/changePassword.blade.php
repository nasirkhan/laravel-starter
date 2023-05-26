@extends('frontend.layouts.app')

@section('title') @lang("Change Password: ") {{$$module_name_singular->name}} @endsection

@section('content')

<div class="container mx-auto flex justify-center">

    @include('frontend.includes.messages')

</div>

<div class="container max-w-7xl mx-auto px-4 sm:px-6 py-10">
    <div class="mb-10 md:grid md:grid-cols-3 md:gap-6">
        <div class="sm:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-xl font-semibold leading-6 text-gray-800">@lang('Change Password')</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Use the following form to change your account password!
                </p>

                <div class="pt-4 text-center">
                    <a href='{{ route("frontend.users.profile", encode_id($$module_name_singular->id)) }}'>
                        <div class="w-full font-semibold text-sm px-6 py-2 transition ease-in duration-200 rounded text-gray-500 hover:bg-gray-800 hover:text-white border-2 border-gray-900 focus:outline-none">
                            @lang(' View Profile')
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-5 md:mt-0 sm:col-span-2">
            {{ html()->form('PATCH', route('frontend.users.changePasswordUpdate', encode_id($$module_name_singular->id)))->class('form-horizontal')->open() }}
            <div class="mb-8 p-6 bg-white border shadow-lg rounded-lg">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <?php
                        $field_name = 'password';
                        $field_lable = __('labels.backend.users.fields.' . $field_name);
                        $field_placeholder = $field_lable;
                        $required = "required";
                        ?>
                        {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                        {{ html()->password($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <?php
                        $field_name = 'password_confirmation';
                        $field_lable = __('labels.backend.users.fields.' . $field_name);
                        $field_placeholder = $field_lable;
                        $required = "required";
                        ?>
                        {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                        {{ html()->password($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                    </div>
                    <div class="col-span-6 px-4 py-3 bg-gray-50 text-end sm:px-6">
                        <button type="submit" class="inline-flex w-full justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            @lang('Update Password')
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
                    <h3 class="text-lg font-medium leading-6 text-gray-800">Edit Profile</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Update account information.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 sm:col-span-2">
                <div class="mb-8 p-6 bg-white border shadow-lg rounded-lg">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 text-center">
                            <a href="{{ route('frontend.users.profileEdit', encode_id($$module_name_singular->id)) }}">
                                <div class="w-full font-semibold text-sm px-6 py-2 transition ease-in duration-200 rounded text-gray-500 hover:bg-gray-800 hover:text-white border-2 border-gray-900 focus:outline-none">
                                    Edit Profile
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