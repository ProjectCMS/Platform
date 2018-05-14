<?php

    Breadcrumbs::register('admin.manager', function($breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push('Administradores', route('admin.manager'));
    });

    Breadcrumbs::register('admin.manager.create', function($breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push(trans('dashboard::dashboard.page.create'), route('admin.manager'));
    });

    Breadcrumbs::register('admin.manager.edit', function($breadcrumbs, $item) {
        $breadcrumbs->parent('admin.manager');
        $breadcrumbs->push($item->name, route('admin.manager.edit', $item->id));
    });

    Route::group([
        'middleware' => 'web',
        'prefix'     => 'admin',
        'namespace'  => 'Modules\Admin\Http\Controllers'
    ], function() {
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
    });

    Route::group([
        'middleware' => 'web',
        'prefix'     => 'admin',
        'as'         => 'admin.',
        'namespace'  => 'Modules\Admin\Http\Controllers'
    ], function() {
        //** Auth **//
        Route::post('/login', 'LoginController@login');
        Route::post('/logout', 'LoginController@logout')->name('logout');

        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.request');
        Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.email');
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm');

        //** Manager **//
        Route::get('/manager', 'AdminController@index')->name('manager');
        Route::get('/create', 'AdminController@create')->name('manager.create');
        Route::post('/create', 'AdminController@store')->name('manager.store');

        Route::get('/edit/{id}', 'AdminController@edit')->name('manager.edit');
        Route::put('/update/{id}', 'AdminController@update')->name('manager.update');
        Route::put('/order', 'AdminController@order')->name('manager.order');

        Route::delete('/delete', 'AdminController@destroy')->name('manager.delete');
        Route::delete('/trash', 'AdminController@trash')->name('manager.trash');
        Route::put('/restore', 'AdminController@restore')->name('manager.restore');


        Route::get('/master', function () {
            return view('dashboard::index');
        });

    });
