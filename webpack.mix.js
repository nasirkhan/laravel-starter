const mix = require('laravel-mix');

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
mix.copy("node_modules/jquery/dist/jquery.min.js", "public/js/jquery.min.js")
    .copy("resources/js/laravel.js", "public/js/laravel.js")
    .copy("node_modules/@fortawesome/fontawesome-free/webfonts/*", "public/webfonts");

/**
 *
 * Backend
 *
 * -----------------------------------------------------------------------------
 */
// backend css
mix.styles([
    "node_modules/@coreui/coreui/dist/css/coreui.min.css",
    "node_modules/@fortawesome/fontawesome-free/css/all.min.css",
    "resources/assets/css/pace.min.css",
    "resources/assets/css/custom-backend.css"
], "public/css/backend.css");

// backend js
mix.scripts([
   "node_modules/jquery/dist/jquery.min.js",
   "node_modules/popper.js/dist/umd/popper.min.js",
   "node_modules/bootstrap/dist/js/bootstrap.min.js",
   "node_modules/pace-progress/pace.min.js",
   "node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js",
   "node_modules/chart.js/dist/Chart.min.js",
   "node_modules/@coreui/coreui/dist/js/coreui.min.js",
   "resources/js/laravel.js",
   "resources/js/custom-backend.js"
], "public/js/backend.js");

/**
 *
 * Frontend
 *
 * -----------------------------------------------------------------------------
 */
// frontend css
mix.styles([
    "public/vendor/now-ui-kit/css/bootstrap.min.css",
    "node_modules/@fortawesome/fontawesome-free/css/all.min.css",
    "public/vendor/iziToast/css/iziToast.min.css",
    "public/vendor/now-ui-kit/css/now-ui-kit.css",
    "resources/css/custom-frontend.css",
], "public/css/frontend.css");

// frontend js
mix.scripts([
   "public/vendor/now-ui-kit/js/core/jquery.min.js",
   "public/vendor/now-ui-kit/js/core/popper.min.js",
   "public/vendor/now-ui-kit/js/core/bootstrap.min.js",
   "public/vendor/iziToast/js/iziToast.min.js",
   "public/vendor/now-ui-kit/js/now-ui-kit.js",
   "resources/js/custom-frontend.js",
], "public/js/frontend.js");

if (mix.inProduction()) {
   mix.version();
}
