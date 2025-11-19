@extends("frontend.layouts.app")

@section("title")
    {{ $$module_name_singular->name }} - {{ __($module_title) }}
@endsection

@section("content")
    <x-frontend.header-block :title="__($$module_name_singular->name)">
        <x-slot:sub_title>
            <p class="mb-8 leading-relaxed">
                <a
                    class="mr-2 rounded bg-gray-200 px-3 py-1 text-sm font-semibold text-gray-800 outline outline-1 outline-gray-800 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
                    href="{{ route("frontend." . $module_name . ".index") }}"
                >
                    {{ __($module_title) }}
                </a>
            </p>
        </x-slot>

        <p class="mb-8 leading-relaxed">
            {{ $$module_name_singular->description }}
        </p>
    </x-frontend.header-block>

    <section class="bg-white p-6 text-gray-600 dark:bg-gray-700 dark:text-gray-300 sm:p-20">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-1">
            <div class="text-center">
                {{ $$module_name_singular->description }}
            </div>
        </div>
    </section>
@endsection
