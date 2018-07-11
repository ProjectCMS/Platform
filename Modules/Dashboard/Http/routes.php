<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin'],
        'prefix'     => 'admin',
        'namespace'  => 'Modules\Dashboard\Http\Controllers',
        'as'         => 'admin.'
    ], function() {
        Route::get('/home', 'DashboardController@index')->name('home');
    });