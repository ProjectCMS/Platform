let mix           = require('laravel-mix').mix;
const nodeModules = 'node_modules/';
const themeInfo   = require('./theme.json');


/*
 |--------------------------------------------------------------------------
 | Concat
 |--------------------------------------------------------------------------
 |
 */
mix.scripts(['../../Modules/**/web/compile/js/*.js'], 'assets/js/modules.min.js');
mix.styles(['../../Modules/**/web/compile/css/*.css'], 'assets/css/modules.min.css');

