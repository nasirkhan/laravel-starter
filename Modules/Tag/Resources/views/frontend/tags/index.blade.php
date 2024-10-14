@extends("frontend.layouts.app")

@section("title")
    {{ __($module_title) }}
@endsection

@section("content")
    <x-frontend.header-block :title="__($module_title)">
        <p class="mb-8 leading-relaxed">The list of {{ __($module_name) }}.</p>
    </x-frontend.header-block>

    <section class="bg-white p-6 text-gray-600 dark:bg-gray-700 sm:p-20">
        <div class="grid grid-cols-2 gap-6 sm:grid-cols-3">
            @foreach ($$module_name as $$module_name_singular)
                @php
                    $details_url = route("frontend.$module_name.show", [
                        encode_id($$module_name_singular->id),
                        $$module_name_singular->slug,
                    ]);
                @endphp

                <x-frontend.card :url="$details_url" :name="$$module_name_singular->name">
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        {{ $$module_name_singular->description }}
                    </p>
                </x-frontend.card>
            @endforeach
        </div>
        <div class="d-flex justify-content-center w-100 mt-3">
            {{ $$module_name->links() }}
        </div>
    </section>
@endsection
