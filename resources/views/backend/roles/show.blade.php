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
    <x-cube::backend-layout-show :data="$$module_name_singular">
        <x-cube::backend-section-header>
            <i class="{{ $module_icon }} fa-fw"></i>
            {{ $$module_name_singular->name }}
            <small class="text-gray-500 dark:text-gray-400">{{ __($module_title) }}</small>

            <x-slot name="toolbar">
                <x-cube::backend-button-return-back :small="true" />
                <x-cube::backend-button-edit
                    class="ml-1"
                    title="{{ __('Edit') }} {{ ucwords(Str::singular($module_name)) }}"
                    route='{!! route("backend.$module_name.edit", $$module_name_singular) !!}'
                    :small="true"
                />
            </x-slot>
        </x-cube::backend-section-header>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="w-full sm:w-1/2">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                        <tr>
                            <th class="px-4 py-3">{{ __("labels.backend.$module_name.fields.name") }}</th>
                            <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">{{ $$module_name_singular->name }}</td>
                        </tr>

                        <tr>
                            <th class="px-4 py-3">{{ __("labels.backend.$module_name.fields.permissions") }}</th>
                            <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                @if ($$module_name_singular->permissions()->count() > 0)
                                    <ul>
                                        @foreach ($$module_name_singular->permissions as $permission)
                                            <li>{{ $permission->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="px-4 py-3">{{ __("labels.backend.$module_name.fields.created_at") }}</th>
                            <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                {{ $$module_name_singular->created_at }}
                                <br />
                                <small>({{ $$module_name_singular->created_at->diffForHumans() }})</small>
                            </td>
                        </tr>

                        <tr>
                            <th class="px-4 py-3">{{ __("labels.backend.$module_name.fields.updated_at") }}</th>
                            <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                {{ $$module_name_singular->updated_at }}
                                <br />
                                <small>({{ $$module_name_singular->updated_at->diffForHumans() }})</small>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="w-full sm:w-1/2">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                        <thead>
                            <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <th class="px-4 py-3">
                                    List of users (
                                    <small>Total: {{ $users->count() }}</small>
                                    )
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                        <a href="{{ route("backend.users.show", $user->id) }}">{{ $user->name }}</a>
                                        <span class="float-right">{!! $user->status_label !!}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-cube::backend-layout-show>
@endsection
