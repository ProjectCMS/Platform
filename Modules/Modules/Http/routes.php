<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:users', 'theme_admin'],
        'prefix'     => 'admin/modules',
        'namespace'  => 'Modules\Modules\Http\Controllers',
        'as'         => 'admin.',
    ], function() {

        Route::get('/', 'ModulesController@index')->name('modules');
        Route::post('/switch', 'ModulesController@switch')->name('modules.switch');

    });