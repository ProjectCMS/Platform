<?php

    $pages = \Modules\Pages\Entities\Page::all();

    Route::group([
        'middleware' => ['web', 'theme_web'],
        'namespace'  => 'Modules\Pages\Http\Controllers\Web',
        'as'         => 'web.'
    ], function() use ($pages) {

        Route::get('/', 'PagesController@index');

        $pages->each(function($page) {

            Route::get($page->slug, 'PagesController@show')->name('pages.' . $page->slug)->defaults('page', $page);

        });

    });
