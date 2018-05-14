var mix         = require('laravel-mix'),
    nodeModules = 'node_modules/';


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

// mix.js('resources/assets/js/app.js', 'public/js');
// mix.sass('resources/assets/sass/app.scss', 'public/css');

// mix.sass('Themes/**/assets/scss/theme.scss', 'Themes/**/assets/css');

mix.sass('Themes/fonik/assets/scss/theme.scss', 'Themes/fonik/assets/css').version().options({
                                                                                                 processCssUrls: false
                                                                                             });


/*
 |--------------------------------------------------------------------------
 | Modules admin
 |--------------------------------------------------------------------------
 |
 */
mix.scripts([
                nodeModules + 'jquery/dist/jquery.min.js',
                nodeModules + 'jquery-ui-dist/jquery-ui.min.js',
                nodeModules + 'pdfjs-dist/build/pdf.min.js',
                nodeModules + 'pdfjs-dist/build/pdf.worker.min.js'
            ], 'public/admin/js/libs.min.js');
mix.styles([
               nodeModules + 'jquery-ui-dist/jquery-ui.min.css',
               nodeModules + 'jquery-ui-dist/jquery-ui.theme.min.css'
           ], 'public/admin/css/libs.min.css');

