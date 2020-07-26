const mix = require('laravel-mix');

/**
 *
 * Copy Assets
 *
 * -----------------------------------------------------------------------------
 */
// jquery and icon fonts
mix.copy("node_modules/jquery/dist/jquery.min.js", "public/js/jquery.min.js")
    .copy("node_modules/@fortawesome/fontawesome-free/webfonts/*", "public/webfonts")
    .copy('node_modules/@coreui/icons/fonts', 'public/fonts');

/**
 *
 * Backend
 *
 * -----------------------------------------------------------------------------
 */
// Build Backend SASS
mix.sass("resources/sass/backend.scss", "public/css/backend-theme.css");

// Backend CSS
mix.styles(
    [
        "public/css/backend-theme.css",
        "node_modules/@coreui/icons/css/all.css",
        "node_modules/@fortawesome/fontawesome-free/css/all.min.css",
        "resources/assets/css/custom-backend.css"
    ],
    "public/css/backend.css"
);

// Backend JS
mix.scripts(
    [
        "node_modules/jquery/dist/jquery.min.js",
        "node_modules/bootstrap/dist/js/bootstrap.min.js",
        "node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js",
        "node_modules/@coreui/coreui/dist/js/coreui.bundle.js",
        "resources/js/laravel.js",
        "resources/js/custom-backend.js"
    ],
    "public/js/backend.js"
);

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
