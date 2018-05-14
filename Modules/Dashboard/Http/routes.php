<?php


    Breadcrumbs::register('admin.home', function($breadcrumbs) {
        $breadcrumbs->push('Dashboard', route('admin.home'));
    });

    Route::group([
        'middleware' => ['web', 'admin', 'auth:admin'],
        'prefix'     => 'admin',
        'namespace'  => 'Modules\Dashboard\Http\Controllers',
        'as'         => 'admin.'
    ], function() {
        Route::get('/home', 'DashboardController@index')->name('home');

        Route::get('/pdf', function() {

//            $pdf      = public_path('pdf.pdf');
//            $ilovepdf = new \Ilovepdf\Ilovepdf('project_public_bfaf4c0b037ed5fa7428e2063be25633_GrB3ibc71a8554e2763a588cbf68016d131ad', 'secret_key_a362a093f609f4462135cebd8bdfbfdd_G5BBmb05c526c09b616698aaf5ab2c693dfc1');
//
//            $myTaskSplit = $ilovepdf->newTask('split');
//            $myTaskSplit->addFile($pdf);
//            $myTaskSplit->setFixedRange(1);
//            $myTaskSplit->setOutputFilename('{date}');
//            $myTaskSplit->execute();
//            $myTaskSplit->download();

            $output = public_path('output.zip');

            Zipper::make($output)->extractTo('storage/pdf');
            Storage::disk('local')->delete($output);

        });

    });