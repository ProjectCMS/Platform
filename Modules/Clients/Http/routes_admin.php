<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin'],
        'prefix'     => 'admin/clients',
        'as'         => 'admin.',
        'namespace'  => 'Modules\Clients\Http\Controllers\Admin'
    ], function() {
        //** Manager **//
        Route::get('/manager', 'ClientsController@index')->name('clients');
        Route::get('/create', 'ClientsController@create')->name('clients.create');
        Route::post('/create', 'ClientsController@store')->name('clients.store');

        Route::get('/edit/{id}', 'ClientsController@edit')->name('clients.edit');
        Route::put('/update/{id}', 'ClientsController@update')->name('clients.update');

        Route::delete('/delete', 'ClientsController@destroy')->name('clients.delete');
        Route::delete('/trash', 'ClientsController@trash')->name('clients.trash');
        Route::put('/restore', 'ClientsController@restore')->name('clients.restore');
    });