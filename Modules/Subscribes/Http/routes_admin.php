<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin', 'acl'],
        'namespace'  => 'Modules\Subscribes\Http\Controllers\Admin',
        'as'         => 'admin.',
        'prefix'     => 'admin/subscribes',
    ], function() {

        ///**** Subscribes ****///
        Route::group([], function() {

            Route::get('/', 'SubscribesController@index')->name('subscribes');
            Route::get('/create', 'SubscribesController@create')->name('subscribes.create');
            Route::post('/create', 'SubscribesController@store')->name('subscribes.store');

            Route::get('/edit/{id}', 'SubscribesController@edit')->name('subscribes.edit');
            Route::put('/update/{id}', 'SubscribesController@update')->name('subscribes.update');

            Route::delete('/delete', 'SubscribesController@destroy')->name('subscribes.delete');

        });

        Route::group([
            'as' => 'subscribes.',
        ], function() {

            ///**** Cicles ****///
            Route::group([
                'prefix' => 'cicles',
            ], function() {

                Route::get('/', 'CiclesController@index')->name('cicles');
                Route::get('/create', 'CiclesController@create')->name('cicles.create');
                Route::post('/create', 'CiclesController@store')->name('cicles.store');

                Route::get('/edit/{id}', 'CiclesController@edit')->name('cicles.edit');
                Route::put('/update/{id}', 'CiclesController@update')->name('cicles.update');

                Route::delete('/delete', 'CiclesController@destroy')->name('cicles.delete');

            });

            ///**** Payments ****///
            Route::group([
                'prefix' => 'payments',
            ], function() {

                Route::get('/', 'CiclesController@index')->name('payments');
                Route::get('/show', 'CiclesController@create')->name('payments.show');

            });

        });

    });
