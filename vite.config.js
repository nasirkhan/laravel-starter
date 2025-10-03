import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';

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
    resolve: {
        alias: {
            '~coreui': path.resolve(__dirname, 'node_modules/@coreui/coreui'),
        }
    },
    build: {
        // Enable code splitting
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor': ['axios', 'jquery'],
                    'coreui': ['@coreui/coreui'],
                    'bootstrap': ['bootstrap'],
                }
            }
        },
        // Enable minification
        minify: 'esbuild',
    },
    // Enable CSS optimization
    css: {
        devSourcemap: true
    }
});
