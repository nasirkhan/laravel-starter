import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { fileURLToPath } from 'url';
import { dirname, resolve } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

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
            '~coreui': resolve(__dirname, 'node_modules/@coreui/coreui'),
        }
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'vendor': ['axios', 'jquery'],
                    'coreui': ['@coreui/coreui'],
                    'bootstrap': ['bootstrap'],
                }
            }
        },
        minify: true,
    },
    css: {
        devSourcemap: true
    }
});
