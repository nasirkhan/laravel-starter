@extends("backend.layouts.app")

@section("title")
    {{ __($module_action) }} {{ __($module_title) }}
@endsection

@section("breadcrumbs")
    <x-cube::backend-breadcrumbs>
        <x-cube::backend-breadcrumb-item type="active" icon="{{ $module_icon }}">
            {{ __($module_title) }}
        </x-cube::backend-breadcrumb-item>
    </x-cube::backend-breadcrumbs>
@endsection

@section("content")
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
        <div class="p-6">
            <x-cube::backend-section-header>
                <i class="{{ $module_icon }}"></i>
                {{ __($module_title) }}
                @if ($unread_notifications_count)
                    (
                    @lang(":count unread", ["count" => $unread_notifications_count])
                    )
                @endif

                <small class="text-gray-500 dark:text-gray-400">{{ __($module_action) }}</small>

                <x-slot name="toolbar">
                    <a
                        href="{{ route("backend.$module_name.markAllAsRead") }}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-700 border border-green-700 rounded-lg hover:bg-green-50 dark:border-green-400 dark:text-green-400 m-1"
                        title="@lang("Mark all as read")"
                    >
                        <i class="fas fa-check-square"></i>
                        @lang("Mark all as read")
                    </a>
                    <a
                        href="{{ route("backend.$module_name.deleteAll") }}"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 border border-red-700 rounded-lg hover:bg-red-50 dark:border-red-400 dark:text-red-400 m-1"
                        data-method="DELETE"
                        data-token="{{ csrf_token() }}"
                        title="@lang("Delete all notifications")"
                    >
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </x-slot>
            </x-cube::backend-section-header>

            <div class="overflow-x-auto">
                <table id="datatable" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                    <thead>
                        <tr class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <th class="px-4 py-3">
                                @lang("Text")
                            </th>
                            <th class="px-4 py-3">
                                @lang("Module")
                            </th>
                            <th class="px-4 py-3">
                                @lang("Updated At")
                            </th>
                            <th class="px-4 py-3 text-end">
                                @lang("Action")
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($$module_name as $module_name_singular)
                            <?php
                            $row_class = "";
                            $span_class = "";
                            if ($module_name_singular->read_at == "") {
                                $row_class = "bg-blue-50 dark:bg-blue-900/20";
                                $span_class = "font-bold";
                            }
                            ?>

                            <tr class="{{ $row_class }}">
                                <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <a href="{{ route("backend.$module_name.show", $module_name_singular->id) }}">
                                        <span class="{{ $span_class }}">
                                            {{ $module_name_singular->data["title"] ?? $module_name_singular->data["module"] ?? $module_name_singular->data["message"] ?? __("Notification") }}
                                        </span>
                                    </a>
                                </td>
                                <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    {{ $module_name_singular->data["module"] ?? __("Notification") }}
                                </td>
                                <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    {{ $module_name_singular->updated_at->diffForHumans() }}
                                </td>
                                <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 text-end">
                                    <a
                                        href="{!! route("backend.$module_name.show", $module_name_singular) !!}"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 m-0.5"
                                        title="@lang("Show") {{ ucwords(Str::singular($module_name)) }}"
                                    >
                                        <i class="fas fa-tv"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-3">
            <div class="flex items-center justify-between">
                <div>
                    @lang("Total")
                    {{ $$module_name->total() }} {{ ucwords($module_name) }}
                </div>
                <div class="float-right">
                    {!! $$module_name->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
