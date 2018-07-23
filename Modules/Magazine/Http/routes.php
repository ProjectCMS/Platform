<?php

    Route::group([
        'middleware' => ['web', 'tracker', 'cors'],
        'prefix'     => 'magazine',
        'namespace'  => 'Modules\Magazine\Http\Controllers\Web',
        'as'         => 'web.',
    ], function() {

        Route::any('/show', 'MagazineController@show')->name('magazine.show');
        Route::any('/premium', 'MagazineController@premium')->name('magazine.premium');

    });

