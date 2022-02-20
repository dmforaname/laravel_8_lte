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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();


mix.js(['resources/admin/app.js',
    'resources/admin/assets/js/adminlte.min.js',
    'resources/admin/assets/js/demo.js'], 'public/js/admin')
 .sass('resources/admin/assets/style.scss', 'public/css/admin');     