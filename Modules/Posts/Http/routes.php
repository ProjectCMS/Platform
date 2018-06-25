<?php

    $posts = \Modules\Posts\Entities\Post::all();

    Route::group([
        'middleware' => ['web', 'theme_web'],
        'namespace'  => 'Modules\Posts\Http\Controllers\Web',
        'as'         => 'web.'
    ], function() use ($posts) {

        Route::get('blog', 'PostsController@index')->name('posts');
        Route::get('tag/{tag}', 'PostsController@tag')->name('posts.tag');
        Route::get('category/{category}', 'PostsController@category')->name('posts.category');

        $posts->each(function($post) {

            Route::get($post->slug, 'PostsController@show')->name('posts.' . $post->slug)->defaults('post', $post);

        });

    });
