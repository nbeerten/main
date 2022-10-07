const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js");
mix.js("resources/js/pages/TMASigns.js", "public/js/pages");

mix.sass(
        "resources/scss/app.scss",
        "public/css/app.css"
    )
    .version()
    .sourceMaps(false, 'source-map');