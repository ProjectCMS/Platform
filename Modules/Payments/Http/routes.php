<?php
    Route::group([
        'middleware' => ['web', 'client', 'auth:client', 'tracker', 'theme_web'],
        'prefix'     => 'pagamento',
        'as'         => 'web.',
        'namespace'  => 'Modules\Payments\Http\Controllers\Web'
    ], function() {
        Route::get('/', 'PaymentsController@payment')->name('payment');
    });