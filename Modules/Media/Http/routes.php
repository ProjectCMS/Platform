<?php
    Breadcrumbs::register('admin.media', function($breadcrumbs) {
        $breadcrumbs->parent('admin.home');
        $breadcrumbs->push('Biblioteca de mídia', route('admin.media'));
    });

    Route::group([
        'middleware' => ['web', 'admin', 'auth:admin'],
        'prefix'     => 'admin/media',
        'namespace'  => 'Modules\Media\Http\Controllers',
        'as'         => 'admin.',
    ], function() {
        Route::get('/', 'MediaController@index')->name('media');
        Route::get('/iframe', 'MediaController@iframe')->name('media.iframe');
        Route::get('/modal', 'MediaController@modal')->name('media.modal');
        Route::get('/items', 'MediaController@items')->name('media.items');
        Route::post('/upload', 'MediaController@upload')->name('media.upload');
        Route::get('/download/{file}', 'MediaController@download')->name('media.download');
        Route::post('/downloads', 'MediaController@downloads')->name('media.downloads');
        Route::delete('/delete', 'MediaController@delete')->name('media.delete');
        Route::post('/create-folder', 'MediaController@create_folder')->name('media.create.folder');
    });