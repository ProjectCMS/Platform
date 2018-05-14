<?php

Route::group(['middleware' => 'web', 'prefix' => 'config', 'namespace' => 'Modules\Config\Http\Controllers'], function()
{
    Route::get('/', 'ConfigController@index');
});
