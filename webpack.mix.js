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

mix.js('resources/assets/js/cms.js', 'public/js').sourceMaps();
mix.js('resources/assets/js/main.js', 'public/js').sourceMaps();
mix.sass('resources/assets/sass/app.scss', 'public/css');
mix.sass('resources/assets/sass/cms.scss', 'public/css');

mix.disableNotifications();