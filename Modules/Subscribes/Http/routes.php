<?php

    Route::group([
        'middleware' => ['web', 'client', 'auth:client'],
        'prefix'     => 'planos',
        'as'         => 'web.',
        'namespace'  => 'Modules\Subscribes\Http\Controllers\Web'
    ], function() {
        Route::get('/{id}', 'SubscribesController@plan')->name('subscribes.plan')->where('id', '[0-9]+');
        Route::get('/pagamento', 'SubscribesController@payment')->name('subscribes.payment');
    });
