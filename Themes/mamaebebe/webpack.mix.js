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
mix.scripts(['../../Modules/**/web/compile/js/*.js'], 'assets/js/modules.min.js');
mix.styles(['../../Modules/**/web/compile/css/*.css'], 'assets/css/modules.min.css');

