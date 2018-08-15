let mix           = require('laravel-mix').mix;
const NODEMODULES = 'node_modules/';


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
                NODEMODULES + 'jquery/dist/jquery.min.js',
                NODEMODULES + 'jquery-ui-dist/jquery-ui.min.js',
                NODEMODULES + 'popper.js/dist/umd/popper.min.js',
                NODEMODULES + 'bootstrap/dist/js/bootstrap.min.js',
                NODEMODULES + 'jquery-slimscroll/jquery.slimscroll.min.js',
                NODEMODULES + 'jquery.scrollto/jquery.scrollTo.min.js',
                NODEMODULES + 'jquery.nicescroll/dist/jquery.nicescroll.min.js',
                NODEMODULES + 'nestable2/dist/jquery.nestable.min.js',
                NODEMODULES + 'morris.js/morris.min.js',
                NODEMODULES + 'raphael/raphael.min.js',

                NODEMODULES + 'jquery-maskmoney/dist/jquery.maskMoney.min.js',

                NODEMODULES + 'pdfjs-dist/build/pdf.min.js',
                NODEMODULES + 'pdfjs-dist/build/pdf.worker.min.js',

                'resources/js/waves.js',
                'resources/js/app.js'
            ], 'assets/js/libs.min.js');
mix.styles([
               NODEMODULES + 'jquery-ui-dist/jquery-ui.min.css',
               NODEMODULES + 'jquery-ui-dist/jquery-ui.theme.min.css',
               NODEMODULES + 'nestable2/dist/jquery.nestable.min.css',
               NODEMODULES + 'morris.js/morris.css'
           ], 'assets/css/libs.min.css');
