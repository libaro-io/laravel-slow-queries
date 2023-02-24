<?php

use Illuminate\Support\Facades\Route;
use Libaro\LaravelSlowQueries\Http\Controllers\DashboardController;
use Libaro\LaravelSlowQueries\Http\Controllers\SlowPagesController;
use Libaro\LaravelSlowQueries\Http\Controllers\SlowQueriesController;

Route::middleware(strval(config('slow-queries.middleware')))
    ->name('slow-queries.')
    ->prefix(strval(config('slow-queries.url-prefix')))
    ->group(function () {
        Route::get('/', function () {
            return redirect(route('slow-queries.dashboard.show'));
        });

        /****************************************************************
         * Dashboard
         ****************************************************************/
        Route::get('/dashboard', DashboardController::class.'@show')
            ->name('dashboard.show');

        /****************************************************************
         * Slow Queries / grouped by hash
         ****************************************************************/
        Route::get('/slow-queries', SlowQueriesController::class.'@index')
            ->name('slow-queries.index');

        Route::get('/slow-queries/{slowQuery}', SlowQueriesController::class.'@show')
            ->name('slow-queries.show');

        /****************************************************************
         * Slow pages
         ****************************************************************/
        Route::get('/slow-pages', SlowPagesController::class.'@index')
            ->name('slow-pages.index');

        Route::get('/slow-pages/{slowPage}', SlowPagesController::class.'@show')
            ->name('slow-pages.show');
    });
