@extends("frontend.layouts.app")

@section("title")
    {{ __($module_title) }}
@endsection

@section("content")
    <x-frontend.header-block :title="__('Articles')">
        <p class="mb-8 leading-relaxed">
            We publish articles on a number of topics.
            <br />
            We encourage you to read our posts and let us know your feedback. It would be really help us to move
            forward.
        </p>
    </x-frontend.header-block>

    <section class="bg-white p-6 text-gray-600 dark:bg-gray-700 sm:p-20">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            @foreach ($$module_name as $$module_name_singular)
                @php
                    $details_url = route("frontend.$module_name.show", [
                        encode_id($$module_name_singular->id),
                        $$module_name_singular->slug,
                    ]);
                @endphp

                <x-frontend.card
                    :url="$details_url"
                    :name="$$module_name_singular->name"
                    :image="$$module_name_singular->image"
                >
                    @if ($$module_name_singular->created_by_alias)
                        <div class="my-4 flex flex-row items-center">
                            <img
                                class="h-5 w-5 rounded-full sm:h-8 sm:w-8"
                                src="{{ asset("img/avatars/" . rand(1, 8) . ".jpg") }}"
                                alt="Author profile image"
                            />
                            <h6 class="small mb-0 ml-2 text-sm dark:text-gray-400">
                                {{ $$module_name_singular->created_by_alias }}
                            </h6>
                        </div>
                    @else
                        <div class="my-4 flex flex-row items-center">
                            <img
                                class="h-5 w-5 rounded-full sm:h-8 sm:w-8"
                                src="{{ asset("img/avatars/" . rand(1, 8) . ".jpg") }}"
                                alt=""
                            />

                            <a href="{{ route("frontend.users.profile", $$module_name_singular->created_by) }}">
                                <h6 class="small mb-0 ml-2 text-sm dark:text-gray-400">
                                    {{ $$module_name_singular->created_by_name }}
                                </h6>
                            </a>
                        </div>
                    @endif

                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        {{ $$module_name_singular->intro }}
                    </p>
                    <p>
                        <x-frontend.badge
                            :url="route('frontend.categories.show', [
                                encode_id($$module_name_singular->category_id),
                                $$module_name_singular->category->slug,
                            ])"
                            :text="$$module_name_singular->category_name"
                        />
                    </p>
                    <div class="mt-4">
                        @foreach ($$module_name_singular->tags as $tag)
                            <x-frontend.badge
                                :url="route('frontend.tags.show', [encode_id($tag->id), $tag->slug])"
                                :text="$tag->name"
                            />
                        @endforeach
                    </div>
                </x-frontend.card>
            @endforeach
        </div>
        <div class="d-flex justify-content-center w-100 mt-4">
            {{ $$module_name->links() }}
        </div>
    </section>
@endsection
