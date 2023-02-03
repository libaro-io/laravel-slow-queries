<?php

use \Illuminate\Support\Facades\Route;

Route::middleware(config('slow-queries.middleware'))
    ->name('slow-queries.')
    ->prefix(config('slow-queries.url-prefix'))
    ->group(function () {

        Route::get('/', function () {
            return redirect(route('slow-queries.dashboard.show'));
        });

        /****************************************************************
         * Dashboard
         ****************************************************************/
        Route::get('/dashboard', 'Libaro\LaravelSlowQueries\Http\Controllers\DashboardController@show')
            ->name('dashboard.show');


        /****************************************************************
         * All Queries / raw data
         ****************************************************************/
        Route::get('/allqueries', 'Libaro\LaravelSlowQueries\Http\Controllers\AllQueriesController@index')
            ->name('allqueries.index');

        Route::get('/allqueries/{slowQuery}', 'Libaro\LaravelSlowQueries\Http\Controllers\AllQueriesController@show')
            ->name('allqueries.show');


        /****************************************************************
         * Slow Queries / grouped by hash
         ****************************************************************/
        Route::get('/slow-queries', 'Libaro\LaravelSlowQueries\Http\Controllers\SlowQueriesController@index')
            ->name('slow-queries.index');

        Route::get('/slow-queries/{slowQuery}', 'Libaro\LaravelSlowQueries\Http\Controllers\SlowQueriesController@show')
            ->name('slow-queries.show');


        /****************************************************************
         * Slow pages
         ****************************************************************/
        Route::get('/slow-pages', 'Libaro\LaravelSlowQueries\Http\Controllers\SlowPagesController@index')
            ->name('slow-pages.index');

        Route::get('/slow-pages/{slowPage}', 'Libaro\LaravelSlowQueries\Http\Controllers\SlowPagesController@show')
            ->name('slow-pages.show');
    });
