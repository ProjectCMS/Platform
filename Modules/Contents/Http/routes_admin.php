<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin', 'acl'],
        'prefix'     => 'admin/contents',
        'namespace'  => 'Modules\Contents\Http\Controllers\Admin',
        'as'         => 'admin.',
    ], function() {

        Route::get('/', 'ContentsController@index')->name('contents');

        Route::get('/create', 'ContentsController@create')->name('contents.create');
        Route::post('/create', 'ContentsController@store')->name('contents.store');

        Route::get('/edit/{id}', 'ContentsController@edit')->name('contents.edit');
        Route::put('/update/{id}', 'ContentsController@update')->name('contents.update');

        Route::delete('/delete', 'ContentsController@destroy')->name('contents.delete');

        Route::post('/cicle', 'ContentsController@cicle')->name('contents.cicle');

    });