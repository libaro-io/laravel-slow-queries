<?php
// config for libaro/LaravelSlowQueries
return [
    'enabled' => env('LARAVEL_SLOW_QUERIES_ENABLED', false),                            // disabled by default
    'debug' => env('LARAVEL_SLOW_QUERIES_DEBUG', false),                                // disabled by default
    'log_queries_slower_than' => env('LARAVEL_SLOW_QUERIES_LOG_SLOWER_THAN', 500),       // log queries that are slower than x,  in miliseconds
    'log_queries_more_than' => env('LARAVEL_SLOW_QUERIES_LOG_MORE_THAN', 50),           // log queries if there are more than x in the request
    'middleware' => 'web',
    'url-prefix' => '/slow-queries',

    'items_per_widget' => env('LARAVEL_SLOW_QUERIES_ITEMS_PER_WIDGET', 5),                           // number of items to show in a dashboard widget
    'default_date_range' => env('LARAVEL_SLOW_QUERIES_DEFAULT_DATE_RANGE', 14),                           // default date range, in days
];
