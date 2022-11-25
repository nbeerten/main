const mix = require("laravel-mix");
require('laravel-mix-purgecss');

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

mix.js("resources/js/app.js", "js")
   .js("resources/js/prism.js", "js")
   .js("resources/js/pages/TMASigns.js", "js")
   .js("resources/js/pages/home.js", "js")

   .sass("resources/scss/app.scss", "css")
//    .purgeCss({
//         enabled: true,
//         safelist: ['heroicons']
//     })
   .sourceMaps(false, 'source-map')

   .setPublicPath('public/dist/')
   .setResourceRoot('/dist')
   .version();

if (mix.inProduction()) {
    mix.version();
    mix.then(() => {
        const convertToFileHash = require("laravel-mix-make-file-hash");
        convertToFileHash({
        publicPath: "public/dist",
        manifestFilePath: "public/dist/mix-manifest.json"
        });
    });
    };