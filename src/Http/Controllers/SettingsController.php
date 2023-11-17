<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Libaro\LaravelSlowQueries\Jobs\SaveSlowQueries;
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
            'default_time_range' => [
                'name' => 'default_time_range',
                'description' => 'default time range, IN MINUTES',
                'value' => config('slow-queries.default_time_range')
            ],
            'exclude_routes' => [
                'name' => 'exclude_routes',
                'description' => 'exclude_routes',
                'value' => config('slow-queries.exclude_routes')
            ],
            'current cpu load: dynamic value' => [
                'name' => 'current cpu load: dynamic value',
                'description' => 'current cpu load: dynamic value',
                'value' => (new SaveSlowQueries(collect([])))->getLoad()
            ],
            'delay_jobs_when_load_is_higher_than' => [
                'name' => 'delay_jobs_when_load_is_higher_than',
                'description' => 'when cpu load is higher than this value, backoff the job that saves queries for a while (see jobs_delay)',
                'value' => config('slow-queries.delay_jobs_when_load_is_higher_than')
            ],
            'jobs_delay' => [
                'name' => 'jobs_delay',
                'description' => 'when cpu load is higher than a certain value (see delay_jobs_when_load_is_higher_than), backoff the job that saves queries for a certain amount of minutes; number of minutes is higher when this value is higher',
                'value' => config('slow-queries.jobs_delay')
            ],
        ];

        return view('slow-queries::settings.index', ['settings' => $settings]);
    }
}
