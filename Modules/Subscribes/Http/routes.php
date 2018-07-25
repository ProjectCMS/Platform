<?php

Route::group(['middleware' => 'web', 'prefix' => 'subscribes', 'namespace' => 'Modules\Subscribes\Http\Controllers'], function()
{
    Route::get('/', 'SubscribesController@index');
});
