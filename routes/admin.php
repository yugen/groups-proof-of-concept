<?php

use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
