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

// mix.js('resources/assets/js/app_backend.js', 'public/js')
//    .sass('resources/assets/sass/app_backend.scss', 'public/css')
//    .copy('resources/assets/fontawesome/js/fontawesome-all.min.js', 'public/js/fontawesome-all.min.js')
//    .copy('resources/assets/now-ui-dashboard/js/core/jquery.min.js', 'public/js/jquery.min.js');

// copy assets
mix.copy('resources/assets/fontawesome/js/fontawesome-all.min.js', 'public/js/fontawesome-all.min.js')
   .copy('resources/assets/now-ui-dashboard/js/core/jquery.min.js', 'public/js/jquery.min.js');

// build backend css
mix.sass('resources/assets/sass/app_backend.scss', 'public/css');

// build backend js
mix.scripts([
   'resources/assets/now-ui-dashboard/js/core/jquery.min.js',
   'resources/assets/now-ui-dashboard/js/core/popper.min.js',
   'resources/assets/now-ui-dashboard/js/core/bootstrap.min.js',
   'resources/assets/now-ui-dashboard/js/plugins/perfect-scrollbar.jquery.min.js',
   'resources/assets/now-ui-dashboard/js/plugins/chartjs.min.js',
   'resources/assets/now-ui-dashboard/js/plugins/bootstrap-notify.js',
   'resources/assets/now-ui-dashboard/js/plugins/bootstrap-switch.js',
   'resources/assets/now-ui-dashboard/js/now-ui-dashboard-pro.min.js'
], 'public/js/app_backend.js');

if (mix.inProduction()) {
   mix.version();
}
