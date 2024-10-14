<div>
    <div class="container mx-auto flex w-full flex-col items-center justify-center">
        <div
            class="mb-2 w-full rounded-md border bg-white px-4 py-5 shadow dark:bg-gray-600 dark:text-gray-300 sm:px-6"
        >
            <h3 class="text-lg font-medium leading-6 text-gray-800 dark:text-gray-200">
                @lang("Recent Posts")
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-200">Recently published articles!</p>
        </div>
        <ul class="flex w-full flex-col">
            @foreach ($recentPosts as $row)
                @php
                    $details_url = route("frontend.posts.show", [encode_id($row->id), $row->slug]);
                @endphp

                <li class="mb-2 flex flex-row border-gray-400">
                    <div
                        class="flex flex-1 transform cursor-pointer select-none items-center justify-between rounded-md bg-white p-4 shadow transition duration-500 ease-in-out hover:-translate-y-1 hover:shadow-lg dark:bg-gray-600 dark:text-gray-300"
                    >
                        <div class="flex">
                            <div class="mr-4 flex h-10 flex-col items-center justify-center">
                                <a class="relative block" href="{{ $details_url }}">
                                    <img
                                        class="mx-auto h-10 rounded object-cover"
                                        src="{{ $row->image }}"
                                        alt="{{ $row->name }}"
                                    />
                                </a>
                            </div>
                            <div class="pl-1">
                                <div class="font-medium">
                                    <a href="{{ $details_url }}">
                                        {{ $row->name }}
                                    </a>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-200">
                                    {{ isset($row->created_by_alias) ? $row->created_by_alias : $row->created_by_name }}
                                </div>
                            </div>
                        </div>
                        <button class="flex w-6 justify-end text-right">
                            <svg
                                class="text-gray-500 hover:text-gray-800 dark:text-gray-200"
                                width="12"
                                fill="currentColor"
                                height="12"
                                viewBox="0 0 1792 1792"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M1363 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45l166-166q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z"
                                ></path>
                            </svg>
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
