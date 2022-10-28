<?php
// config for libaro/LaravelSlowQueries
return [
    'enabled' => env('LARAVEL_SLOW_QUERIES_ENABLED', false),                            // disabled by default
    'debug' => env('LARAVEL_SLOW_QUERIES_DEBUG', false),                                // disabled by default
    'log_queries_slower_than' => env('LARAVEL_SLOW_QUERIES_LOG_SLOWER_THAN', 10)       // log queries that are slower than x,  in miliseconds
];
