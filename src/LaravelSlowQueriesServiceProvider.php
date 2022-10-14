<?php

namespace Libaro\LaravelSlowQueries; 

use Illuminate\Support\ServiceProvider;

class LaravelSlowQueriesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/slow-queries.php' => config_path('slow-queries.php'),
        ], 'slow-queries');

        (new LaravelSlowQueries())->startListeningWhenEnabled();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/slow-queries.php', 'slow-queries');
    }

}
