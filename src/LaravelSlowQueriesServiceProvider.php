<?php

namespace Libaro\LaravelSlowQueries;

use Illuminate\Support\ServiceProvider;

class LaravelSlowQueriesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/slow-queries.php' => config_path('slow-queries.php'),
            ], 'slow-queries-config');

            $this->publishes([
                __DIR__ . '/../resources/assets' => public_path('laravel-slow-queries'),
            ], 'slow-queries-assets');

            if (!class_exists('CreateSlowQueriesTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_slow_queries_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_slow_queries_table.php'),
                ], 'slow-queries-migrations');
            }

            if (!class_exists('CreateSlowPagesView')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_slow_pages_view.php.stub' => database_path('migrations/' . date('Y_m_d_His', time() + 5) . '_create_slow_pages_view.php'),
                ], 'slow-queries-migrations');
            }
        }

        $this->startListeningWhenEnabled();
        $this->registerRoutes();
        $this->registerViews();
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/slow-queries.php', 'slow-queries');
    }

    public function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    public function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'slow-queries');
    }

    private function startListeningWhenEnabled(): void
    {
        $laravelSlowQueries = new LaravelSlowQueries();
        if ($laravelSlowQueries->isPackageEnabled()) {
            $laravelSlowQueries->startListening();
        }
    }
}
