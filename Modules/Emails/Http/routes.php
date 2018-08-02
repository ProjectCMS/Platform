<?php

    Route::group([
        'middleware' => ['web', 'tracker', 'theme_web'],
        'namespace'  => 'Modules\Emails\Http\Controllers\Web',
        'as'         => 'web.emails.'
    ], function(){

        /**
         * Contact
         */
        Route::post('/enviar-email-contato', 'ContactController@sendMailContact')->name('contact.send');

    });
