<?php

    Route::group([
        'middleware' => ['web', 'tracker', 'theme_web'],
        'as'         => 'web.',
        'prefix'     => 'cliente',
    ], function() {

        Route::group([
            'namespace' => 'Modules\Clients\Http\Controllers\Web\Auth',
        ], function() {
            Route::get('/login', 'LoginController@showLoginForm')->name('clients.login');
            Route::post('/login', 'LoginController@login')->name('clients.login');
            Route::post('/logout', 'LoginController@logout')->name('clients.logout');

            Route::get('/registro', 'RegisterController@showRegistrationForm')->name('clients.register');
            Route::post('/registro', 'RegisterController@register')->name('clients.register.post');

            Route::post('/senha/email', 'ForgotPasswordController@sendResetLinkEmail')
                 ->name('clients.password.request');
            Route::post('/senha/reset', 'ResetPasswordController@reset')->name('clients.password.email');
            Route::get('/senha/reset', 'ForgotPasswordController@showLinkRequestForm')->name('clients.password.reset');
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


    Route::group([
        'middleware' => ['web', 'tracker', 'theme_web', 'client', 'auth:client'],
        'as'         => 'web.clients.account.',
        'prefix'     => 'cliente/conta',
        'namespace'  => 'Modules\Clients\Http\Controllers\Web\Account',
    ], function() {
        Route::get('/', 'AccountController@index')->name('home');
        Route::get('/assinatura', 'AccountController@subscribe')->name('subscribe');

        Route::get('/perfil', 'AccountController@profile')->name('profile');
        Route::put('/perfil/atualizar', 'AccountController@profileEdit')->name('profile.update');

        Route::get('/senha', 'AccountController@password')->name('password');
        Route::put('/senha', 'AccountController@passwordEdit')->name('password.update');

        Route::put('/avatar', 'AccountController@clientAvatar')->name('avatar');

        Route::get('/historico', 'AccountController@historic')->name('historic');
    });