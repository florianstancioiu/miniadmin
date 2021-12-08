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

mix
    .js('resources/js/admin.js', 'public/js')
    .js('resources/js/client.js', 'public/js')
    .sass('resources/sass/client.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css')
    .sourceMaps();

// make the bootstrap tooltips work
mix.autoload({
    'jquery': ['$', 'window.jQuery', "jQuery", "window.$", "jquery", "window.jquery"],
    'popper.js/dist/umd/popper.js': ['Popper', 'window.Popper']
});
