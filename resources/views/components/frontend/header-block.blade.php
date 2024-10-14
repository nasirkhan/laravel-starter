@props(["title" => app_name(), "sub_title" => ""])

<section class="bg-gray-100 py-20 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
    <div class="container mx-auto flex flex-col items-center justify-center px-5">
        <div class="w-full text-center lg:w-2/3">
            {!! $sub_title !!}

            <h1 class="mb-4 text-3xl font-medium text-gray-800 dark:text-gray-200 sm:text-4xl">
                {!! $title !!}
            </h1>

            {!! $slot !!}

            @include("frontend.includes.messages")
        </div>
    </div>
</section>
