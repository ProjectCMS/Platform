<?php

    Route::group([
        'middleware' => ['web', 'user', 'auth:user', 'theme_admin', 'acl'],
        'namespace'  => 'Modules\Posts\Http\Controllers\Admin',
        'as'         => 'admin.',
        'prefix'     => 'admin/posts',
    ], function() {

        ///**** Posts ****///
        Route::group([], function() {

            Route::get('/', 'PostsController@index')->name('posts');
            Route::get('/create', 'PostsController@create')->name('posts.create');
            Route::post('/create', 'PostsController@store')->name('posts.store');

            Route::get('/edit/{id}', 'PostsController@edit')->name('posts.edit');
            Route::put('/update/{id}', 'PostsController@update')->name('posts.update');

            Route::delete('/delete', 'PostsController@destroy')->name('posts.delete');
            Route::delete('/trash', 'PostsController@trash')->name('posts.trash');
            Route::put('/restore', 'PostsController@restore')->name('posts.restore');

            Route::get('/export/{type}', 'PostsController@files_xml')->name('posts.export');

            Route::put('images/order/{id}', 'PostImagesController@order')->name('posts.images.order');

        });

        Route::group([
            'as'         => 'posts.',
        ], function() {

            ///**** Catetories ****///
            Route::group([
                'prefix' => 'categories',
            ], function() {

                Route::get('/', 'CategoriesController@index')->name('categories');
                Route::get('/create', 'CategoriesController@create')->name('categories.create');
                Route::post('/create', 'CategoriesController@store')->name('categories.store');

                Route::get('/edit/{id}', 'CategoriesController@edit')->name('categories.edit');
                Route::put('/update/{id}', 'CategoriesController@update')->name('categories.update');

                Route::delete('/delete', 'CategoriesController@destroy')->name('categories.delete');

            });

            ///**** Tags ****///
            Route::group([
                'prefix' => 'tags',
            ], function() {

                Route::get('/', 'TagsController@index')->name('tags');
                Route::get('/datatable', 'TagsController@datatable')->name('tags.datatable');
                Route::get('/create', 'TagsController@create')->name('tags.create');
                Route::post('/create', 'TagsController@store')->name('tags.store');

                Route::get('/edit/{id}', 'TagsController@edit')->name('tags.edit');
                Route::put('/update/{id}', 'TagsController@update')->name('tags.update');

                Route::delete('/delete', 'TagsController@destroy')->name('tags.delete');
            });

            ///**** Posts ****///
            Route::group([
                'prefix' => 'images',
            ], function() {
                Route::get('/optimizer', 'PostImagesController@optimizer')->name('images.optimizer');
            });

        });

    });

