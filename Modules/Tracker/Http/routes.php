<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin', 'acl'],
        'prefix'     => 'admin/tracker',
        'namespace'  => 'Modules\Tracker\Http\Controllers',
        'as'         => 'admin.'
    ], function() {
        Route::get('/', 'TrackerController@index')->name('tracker');
    });