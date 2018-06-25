<?php

Route::group(['middleware' => 'web', 'prefix' => 'themes', 'namespace' => 'Modules\Themes\Http\Controllers'], function()
{
    Route::get('/', 'ThemesController@index');
});
