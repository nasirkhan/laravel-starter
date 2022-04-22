@extends('frontend.layouts.app')

@section('title') {{$$module_name_singular->name}}'s Profile @endsection

@section('content')

<div class="container mx-auto flex justify-center">

    @include('frontend.includes.messages')

</div>
<div class="container max-w-7xl mx-auto px-4 sm:px-6 py-10">
    <div class="mb-10 md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-800">@lang('Profile')</h3>
                <p class="mt-1 text-sm text-gray-600">
                    This information will be displayed publicly so be careful what you share.
                </p>
                <p class="pt-4">
                    <a href="{{ route("frontend.users.profile", encode_id($$module_name_singular->id)) }}">
                        <div class="w-full text-center px-6 py-2 transition ease-in duration-200 rounded text-gray-500 hover:bg-gray-800 hover:text-white border-2 border-gray-900 focus:outline-none">
                            @lang('View Profile')
                        </div>
                    </a>
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            {{ html()->modelForm($userprofile, 'PATCH', route('frontend.users.profileUpdate', encode_id($$module_name_singular->id)))->acceptsFiles()->open() }}
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <?php
                            $field_name = 'first_name';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <?php
                            $field_name = 'last_name';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "required";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                        </div>

                        <div class="col-span-6">
                            <?php
                            $field_name = 'bio';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                        </div>

                        <div class="col-span-6">
                            <?php
                            $field_name = 'address';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                        </div>

                        <div class="col-span-6">
                            <?php
                            $field_name = 'url_website';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <?php
                            $field_name = 'url_facebook';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <?php
                            $field_name = 'url_twitter';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <?php
                            $field_name = 'url_linkedin';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <?php
                            $field_name = 'url_instagram';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6 sm:col-span-2">

                            <label class="block text-sm font-medium text-gray-700">
                                Photo
                            </label>

                            <span class="mt-1 inline-block h-24 w-24 object-cover rounded overflow-hidden bg-gray-100">
                                <img src="{{asset($user->avatar)}}" alt="{{$user->name}}">


                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                        </div>

                        <div class="col-span-6 sm:col-span-4">

                            <div class="sm:pt-6">
                                <input class="border-gray-300 focus:ring-blue-600 block w-full overflow-hidden cursor-pointer border text-gray-800 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:border-transparent" aria-describedby="avatar" id="avatar" name="avatar" type="file">
                            </div>
                            <div class="mt-1 text-sm text-gray-400" id="view_model_avatar_help">
                                Upload an image as profile picture.
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-10 md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-800">Personal Info</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Information of this block will not be displayed publicly.
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <!-- {{ html()->modelForm($userprofile, 'PATCH', route('frontend.users.profileUpdate', $$module_name_singular->id))->acceptsFiles()->open() }} -->
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <label class="block-inline text-sm font-medium text-gray-700" for="first_name">Email</label> <span class="text-danger text-red-600">*</span>
                            <input class="mt-1 border-gray-300 w-full py-2 px-4 bg-gray-200 text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" type="email" id="email" value="{{$user->email}}" disabled>
                        </div>

                        <div class="col-span-6">
                            <?php
                            $field_name = 'mobile';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <?php
                            $field_name = 'date_of_birth';
                            $field_lable = label_case($field_name);
                            $field_placeholder = $field_lable;
                            $required = "";
                            $value = ($user->date_of_birth == "") ? "" : \Carbon\Carbon::parse($user->date_of_birth)->toDateString();
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block-inline text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->text($field_name)->type('date')->value($value)->placeholder($field_placeholder)->class('mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent')->attributes(["$required"]) }}
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <?php
                            $field_name = 'gender';
                            $field_lable = label_case($field_name);
                            $field_placeholder = "-- Select an option --";
                            $required = "";
                            $select_options = [
                                'Female' => 'Female',
                                'Male' => 'Male',
                                'Other' => 'Other',
                            ];
                            ?>
                            {{ html()->label($field_lable, $field_name)->class('block text-sm font-medium text-gray-700') }} {!! fielf_required($required) !!}
                            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm')->attributes(["$required"]) }}
                        </div>

                        <!-- <div class="col-span-6 sm:col-span-3">
                            <label for="country" class="block-inline text-sm font-medium text-gray-700">Country / Region</label>
                            <select id="country" name="country" autocomplete="country" class="mt-1 border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-300 rounded border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                                <option>United States</option>
                                <option>Canada</option>
                                <option>Mexico</option>
                            </select>
                        </div> -->

                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-end sm:px-6">
                    <button type="submit" class="inline-flex w-full justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Save
                    </button>
                </div>
            </div>
            {{ html()->closeModelForm() }}
        </div>
    </div>

    <div class=" hidden sm:block" aria-hidden="true">
        <div class="py-5">
            <div class="border-t border-gray-200"></div>
        </div>
    </div>

    <div class="mb-10 mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-800">Account Settings</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Update account information.
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 text-center">
                                <a href="{{ route('frontend.users.changePassword', encode_id($$module_name_singular->id)) }}">
                                    <div class="w-full text-sm px-6 py-2 transition ease-in duration-200 rounded text-gray-500 hover:bg-gray-800 hover:text-white border-2 border-gray-900 focus:outline-none">
                                        Chnage Password
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection