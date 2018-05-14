<?php

    ///**** Posts ****///
    Breadcrumbs::register('admin.posts', function($breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push('Blog', route('admin.posts'));
    });

    Breadcrumbs::register('admin.posts.create', function($breadcrumbs) {
        $breadcrumbs->parent('admin.posts');
        $breadcrumbs->push(trans('dashboard::dashboard.page.create'), route('admin.posts.create'));
    });

    Breadcrumbs::register('admin.posts.edit', function($breadcrumbs, $item) {
        $breadcrumbs->parent('admin.posts');
        $breadcrumbs->push($item->title, route('admin.posts.edit', $item->id));
    });

    ///**** Catetories ****///
    Breadcrumbs::register('admin.categories', function($breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push('Categorias', route('admin.categories'));
    });

    Breadcrumbs::register('admin.categories.create', function($breadcrumbs) {
        $breadcrumbs->parent('admin.categories');
        $breadcrumbs->push(trans('dashboard::dashboard.page.create'), route('admin.categories.create'));
    });

    Breadcrumbs::register('admin.categories.edit', function($breadcrumbs, $item) {
        $breadcrumbs->parent('admin.categories');
        $breadcrumbs->push($item->name, route('admin.categories.edit', $item->id));
    });

    ///**** Tags ****///
    Breadcrumbs::register('admin.tags', function($breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push('Tags', route('admin.tags'));
    });

    Breadcrumbs::register('admin.tags.create', function($breadcrumbs) {
        $breadcrumbs->parent('admin.tags');
        $breadcrumbs->push(trans('dashboard::dashboard.page.create'), route('admin.tags.create'));
    });

    Breadcrumbs::register('admin.tags.edit', function($breadcrumbs, $item) {
        $breadcrumbs->parent('admin.tags');
        $breadcrumbs->push($item->name, route('admin.tags.edit', $item->id));
    });


    ///**** Posts ****///
    Route::group([
        'middleware' => ['web', 'admin', 'auth:admin'],
        'prefix'     => 'admin/posts',
        'namespace'  => 'Modules\Posts\Http\Controllers\admin',
        'as'         => 'admin.',
    ], function() {

        Route::get('/', 'PostsController@index')->name('posts');
        Route::get('/create', 'PostsController@create')->name('posts.create');
        Route::post('/create', 'PostsController@store')->name('posts.store');

        Route::get('/edit/{id}', 'PostsController@edit')->name('posts.edit');
        Route::put('/update/{id}', 'PostsController@update')->name('posts.update');
        Route::put('/order', 'PostsController@order')->name('posts.order');

        Route::delete('/delete', 'PostsController@destroy')->name('posts.delete');
        Route::delete('/trash', 'PostsController@trash')->name('posts.trash');
        Route::put('/restore', 'PostsController@restore')->name('posts.restore');

        Route::get('/export/{type}', 'PostsController@files_xml');

    });

    ///**** Catetories ****///
    Route::group([
        'middleware' => ['web', 'admin', 'auth:admin'],
        'prefix'     => 'admin/categories',
        'namespace'  => 'Modules\Posts\Http\Controllers\admin',
        'as'         => 'admin.',
    ], function() {

        Route::get('/', 'CategoriesController@index')->name('categories');
        Route::get('/create', 'CategoriesController@create')->name('categories.create');
        Route::post('/create', 'CategoriesController@store')->name('categories.store');

        Route::get('/edit/{id}', 'CategoriesController@edit')->name('categories.edit');
        Route::put('/update/{id}', 'CategoriesController@update')->name('categories.update');
        Route::put('/order', 'CategoriesController@order')->name('categories.order');

        Route::delete('/delete', 'CategoriesController@destroy')->name('categories.delete');

    });

    ///**** Tags ****///
    Route::group([
        'middleware' => ['web', 'admin', 'auth:admin'],
        'prefix'     => 'admin/tags',
        'namespace'  => 'Modules\Posts\Http\Controllers\admin',
        'as'         => 'admin.',
    ], function() {

        Route::get('/', 'TagsController@index')->name('tags');
        Route::get('/datatable', 'TagsController@datatable')->name('tags.datatable');
        Route::get('/create', 'TagsController@create')->name('tags.create');
        Route::post('/create', 'TagsController@store')->name('tags.store');

        Route::get('/edit/{id}', 'TagsController@edit')->name('tags.edit');
        Route::put('/update/{id}', 'TagsController@update')->name('tags.update');
        Route::put('/order', 'TagsController@order')->name('tags.order');

        Route::delete('/delete', 'TagsController@destroy')->name('tags.delete');
    });

    ///**** Images ****///
    Route::group([
    'middleware' => ['web', 'admin', 'auth:admin'],
        'prefix'     => 'admin/postimages',
        'namespace'  => 'Modules\Posts\Http\Controllers\admin',
        'as'         => 'admin.',
    ], function() {

    Route::put('/order/{id}', 'PostImagesController@order')->name('images.order');
});

