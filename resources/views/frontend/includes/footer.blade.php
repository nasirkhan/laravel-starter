<footer class="bg-gray-100 p-4 dark:bg-gray-800 sm:p-20">
    <div class="mx-auto max-w-screen-xl text-center">
        <a class="flex items-center justify-center text-2xl font-semibold text-gray-900 dark:text-white" href="#">
            <img class="h-10" src="{{ asset('img/logo-with-text.jpg') }}" alt="{{ app_name() }} Logo" />
        </a>
        <p class="mx-auto my-6 text-gray-500 dark:text-gray-400 sm:w-1/2">
            {!! setting('meta_description') !!}
        </p>
        <ul class="mb-6 flex flex-wrap items-center justify-center text-gray-900 dark:text-white">
            <li>
                <a class="mr-4 hover:underline md:mr-6" href="#">About</a>
            </li>
            <li>
                <a class="mr-4 hover:underline md:mr-6" href="#">Blog</a>
            </li>
            <li>
                <a class="mr-4 hover:underline md:mr-6" href="{{ route('privacy') }}" wire:navigate.hover>Privacy</a>
            </li>
            <li>
                <a class="mr-4 hover:underline md:mr-6" href="{{ route('terms') }}" wire:navigate.hover>Terms</a>
            </li>
            <li>
                <a class="mr-4 hover:underline md:mr-6" href="#">FAQs</a>
            </li>
            <li>
                <a class="mr-4 hover:underline md:mr-6" href="#">Contact</a>
            </li>
        </ul>

        <x-frontend.social.all-social-url />

        <x-frontend.footer-license license='cc-by-sa' />

        <x-frontend.footer-credit />
    </div>
</footer>
