<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Libaro\LaravelSlowQueries\LaravelSlowQueries;
use Libaro\LaravelSlowQueries\Services\SlowPagesDataService;

class SettingsController extends Controller
{
    public function index(): Factory|View
    {
        $settings = [
            'enabled' => [
                'name' => 'enabled',
                'description' => 'is the package enabled or not',
                'value' =>  (new LaravelSlowQueries())->isPackageEnabled()
            ],
            'log_queries_slower_than' => [
                'name' => 'log_queries_slower_than',
                'description' => 'log queries that are slower than x,  IN MILISECONDS',
                'value' => config('slow-queries.log_queries_slower_than')
            ],
            'log_queries_more_than' => [
                'name' => 'log_queries_more_than',
                'description' => 'log queries if there are more than x in the request/page',
                'value' => config('slow-queries.log_queries_more_than')
            ],
            'log_pages_slower_than' => [
                'name' => 'log_pages_slower_than',
                'description' => 'log queries if sum of all queries on the page is slower than x, in miliseconds',
                'value' => config('slow-queries.log_pages_slower_than')
            ],
            'middleware' => [
                'name' => 'middleware',
                'description' => 'which middleware to use to secure the admin pages of the package',
                'value' => config('slow-queries.middleware')
            ],
            'url_prefix' => [
                'name' => 'url_prefix',
                'description' => 'url to use for the package dashboard and admin pages',
                'value' => config('slow-queries.url_prefix')
            ],
            'default_date_range' => [
                'name' => 'default_date_range',
                'description' => 'default date range, IN DAYS',
                'value' => config('slow-queries.default_date_range')
            ],
            'exclude_routes' => [
                'name' => 'exclude_routes',
                'description' => 'exclude_routes',
                'value' => config('slow-queries.exclude_routes')
            ],
        ];

        return view('slow-queries::settings.index', compact('settings'));
    }
}
