<?php

namespace Libaro\LaravelSlowQueries\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class SaveSlowQueries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Collection<int, SlowQuery>
     */
    public Collection $slowQueries;
    /**
     * @var Collection<int, string>
     */
    protected Collection $excludedRoutes;

    /**
     * @param Collection<int, SlowQuery> $slowQueries
     */
    public function __construct(Collection $slowQueries)
    {
        $this->slowQueries = $slowQueries;
        $this->excludedRoutes = $this->getExcludeRoutes();
    }

    public function handle(): void
    {
        $isPageSlow = $this->isPageSlow();

        foreach ($this->slowQueries as $slowQuery) {
            if (
                (
                    $isPageSlow
                    || $this->isQuerySlow($slowQuery)
                    || $this->hasManyQueries()
                )
                && !$this->isMetaQuery($slowQuery)
                && !$this->isExcluded($slowQuery)
            ) {
                $slowQuery->save();
            }
        }
    }

    /**
     * @return Collection<int, string>
     */
    public function getExcludeRoutes(): Collection
    {
        $paths = config('slow-queries.exclude_paths');
        $excludePaths = collect();

        if ($paths && is_string($paths)) {
            $pathsArray = explode(',', $paths);
            $excludePaths = collect(array_map('strval', $pathsArray));
        }

        return $excludePaths;

    }

    public function getQueriesSlowerThan(): float
    {
        $queriesSlowerThan = config('slow-queries.log_queries_slower_than');

        return is_numeric($queriesSlowerThan) ? (float)$queriesSlowerThan : 0;
    }

    public function getPagesSlowerThan(): float
    {
        $pagesSlowerThan = config('slow-queries.log_pages_slower_than');

        return is_numeric($pagesSlowerThan) ? (float)$pagesSlowerThan : 0;
    }

    private function isQuerySlow(SlowQuery $slowQuery): bool
    {
        return $slowQuery->duration >= $this->getQueriesSlowerThan();
    }

    private function isPageSlow(): bool
    {
        $pageDuration = $this->slowQueries->sum('duration');
        $pagesSlowerThan = $this->getPagesSlowerThan();

        return ($pageDuration >= $pagesSlowerThan);
    }

    /**
     * @return bool
     */
    private function hasManyQueries()
    {
        $moreThan = config('slow-queries.log_queries_more_than');

        return $this->slowQueries->count() > $moreThan;
    }

    private function isMetaQuery(SlowQuery $slowQuery): bool
    {
        return
            str_contains($slowQuery->query_without_bindings, 'slow_queries')
            ||
            str_contains($slowQuery->source_file, 'laravel-slow-queries')
            ||
            str_contains($slowQuery->uri, config('slow-queries.url_prefix'))
            ||
            str_contains($slowQuery->action, 'LaravelSlowQueries')
            ||
            str_contains($slowQuery->route, 'slow-queries')
            ;
    }

    private function isExcluded(SlowQuery $slowQuery): bool
    {
        $isExcluded = false;

        foreach ($this->excludedRoutes as $excludedRoute) {
            if($excludedRoute === $slowQuery->route){
                $isExcluded = true;
            }
        }

        return $isExcluded;
    }
}
