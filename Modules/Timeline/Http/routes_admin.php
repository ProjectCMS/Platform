<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin', 'acl'],
        'prefix'     => 'admin/timeline',
        'namespace'  => 'Modules\Timeline\Http\Controllers\Admin',
        'as'         => 'admin.',
    ], function() {

        Route::get('/', 'TimelineController@index')->name('timeline');
        Route::get('/datatable', 'TimelineController@datatable')->name('timeline.datatable');
        Route::get('/create', 'TimelineController@create')->name('timeline.create');
        Route::post('/create', 'TimelineController@store')->name('timeline.store');

        Route::get('/edit/{id}', 'TimelineController@edit')->name('timeline.edit');
        Route::put('/update/{id}', 'TimelineController@update')->name('timeline.update');

        Route::delete('/delete', 'TimelineController@destroy')->name('timeline.delete');
    });