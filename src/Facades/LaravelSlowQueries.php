<?php

namespace libaro\LaravelSlowQueries\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \libaro\LaravelSlowQueries\LaravelSlowQueries
 */
class LaravelSlowQueries extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-slow-queries';
    }
}
