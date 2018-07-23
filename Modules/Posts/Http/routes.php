<?php
    Breadcrumbs::for ('post', function($trail) {
        $trail->push('Home', ('/'));
        $trail->push('Blog', route('web.posts'));
    });

    Breadcrumbs::for ('post.item', function($trail, $post) {
        $trail->parent('post');
        $trail->push($post->title, route('web.posts.' . $post->slug));
    });

    Breadcrumbs::for ('post.partial', function($trail, $partial) {
        $trail->parent('post');
        $trail->push($partial->title, ('/'));
    });

    Route::group([
        'middleware' => ['web', 'tracker', 'theme_web'],
        'namespace'  => 'Modules\Posts\Http\Controllers\Web',
        'as'         => 'web.'
    ], function() {

        Route::get('blog', 'PostsController@index')->name('posts');
        Route::get('tag/{tag}', 'PostsController@tag')->name('posts.tag');
        Route::get('category/{category}', 'PostsController@category')->name('posts.category');

        $posts = \Modules\Posts\Entities\Post::all();
        $posts->each(function($post) {
            $year  = $post->created_at->format('Y');
            $month = $post->created_at->format('m');
            $day   = $post->created_at->format('d');

            Route::get("{$post->id}-{$post->slug}", 'PostsController@show')
                 ->name('posts.' . $post->slug)
                 ->defaults('post', $post);

            Route::get("{$year}/{$month}/{$day}/{$post->slug}", 'PostsController@show')
                 ->name('posts.date.' . $post->slug)
                 ->defaults('post', $post);
        });
    });