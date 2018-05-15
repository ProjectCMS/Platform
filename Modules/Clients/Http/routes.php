<?php

Route::group(['middleware' => 'web', 'prefix' => 'clients', 'namespace' => 'Modules\Clients\Http\Controllers'], function()
{
    Route::get('/', 'ClientsController@index');
});
