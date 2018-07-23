<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin', 'acl'],
        'as'         => 'admin.',
        'namespace'  => 'Modules\Users\Http\Controllers\Acl'
    ], function() {

        /** Roles **/
        Route::group(['prefix' => 'admin/roles'], function() {
            //** Manager **//
            Route::get('/', 'RolesController@index')->name('roles');
            Route::get('/create', 'RolesController@create')->name('roles.create');
            Route::post('/create', 'RolesController@store')->name('roles.store');

            Route::get('/edit/{id}', 'RolesController@edit')->name('roles.edit');
            Route::put('/update/{id}', 'RolesController@update')->name('roles.update');

            Route::delete('/delete', 'RolesController@destroy')->name('roles.delete');
        });

        /** Permissions **/
        Route::group(['prefix' => 'admin/permissions'], function() {
            //** Manager **//
            Route::get('/', 'PermissionsController@index')->name('permissions');
            Route::get('/create', 'PermissionsController@create')->name('permissions.create');
            Route::post('/create', 'PermissionsController@store')->name('permissions.store');

            Route::get('/edit/{id}', 'PermissionsController@edit')->name('permissions.edit');
            Route::put('/update/{id}', 'PermissionsController@update')->name('permissions.update');

            Route::delete('/delete', 'PermissionsController@destroy')->name('permissions.delete');
        });

    });
