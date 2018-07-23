let mix           = require('laravel-mix').mix;
const nodeModules = 'node_modules/';
const themeInfo   = require('./theme.json');


mix.sass('resources/scss/theme.scss', 'assets/css').options(
    {
        processCssUrls: false
    });


/*
 |--------------------------------------------------------------------------
 | Concat
 |--------------------------------------------------------------------------
 |
 */
mix.scripts(['../../Modules/**/admin/compile/js/*.js'], 'assets/js/modules.min.js');
mix.styles(['../../Modules/**/admin/compile/css/*.css'], 'assets/css/modules.min.css');

mix.scripts([
                nodeModules + 'jquery/dist/jquery.min.js',
                nodeModules + 'jquery-ui-dist/jquery-ui.min.js',
                nodeModules + 'popper.js/dist/umd/popper.min.js',
                nodeModules + 'bootstrap/dist/js/bootstrap.min.js',
                nodeModules + 'jquery-slimscroll/jquery.slimscroll.min.js',
                nodeModules + 'jquery.scrollto/jquery.scrollTo.min.js',
                nodeModules + 'jquery.nicescroll/dist/jquery.nicescroll.min.js',
                nodeModules + 'nestable2/dist/jquery.nestable.min.js',
                nodeModules + 'morris.js/morris.min.js',
                nodeModules + 'raphael/raphael.min.js',
                nodeModules + 'datatables.net/js/jquery.dataTables.min.js',
                nodeModules + 'datatables.net-bs4/js/dataTables.bootstrap4.min.js',

                nodeModules + 'pdfjs-dist/build/pdf.min.js',
                nodeModules + 'pdfjs-dist/build/pdf.worker.min.js',

                'resources/js/waves.js',
                'resources/js/app.js'
            ], 'assets/js/libs.min.js');
mix.styles([
               nodeModules + 'jquery-ui-dist/jquery-ui.min.css',
               nodeModules + 'jquery-ui-dist/jquery-ui.theme.min.css',
               nodeModules + 'nestable2/dist/jquery.nestable.min.css',
               nodeModules + 'morris.js/morris.css',
               nodeModules + 'datatables.net-bs4/css/dataTables.bootstrap4.min.css'
           ], 'assets/css/libs.min.css');