let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// copy assets
mix.copy('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js')
    .copy('resources/assets/js/laravel.js', 'public/js/laravel.js');

// build frontend css
mix.styles([
    'resources/assets/coreui/css/style.min.css',
    'resources/assets/coreui/css/custom.css'
], 'public/css/app_frontend.css');

// build frontend js
mix.scripts([
   'node_modules/jquery/dist/jquery.min.js',
   'node_modules/popper.js/dist/umd/popper.min.js',
   'node_modules/bootstrap/dist/js/bootstrap.min.js',
   'node_modules/pace-progress/pace.min.js',
   'node_modules/chart.js/dist/Chart.min.js',
   'resources/assets/js/laravel.js',
   'resources/assets/coreui/js/app.js'
], 'public/js/app_frontend.js').version();


// build backend css
mix.styles([
    'resources/assets/coreui/css/style.min.css',
    'resources/assets/coreui/css/custom.css'
], 'public/css/app_backend.css');

// build backend js
mix.scripts([
   'node_modules/jquery/dist/jquery.min.js',
   'node_modules/popper.js/dist/umd/popper.min.js',
   'node_modules/bootstrap/dist/js/bootstrap.min.js',
   'node_modules/pace-progress/pace.min.js',
   'node_modules/chart.js/dist/Chart.min.js',
   'resources/assets/js/laravel.js',
   'resources/assets/coreui/js/app.js'
], 'public/js/app_backend.js').version();


if (mix.inProduction()) {
   mix.version();
}
