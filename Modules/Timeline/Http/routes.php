<?php

Route::group(['middleware' => 'web', 'prefix' => 'timeline', 'namespace' => 'Modules\Timeline\Http\Controllers'], function()
{
    Route::get('/', 'TimelineController@index');
});
