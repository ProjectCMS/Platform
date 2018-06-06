<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:users'],
        'prefix'     => 'admin/settings/menus',
        'namespace'  => 'Modules\Menus\Http\Controllers\admin',
        'as'         => 'admin.settings.',
    ], function() {

        //** Menu **//
        Route::get('/', 'MenusController@index')->name('menus');

        Route::post('/add-item-menu', 'MenusController@add_item_menu')->name('menus.addItemMenu');

        Route::get('/create', 'MenusController@create')->name('menus.create');
        Route::post('/create', 'MenusController@store')->name('menus.store');

        Route::get('/edit/{id?}', 'MenusController@edit')->name('menus.edit');
        Route::put('/update/{id}', 'MenusController@update')->name('menus.update');

        Route::delete('/delete', 'MenusController@destroy')->name('menus.delete');

        Route::get('/locations', 'MenusController@locations')->name('menus.locations');
        Route::put('/locations/update', 'MenusController@locations_update')->name('menus.locations.update');

    });
