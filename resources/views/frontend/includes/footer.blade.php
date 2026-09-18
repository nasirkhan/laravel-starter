<footer class="border-t border-gray-200 bg-gray-50 px-4 py-12 sm:px-8 sm:py-16 dark:border-gray-700 dark:bg-gray-900" role="contentinfo" aria-label="Site footer">
    <div class="mx-auto max-w-7xl text-center">
        <a
            class="flex items-center justify-center"
            href="/"
            wire:navigate
            aria-label="Go to homepage"
        >
            <img class="h-10 rounded" src="{{ asset("img/logo-with-text.jpg") }}" alt="{{ app_name() }} Logo" />
        </a>
        <p class="mx-auto my-6 text-gray-500 sm:w-1/2 dark:text-gray-400">
            {!! setting("meta_description") !!}
        </p>
        <x-menu-dynamic-menu
            location="frontend-footer"
            css-class="mb-6 flex flex-wrap items-center justify-center text-gray-900 dark:text-white"
        />

        @if (setting("show_footer_social_profiles"))
        <x-cube::social.links
            class="my-6"
            :website="setting('website_url')"
            :instagram="setting('instagram_url')"
            :facebook="setting('facebook_url')"
            :twitter="setting('twitter_url')"
            :youtube="setting('youtube_url')"
            :whatsapp="setting('whatsapp_url')"
        />
        @endif

        @if (setting("show_license"))
        <x-cube::footer-license license="cc-by-sa" :author="app_name()" :author-url="app_url()" />
        @endif

        @if (setting("show_credit"))
        <x-cube::footer-credit :text="setting('footer_text')" />
        @endif

        <div class="mx-auto mt-8 max-w-7xl border-t border-gray-200 pt-6 text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
            &copy; {{ now()->year }} {{ app_name() }}. {{ __('All rights reserved.') }}
        </div>
    </div>
</footer>
