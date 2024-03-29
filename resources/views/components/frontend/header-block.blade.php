@props(["title"=>app_name()])

<section class="bg-gray-50 dark:bg-gray-900 border">
    <div class="py-8 px-4 mx-auto max-w-screen-xl text-center sm:py-16 sm:px-12 sm:pt-20">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none  md:text-5xl lg:text-6xl dark:text-white">
            {!! $title !!}
        </h1>

        {!! $slot !!}

        @include('frontend.includes.messages')
    </div>
</section>
