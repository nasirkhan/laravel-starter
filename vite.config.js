import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import react from '@vitejs/plugin-react';
// import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
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
        // react(),
        // vue({
        //     template: {
        //         transformAssetUrls: {
        //             base: null,
        //             includeAbsolute: false,
        //         },
        //     },
        // }),
    ]
});