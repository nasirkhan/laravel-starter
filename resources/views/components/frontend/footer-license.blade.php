@props(["license" => "", "author" => app_name(), "author_url" => app_url()])

<div class="pt-6">
    @switch($license)
        @case("cc-by-sa")
            <div class="flex flex-col items-center justify-center text-center">
                <div>
                    <div class="flex justify-center space-x-6 text-gray-500 hover:text-gray-800">
                        <div>
                            <svg
                                class="icon icon-tabler icons-tabler-outline icon-tabler-creative-commons"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path
                                    d="M10.5 10.5c-.847 -.71 -2.132 -.658 -2.914 .116a1.928 1.928 0 0 0 0 2.768c.782 .774 2.067 .825 2.914 .116"
                                />
                                <path
                                    d="M16.5 10.5c-.847 -.71 -2.132 -.658 -2.914 .116a1.928 1.928 0 0 0 0 2.768c.782 .774 2.067 .825 2.914 .116"
                                />
                            </svg>
                        </div>
                        <div>
                            <svg
                                class="icon icon-tabler icons-tabler-outline icon-tabler-creative-commons-by"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 7m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                <path
                                    d="M9 13v-1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-.5l-.5 4h-2l-.5 -4h-.5a1 1 0 0 1 -1 -1z"
                                />
                            </svg>
                        </div>
                        <div>
                            <svg
                                class="icon icon-tabler icons-tabler-outline icon-tabler-creative-commons-sa"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                <path d="M12 16a4 4 0 1 0 -4 -4v1" />
                                <path d="M6 12l2 2l2 -2" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="text-sm text-gray-500 sm:w-1/2">
                    Except where otherwise noted, content on this site is created by
                    <a class="hover:underline" href="{{ $author_url }}" rel="cc:attributionURL dct:creator">
                        {{ $author }}
                    </a>
                    and licensed under
                    <a class="hover:underline" href="https://creativecommons.org/licenses/by-sa/4.0" target="_blank">
                        Creative Commons Attribution-ShareAlike 4.0 International (CC BY-SA 4.0)
                    </a>
                </div>
            </div>

            @break
        @default
            <div class="flex items-center justify-center text-center">
                <div class="w-1/2 text-sm text-gray-500">
                    &copy; {{ date("Y") }}
                    <a href="{{ $author_url }}" rel="cc:attributionURL dct:creator">{{ $author }}</a>
                    All Right Reserved.
                </div>
            </div>
    @endswitch
</div>
