<?php


    Route::group([
        'middleware' => ['web'],
        'namespace'  => 'Modules\Publishers\Http\Controllers\Web',
        'prefix'     => 'publishers',
        'as'         => 'web.'
    ], function() {

        Route::post('/', 'PublishersController@index')->name('publishers');
        Route::get('/redirect', 'PublishersController@redirect')->name('publishers.redirect');

    });