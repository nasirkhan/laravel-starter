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
        <x-menu-dynamic-menu
            location="frontend-footer"
            css-class="mb-6 flex flex-wrap items-center justify-center text-gray-900 dark:text-white"
        />

        <x-cube::social.links
            class="my-6"
            :website="setting('website_url')"
            :instagram="setting('instagram_url')"
            :facebook="setting('facebook_url')"
            :twitter="setting('twitter_url')"
            :youtube="setting('youtube_url')"
            :whatsapp="setting('whatsapp_url')"
        />

        <x-cube::footer-license license="cc-by-sa" :author="app_name()" :author-url="app_url()" />

        <x-cube::footer-credit :text="setting('footer_text')" />
    </div>
</footer>
