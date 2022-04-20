const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ]
    );

    
/**
 *
 * Copy Assets
 *
 * -----------------------------------------------------------------------------
 */
// jquery and icon fonts
mix.copy("node_modules/jquery/dist/jquery.min.js", "public/js/jquery.min.js")
    .copy("node_modules/@fortawesome/fontawesome-free/webfonts/*", "public/webfonts")
    .copy('node_modules/@coreui/icons/fonts', 'public/fonts')
    .copy('node_modules/@coreui/icons/sprites', 'public/fonts');


/**
 *
 * Frontend
 *
 * -----------------------------------------------------------------------------
 */
mix.js('resources/js/frontend.js', 'public/js')
    .postCss('resources/css/frontend.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ]
    );


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
        "node_modules/@fortawesome/fontawesome-free/css/all.min.css",
        "node_modules/@coreui/icons/css/all.css",
        "node_modules/simplebar/dist/simplebar.css",
        // "resources/vendors/coreui/dist/css/style.min.css",
        "public/css/backend-theme.css",
    ],
    "public/css/backend.css"
);

// Backend JS
mix.scripts(
    [
        "node_modules/jquery/dist/jquery.min.js",
        // "node_modules/bootstrap/dist/js/bootstrap.min.js",
        "node_modules/@coreui/coreui/dist/js/coreui.bundle.js",
        "node_modules/simplebar/dist/simplebar.min.js",
        // "node_modules/@coreui/utils/dist/coreui-utils.js",
        "resources/js/laravel.js",
        "resources/js/backend-custom.js"
    ],
    "public/js/backend.js"
);


if (mix.inProduction()) {
    mix.version();
}
