<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:users'],
        'prefix'     => 'admin/settings',
        'namespace'  => 'Modules\Settings\Http\Controllers',
        'as'         => 'admin.',
    ], function() {

        //** General **//
        Route::get('/general', 'GeneralController@index')->name('settings.general');
        Route::put('/general/update', 'GeneralController@update')->name('settings.general.update');

    });


