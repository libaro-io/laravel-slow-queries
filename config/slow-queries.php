<?php

// config for libaro/LaravelSlowQueries
return [
    'enabled' => env('LARAVEL_SLOW_QUERIES_ENABLED', false),                                    // disabled by default
    'debug' => env('LARAVEL_SLOW_QUERIES_DEBUG', false),                                        // disabled by default
    'log_queries_slower_than' => env('LARAVEL_SLOW_QUERIES_LOG_QUERIES_SLOWER_THAN', 500),      // log queries that are slower than x,  IN MILISECONDS
    'log_queries_more_than' => env('LARAVEL_SLOW_QUERIES_LOG_QUERIES_MORE_THAN', 50),           // log queries if there are more than x in the request
    'log_pages_slower_than' => env('LARAVEL_SLOW_QUERIES_LOG_PAGES_SLOWER_THAN', 1000),         // log queries if all queries on the page are slower than x, in miliseconds

    'middleware' => env('LARAVEL_SLOW_QUERIES_MIDDLEWARE', 'web'),
    'url_prefix' => env('LARAVEL_SLOW_QUERIES_URL_PREFIX', '/laravel-slow-queries'),

    'items_per_widget' => env('LARAVEL_SLOW_QUERIES_ITEMS_PER_WIDGET', 5),                      // number of items to show in a dashboard widget
    'items_per_page' => env('LARAVEL_SLOW_QUERIES_ITEMS_PER_PAGE', 20),                          // number of items to show per page

    'default_date_range' => env('LARAVEL_SLOW_QUERIES_DEFAULT_DATE_RANGE', 14),                 // default date range, IN DAYS
];
