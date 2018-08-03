<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin', 'acl'],
        'namespace'  => 'Modules\Publishers\Http\Controllers\Admin',
        'prefix'     => 'admin/settings/publishers',
        'as'         => 'admin.settings.'
    ], function() {

        Route::get('/', 'PublishersController@index')->name('publishers');

        Route::get('/parent/{id}', 'PublishersController@index')->name('publishers.parent');

        Route::get('/create', 'PublishersController@create')->name('publishers.create');
        Route::post('/create', 'PublishersController@store')->name('publishers.store');

        Route::get('/edit/{id}', 'PublishersController@edit')->name('publishers.edit');
        Route::put('/update/{id}', 'PublishersController@update')->name('publishers.update');

        Route::delete('/delete', 'PublishersController@destroy')->name('publishers.delete');

    });