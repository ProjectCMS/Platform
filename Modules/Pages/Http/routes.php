<?php
    Breadcrumbs::for ('page', function($trail, $page) {
        $trail->push('Home', ('/'));
        $trail->push($page->title, route('web.pages.' . $page->slug));
    });


    Route::group([
        'middleware' => ['web', 'tracker', 'theme_web'],
        'namespace'  => 'Modules\Pages\Http\Controllers\Web',
        'as'         => 'web.'
    ], function(){

        Route::get('/', 'PagesController@index');

        /**
         * Contact Pages
         */
        Route::post('/enviar-email-contato', 'ContactController@sendMailContact')->name('contact.send');

        try{

            $pages = \Modules\Pages\Entities\Page::all();
            $pages->each(function(\Modules\Pages\Entities\Page $page) {
                if($page->slug != 'blog') {
                    Route::get($page->slug, 'PagesController@show')
                         ->name('pages.' . $page->slug)
                         ->defaults('page', $page);
                }
            });

        }catch (\Exception $e){

        }
    });
