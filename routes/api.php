<?php

use Illuminate\Support\Facades\Route;
use Libaro\LaravelSlowQueries\Http\Controllers\api\RerunQueryController;
use Libaro\LaravelSlowQueries\Http\Controllers\api\TimeRangeController;
use Libaro\LaravelSlowQueries\Http\Controllers\DashboardController;
use Libaro\LaravelSlowQueries\Http\Controllers\SlowPagesController;
use Libaro\LaravelSlowQueries\Http\Controllers\SlowQueriesController;

Route::middleware(strval(config('slow-queries.middleware')))
    ->name('slow-queries.')
    ->prefix(strval(config('slow-queries.url_prefix')) . '/api')
    ->group(function () {
        Route::post('/timerange', TimeRangeController::class.'@store')
            ->name('api.timerange.store');

        Route::post('/query/rerun', RerunQueryController::class.'@store')
            ->name('api.query.rerun.store');
    });
