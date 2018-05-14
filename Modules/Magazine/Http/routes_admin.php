<?php

    Breadcrumbs::register('admin.magazine', function($breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push('Revistas', route('admin.pages'));
    });

    Breadcrumbs::register('admin.magazine.create', function($breadcrumbs) {
        $breadcrumbs->parent('admin.magazine');
        $breadcrumbs->push(trans('dashboard::dashboard.page.create'), route('admin.pages.create'));
    });

    Breadcrumbs::register('admin.magazine.edit', function($breadcrumbs, $page) {
        $breadcrumbs->parent('admin.magazine');
        $breadcrumbs->push($page->title, route('admin.magazine.edit', $page->id));
    });


    Route::group([
        'middleware' => ['web', 'admin', 'auth:admin'],
        'prefix'     => 'admin/magazine',
        'namespace'  => 'Modules\Magazine\Http\Controllers\admin',
        'as'         => 'admin.',
    ], function() {

        Route::get('/', 'MagazineController@index')->name('magazine');

        Route::get('/parent/{id}', 'MagazineController@index')->name('magazine.parent');

        Route::get('/create', 'MagazineController@create')->name('magazine.create');
        Route::post('/create', 'MagazineController@store')->name('magazine.store');

        Route::get('/edit/{id}', 'MagazineController@edit')->name('magazine.edit');
        Route::put('/update/{id}', 'MagazineController@update')->name('magazine.update');
        Route::put('/order', 'MagazineController@order')->name('magazine.order');

        Route::delete('/delete', 'MagazineController@destroy')->name('magazine.delete');
        Route::delete('/trash', 'MagazineController@trash')->name('magazine.trash');
        Route::put('/restore', 'MagazineController@restore')->name('magazine.restore');

        Route::post('/manager', 'MagazineController@manager')->name('magazine.manager');

    });