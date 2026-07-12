import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                'resources/css/app-frontend.css',
                'resources/js/app-frontend.js',

                'resources/sass/app-backend.scss',
                'resources/js/app-backend.js',
            ],
            refresh: [
                'app/View/Components/**',
                'lang/**',
                'resources/lang/**',
                'resources/views/**',
                'resources/routes/**',
                'routes/**',
                'Modules/**/Resources/lang/**',
                'Modules/**/Resources/views/**/*.blade.php',
            ],
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                // Assign each vendor package to its own named chunk so that
                // shared deps (e.g. @popperjs/core used by both flowbite and
                // @coreui) are never placed inside an entry-point bundle.
                // Without this Rollup uses an entry chunk as the shared chunk,
                // which makes the manifest cross-link app-backend into
                // app-frontend and executes backend code on every page.
                manualChunks(id) {
                    if (id.includes('node_modules')) {
                        const match = id.match(/node_modules\/((?:@[^/]+\/)?[^/]+)/);
                        const pkg = match ? match[1] : 'vendor';
                        return `vendor/${pkg.replace('@', '').replace('/', '-')}`;
                    }
                },
            },
        },
    },
});
