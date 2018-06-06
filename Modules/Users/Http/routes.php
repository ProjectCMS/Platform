<?php

    Route::group([
        'middleware' => 'web',
        'prefix'     => 'admin',
        'namespace'  => 'Modules\Users\Http\Controllers'
    ], function() {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::post('/logout', 'LoginController@logout')->name('logout');

        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.request');
        Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.email');
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm');
    });

    Route::group([
        'middleware' => ['web', 'user', 'auth:users'],
        'prefix'     => 'admin',
        'as'         => 'admin.',
        'namespace'  => 'Modules\Users\Http\Controllers'
    ], function() {
        //** Manager **//
        Route::get('/manager', 'UsersController@index')->name('users');
        Route::get('/create', 'UsersController@create')->name('users.create');
        Route::post('/create', 'UsersController@store')->name('users.store');

        Route::get('/edit/{id}', 'UsersController@edit')->name('users.edit');
        Route::put('/update/{id}', 'UsersController@update')->name('users.update');
        Route::put('/order', 'UsersController@order')->name('users.order');

        Route::delete('/delete', 'UsersController@destroy')->name('users.delete');
        Route::delete('/trash', 'UsersController@trash')->name('users.trash');
        Route::put('/restore', 'UsersController@restore')->name('users.restore');


        Route::get('/master', function () {
            return view('dashboard::index');
        });

    });
