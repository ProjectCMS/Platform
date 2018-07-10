<?php

Route::group(['middleware' => 'web', 'prefix' => 'tracker', 'namespace' => 'Modules\Tracker\Http\Controllers'], function()
{
    Route::get('/', 'TrackerController@index');
});
