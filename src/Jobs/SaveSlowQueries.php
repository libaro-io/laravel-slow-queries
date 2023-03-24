<?php

namespace Libaro\LaravelSlowQueries\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class SaveSlowQueries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Collection<int, SlowQuery>
     */
    public Collection $slowQueries;

    /**
     * @param Collection<int, SlowQuery> $slowQueries
     */
    public function __construct(Collection $slowQueries)
    {
        $this->slowQueries = $slowQueries;
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
                &&
                !$this->isMetaQuery($slowQuery)
            ) {
                $slowQuery->save();
            }
        }
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
            str_contains($slowQuery->source_file, 'laravel-slow-queries');
    }
}
