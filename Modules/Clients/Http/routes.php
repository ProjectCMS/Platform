<?php

    Route::group([
        'middleware' => ['web', 'tracker', 'theme_web'],
        'as'         => 'web.',
        'prefix'    => 'clientes',
    ], function() {

        Route::group([
            'namespace' => 'Modules\Clients\Http\Controllers\Web\Auth',
        ], function() {
            Route::get('/', 'LoginController@showLoginForm')->name('clients');
            Route::post('/login', 'LoginController@login')->name('clients.login');
            Route::post('/logout', 'LoginController@logout')->name('clients.logout');

            Route::get('/registro', 'RegisterController@showRegistrationForm')->name('clients.register');
            Route::post('/registro', 'RegisterController@register')->name('clients.register.post');

            Route::post('/senha/email', 'ForgotPasswordController@sendResetLinkEmail')
                 ->name('clients.password.request');
            Route::post('/senha/reset', 'ResetPasswordController@reset')->name('clients.password.email');
            Route::get('/senha/reset', 'ForgotPasswordController@showLinkRequestForm')
                 ->name('clients.password.reset');
            Route::get('/senha/reset/{token}', 'ResetPasswordController@showResetForm')
                 ->name('clients.password.reset.token');
        });

        Route::group([
            'namespace' => 'Modules\Clients\Http\Controllers\Web',
        ], function() {
            Route::get('social/login/{provider}', 'SocialController@login')->name('clients.social.login');
            Route::get('social/redirect/{provider}', 'SocialController@redirect')->name('clients.social.redirect');
        });


    });