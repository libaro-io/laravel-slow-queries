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

        if (!class_exists('CreateSlowQueriesTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_slow_queries_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_slow_queries_table.php'),
            ], 'migrations');
        }

        $this->startListeningWhenEnabled();
        $this->registerRoutes();
//        $this->registerTerminating();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/slow-queries.php', 'slow-queries');
    }

    public function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * @return void
     */
    private function startListeningWhenEnabled(): void
    {
        $laravelSlowQueries = new LaravelSlowQueries();
        if ($laravelSlowQueries->isPackageEnabled()) {
            $laravelSlowQueries->startListening();
        }
    }
}
