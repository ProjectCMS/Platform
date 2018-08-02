<?php

    Route::group([
        'middleware' => ['web', 'theme_admin'],
        'prefix'     => 'admin',
        'namespace'  => 'Modules\Users\Http\Controllers\Auth'
    ], function() {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::post('/logout', 'LoginController@logout')->name('logout');

        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.request');
        Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.email');
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm');
    });

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin', 'acl'],
        'prefix'     => 'admin/users',
        'as'         => 'admin.',
        'namespace'  => 'Modules\Users\Http\Controllers'
    ], function() {
        //** Manager **//
        Route::get('/', 'UsersController@index')->name('users');
        Route::get('/create', 'UsersController@create')->name('users.create');
        Route::post('/create', 'UsersController@store')->name('users.store');

        Route::get('/edit/{id}', 'UsersController@edit')->name('users.edit');
        Route::put('/update/{id}', 'UsersController@update')->name('users.update');

        Route::delete('/delete', 'UsersController@destroy')->name('users.delete');
        Route::delete('/trash', 'UsersController@trash')->name('users.trash');
        Route::put('/restore', 'UsersController@restore')->name('users.restore');

        Route::get('/account', 'UsersController@account')->name('account');
        Route::put('/account/update/{id}', 'UsersController@account_update')->name('account.update');
    });

