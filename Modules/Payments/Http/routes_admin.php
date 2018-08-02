<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin', 'acl'],
        'prefix'     => 'admin/settings/payments',
        'namespace'  => 'Modules\Payments\Http\Controllers\Admin',
        'as'         => 'admin.settings.',
    ], function() {

        Route::get('/', 'PaymentsController@index')->name('payments');
        Route::get('/edit/{id}', 'PaymentsController@edit')->name('payments.edit');
        Route::put('/update/{id}', 'PaymentsController@update')->name('payments.update');

    });