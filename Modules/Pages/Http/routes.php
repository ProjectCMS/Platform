<?php
    Breadcrumbs::for ('page', function($trail, $page) {
        $trail->push('Home', ('/'));
        $trail->push($page->title, route('web.pages.' . $page->slug));
    });

    Route::group([
        'middleware' => ['web', 'theme_web'],
        'namespace'  => 'Modules\Pages\Http\Controllers\Web',
        'as'         => 'web.'
    ], function() {

        Route::get('/', 'PagesController@index');

        $pages = \Modules\Pages\Entities\Page::all();
        $pages->each(function($page) {
            Route::get($page->slug, 'PagesController@show')->name('pages.' . $page->slug)->defaults('page', $page);
        });
    });