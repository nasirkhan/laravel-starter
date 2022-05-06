<div>
    <div class="container flex flex-col mx-auto w-full items-center justify-center">
        <div class="px-4 py-5 sm:px-6 w-full border bg-white shadow mb-2 rounded-md">
            <h3 class="text-lg leading-6 font-medium text-gray-800">
                @lang('Recent Posts')
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Recently published articles!
            </p>
        </div>
        <ul class="flex flex-col">
            @foreach ($recentPosts as $row)
            @php
            $details_url = route("frontend.posts.show",[encode_id($row->id), $row->slug]);
            @endphp
            <li class="border-gray-400 flex flex-row mb-2">
                <div class="transition duration-500 shadow ease-in-out transform hover:-translate-y-1 hover:shadow-lg select-none cursor-pointer bg-white rounded-md flex flex-1 items-center p-4">
                    <div class="flex flex-col h-10 justify-center items-center mr-4">
                        <a href="{{$details_url}}" class="block relative">
                            <img alt="{{ $row->name }}" src="{{$row->featured_image}}" class="mx-auto object-cover rounded h-10 " />
                        </a>
                    </div>
                    <div class=" pl-1">
                        <div class="font-medium">
                            <a href="{{$details_url}}">
                                {{ $row->name }}
                            </a>
                        </div>
                        <div class="text-gray-600 text-sm">
                            {{isset($row->created_by_alias)? $row->created_by_alias : $row->created_by_name}}
                        </div>
                    </div>
                    <button class="w-24 text-right flex justify-end">
                        <svg width="12" fill="currentColor" height="12" class="hover:text-gray-800 text-gray-500" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1363 877l-742 742q-19 19-45 19t-45-19l-166-166q-19-19-19-45t19-45l531-531-531-531q-19-19-19-45t19-45l166-166q19-19 45-19t45 19l742 742q19 19 19 45t-19 45z">
                            </path>
                        </svg>
                    </button>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>