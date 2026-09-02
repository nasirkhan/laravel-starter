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
                    <a
                        href="{{ route("backend.$module_name.index") }}"
                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-800 m-0.5"
                        title="{{ __(ucwords($module_name)) }} List"
                    >
                        <i class="fas fa-list"></i>
                        List
                    </a>
                </x-slot>
            </x-cube::backend-section-header>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                    <?php $data = json_decode($$module_name_singular->data); ?>

                    <tbody>
                        <tr>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">
                                {{ $data->title }}
                            </th>
                        </tr>
                        <tr>
                            <th class="px-4 py-3">Text</th>
                            <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                {!! $data->text !!}
                            </td>
                        </tr>
                        @if ($data->url_backend != "")
                            <tr>
                                <th class="px-4 py-3">URL Backend</th>
                                <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    Backend:
                                    <a href="{{ $data->url_backend }}">{{ $data->url_backend }}</a>
                                </td>
                            </tr>
                        @endif

                        @if ($data->url_frontend != "")
                            <tr>
                                <th class="px-4 py-3">URL Frontend</th>
                                <td class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    Frontend:
                                    <a href="{{ $data->url_frontend }}">{{ $data->url_frontend }}</a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-3">
            <small class="text-gray-500 dark:text-gray-400 float-right">
                Updated: {{ $$module_name_singular->updated_at->diffForHumans() }}, Created at:
                {{ $$module_name_singular->created_at->isoFormat("LLLL") }}
            </small>
        </div>
    </div>
@endsection
