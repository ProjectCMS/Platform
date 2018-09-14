<?php

    Route::group([
        'middleware' => ['web', 'client', 'auth:client'],
        'prefix'     => 'planos',
        'as'         => 'web.subscribes.',
        'namespace'  => 'Modules\Subscribes\Http\Controllers\Web'
    ], function() {
        Route::get('/{id}', 'SubscribesController@plan')->name('plan')->where('id', '[0-9]+');
        Route::post('/chave', 'SubscribesController@key')->name('key');
    });
