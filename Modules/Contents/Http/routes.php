<?php

Route::group(['middleware' => 'web', 'prefix' => 'contents', 'namespace' => 'Modules\Contents\Http\Controllers'], function()
{
    Route::get('/', 'ContentsController@index');
});
