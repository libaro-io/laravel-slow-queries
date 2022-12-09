<?php

use \Illuminate\Support\Facades\Route;

Route::middleware(config('slow-queries.middleware'))
    ->name('slow-queries.')
    ->prefix(config('slow-queries.url-prefix'))
    ->group(function () {

        Route::get('/', function () {
            return redirect(route('slow-queries.dashboard.show'));
        });

        Route::get('/dashboard', 'Libaro\LaravelSlowQueries\Http\Controllers\DashboardController@show')
            ->name('dashboard.show');

        Route::get('/queries', 'Libaro\LaravelSlowQueries\Http\Controllers\SlowQueriesController@index')
            ->name('queries.index');

        Route::get('/queries/{slowQuery}', 'Libaro\LaravelSlowQueries\Http\Controllers\SlowQueriesController@show')
            ->name('queries.show');
    });
