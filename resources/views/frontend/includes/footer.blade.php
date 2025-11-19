<footer class="bg-gray-100 px-4 py-6 sm:p-20 dark:bg-gray-800" role="contentinfo" aria-label="Site footer">
    <div class="mx-auto max-w-5xl text-center">
        <a
            class="flex items-center justify-center text-2xl font-semibold text-gray-900 dark:text-white"
            href="/"
            wire:navigate
            aria-label="Go to homepage"
        >
            <img class="h-10" src="{{ asset("img/logo-with-text.jpg") }}" alt="{{ app_name() }} Logo" />
        </a>
        <p class="mx-auto my-6 text-gray-500 sm:w-1/2 dark:text-gray-400">
            {!! setting("meta_description") !!}
        </p>
        <x-frontend.dynamic-menu
            location="frontend-footer"
            cssClass="mb-6 flex flex-wrap items-center justify-center text-gray-900 dark:text-white"
        />

        <x-frontend.social.all-social-url />

        <x-frontend.footer-license license="cc-by-sa" />

        <x-frontend.footer-credit />
    </div>
</footer>
