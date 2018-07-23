<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin', 'acl'],
        'prefix'     => 'admin/pages',
        'namespace'  => 'Modules\Pages\Http\Controllers\Admin',
        'as'         => 'admin.',
    ], function() {

        Route::get('/', 'PagesController@index')->name('pages');

        Route::get('/parent/{id}', 'PagesController@index')->name('pages.parent');

        Route::get('/create', 'PagesController@create')->name('pages.create');
        Route::post('/create', 'PagesController@store')->name('pages.store');

        Route::get('/edit/{id}', 'PagesController@edit')->name('pages.edit');
        Route::put('/update/{id}', 'PagesController@update')->name('pages.update');
        Route::put('/order', 'PagesController@order')->name('pages.order');

        Route::delete('/delete', 'PagesController@destroy')->name('pages.delete');
        Route::delete('/trash', 'PagesController@trash')->name('pages.trash');
        Route::put('/restore', 'PagesController@restore')->name('pages.restore');

    });