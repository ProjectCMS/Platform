<?php

    Breadcrumbs::register('admin.pages', function($breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push('Páginas', route('admin.pages'));
    });

    Breadcrumbs::register('admin.pages.create', function($breadcrumbs) {
        $breadcrumbs->parent('admin.pages');
        $breadcrumbs->push(trans('dashboard::dashboard.page.create'), route('admin.pages.create'));
    });

    Breadcrumbs::register('admin.pages.edit', function($breadcrumbs, $page) {
        $breadcrumbs->parent('admin.pages');
        $breadcrumbs->push($page->title, route('admin.pages.edit', $page->id));
    });


    Route::group([
        'middleware' => ['web', 'admin', 'auth:admin'],
        'prefix'     => 'admin/pages',
        'namespace'  => 'Modules\Pages\Http\Controllers\admin',
        'as'         => 'admin.',
    ], function() {

        Route::get('/', 'PagesController@index')->name('pages');

        Route::get('/parent/{id}', 'PagesController@index')->name('pages.parent');

        Route::get('/create', 'PagesController@create')->name('pages.create');
        Route::post('/create', 'PagesController@store')->name('pages.store');

        Route::get('/edit/{id}', 'PagesController@edit')->name('pages.edit');
        Route::put('/update/{id}', 'PagesController@update')->name('pages.update');
        Route::put('/order', 'PagesController@order')->name('pages.order');

        Route::delete('/delete', 'PagesController@destroy')->name('pages.delete');
        Route::delete('/trash', 'PagesController@trash')->name('pages.trash');
        Route::put('/restore', 'PagesController@restore')->name('pages.restore');

    });