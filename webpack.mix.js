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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .copy('node_modules/gentelella/production','resources/views')
   .copy('node_modules/gentelella/build/','public/css/custom')
   .copy('node_modules/fastclick/lib/fastclick.js', 'public/js/fastclick.js')
   .copy('node_modules/nprogress/nprogress.js', 'public/js/nprogress.js')
   .copy('node_modules/flot/jquery.flot.js', 'public/js/float/jquery.flot.js')
   .copy('node_modules/flot/jquery.flot.pie.js', 'public/js/float/jquery.pie.js')
   .copy('node_modules/flot/jquery.flot.time.js', 'public/js/float/jquery.time.js')
   .copy('node_modules/flot/jquery.flot.stack.js', 'public/js/float/jquery.stack.js')
   .copy('node_modules/flot/jquery.flot.resize.js', 'public/js/float/jquery.resize.js');
