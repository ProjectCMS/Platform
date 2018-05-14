<?php

Route::group(['middleware' => 'web', 'prefix' => 'seo', 'namespace' => 'Modules\Seo\Http\Controllers'], function()
{
    Route::get('/', 'SeoController@index');
});
