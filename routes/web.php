<?php

use \Illuminate\Support\Facades\Route;

Route::middleware(config('slow-queries.middleware'))
    ->name('slow-queries')
    ->prefix(config('slow-queries.url-prefix'))
    ->group(function () {

    Route::get('/dashboard', 'Libaro\LaravelSlowQueries\Http\Controllers\DashboardController@show')
        ->name('dashboard.show');
});
