<?php

use Illuminate\Support\Facades\Route;
use Libaro\LaravelSlowQueries\Http\Controllers\DashboardController;
use Libaro\LaravelSlowQueries\Http\Controllers\SlowPagesController;
use Libaro\LaravelSlowQueries\Http\Controllers\SlowQueriesController;

Route::middleware(strval(config('slow-queries.middleware')))
    ->name('slow-queries.')
    ->prefix(strval(config('slow-queries.url_prefix')) . '/api')
    ->group(function () {
        Route::post('/save-time-range', \Libaro\LaravelSlowQueries\Http\Controllers\api\TimeRangeController::class.'@store')
            ->name('timerange.store');
    });
