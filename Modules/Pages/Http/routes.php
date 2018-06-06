<?php

    $pages = \Modules\Pages\Entities\Page::all();

    Route::group([
        'middleware' => ['web'],
        'namespace'  => 'Modules\Pages\Http\Controllers\web',
        'as'         => 'web.'
    ], function() use ($pages) {

        $pages->each(function($page) {

            Route::get($page->slug, 'PagesController@show')->name('pages.' . $page->slug)->defaults('page', $page);

        });

    });
