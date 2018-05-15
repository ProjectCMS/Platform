<?php


    Breadcrumbs::register('admin.modules', function($breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push('Módulos', route('admin.modules'));
    });

    Route::group([
        'middleware' => ['web', 'user', 'auth:users'],
        'prefix'     => 'admin/modules',
        'namespace'  => 'Modules\Modules\Http\Controllers',
        'as'         => 'admin.',
    ], function() {

        Route::get('/', 'ModulesController@index')->name('modules');
        Route::post('/switch', 'ModulesController@switch')->name('modules.switch');

    });