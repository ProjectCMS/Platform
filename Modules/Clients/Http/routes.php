<?php

    Route::group([
        'middleware' => ['web', 'tracker', 'theme_web'],
        'prefix'     => 'clients',
        'namespace'  => 'Modules\Clients\Http\Controllers\Web\Auth',
        'as'         => 'web.'
    ], function() {
        Route::post('/login', 'LoginController@login')->name('clients.login');
        Route::post('/logout', 'LoginController@logout')->name('clients.logout');

        Route::post('/register', 'RegisterController@register')->name('clients.register');

        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('clients.password.request');
        Route::post('/password/reset', 'ResetPasswordController@reset')->name('clients.password.email');
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('clients.password.reset');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('clients.password.reset.token');
    });

    Route::group([
        'middleware' => ['web', 'theme_web'],
        'prefix'     => 'clients',
        'namespace'  => 'Modules\Clients\Http\Controllers\Web',
        'as'         => 'web.'
    ], function() {
        Route::get('social/login/{provider}', 'SocialController@login')->name('clients.social.login');
        Route::get('social/redirect/{provider}', 'SocialController@redirect')->name('clients.social.redirect');
    });
