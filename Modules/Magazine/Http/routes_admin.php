<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:users'],
        'prefix'     => 'admin/magazine',
        'namespace'  => 'Modules\Magazine\Http\Controllers\admin',
        'as'         => 'admin.',
    ], function() {

        Route::get('/', 'MagazineController@index')->name('magazine');

        Route::get('/parent/{id}', 'MagazineController@index')->name('magazine.parent');

        Route::get('/create', 'MagazineController@create')->name('magazine.create');
        Route::post('/create', 'MagazineController@store')->name('magazine.store');

        Route::get('/edit/{id}', 'MagazineController@edit')->name('magazine.edit');
        Route::put('/update/{id}', 'MagazineController@update')->name('magazine.update');
        Route::put('/order', 'MagazineController@order')->name('magazine.order');

        Route::delete('/delete', 'MagazineController@destroy')->name('magazine.delete');
        Route::delete('/trash', 'MagazineController@trash')->name('magazine.trash');
        Route::put('/restore', 'MagazineController@restore')->name('magazine.restore');

        Route::post('/manager', 'MagazineController@manager')->name('magazine.manager');

    });