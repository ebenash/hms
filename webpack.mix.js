const mix = require('laravel-mix');

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

mix.vue()

/* CSS */
.sass('resources/sass/main.scss', 'public/css/oneui.css')

.sass('resources/sass/oneui/themes/amethyst.scss', 'public/css/themes/')

.sass('resources/sass/oneui/themes/city.scss', 'public/css/themes/')

.sass('resources/sass/oneui/themes/flat.scss', 'public/css/themes/')

.sass('resources/sass/oneui/themes/modern.scss', 'public/css/themes/')

.sass('resources/sass/oneui/themes/smooth.scss', 'public/css/themes/')

.combine([
    'public/css/oneui.css',
    'public/js/plugins/sweetalert2/sweetalert2.min.css'
], 'public/css/oneui.min.css')

/* JS */
// .js('resources/js/app.js', 'public/js/laravel.app.js')
.js('resources/js/oneui/app.js', 'public/js/oneui.app.js')

.combine([
    'public/js/oneui.app.js',
    'public/js/plugins/sweetalert2/sweetalert2.min.js',
    // 'public/js/laravel.app.js',
], 'public/js/oneui.min.js')

/* Page JS */
.js('resources/js/pages/tables_datatables.js', 'public/js/pages/tables_datatables.js')

/* Tools */
.browserSync('localhost:8000')
    .disableNotifications()

/* Options */
.options({
    processCssUrls: false
});
