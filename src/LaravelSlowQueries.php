<?php

namespace Libaro\LaravelSlowQueries;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class LaravelSlowQueries
{

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var SlowQuery
     */
    private SlowQuery $slowQuery;

    /**
     * @return bool
     */
    public function isPackageEnabled(): bool
    {
        return (bool)config('slow-queries.enabled');
    }

    /**
     * @return float
     */
    public function getSlowerThan(): float
    {
        $slowerThan = config('slow-queries.log_queries_slower_than');
        return is_numeric($slowerThan) ? (float)$slowerThan : 0;
    }

    /**
     * @return void
     */
    public function startListening()
    {
        DB::listen(function (QueryExecuted $queryExecuted) {
            $this->setRequest();

            $this->slowQuery = $this->getDataFromQueryExecuted($queryExecuted);
            $this->saveSlowQuery();
        });
    }

    /**
     * @return void
     */
    private function saveSlowQuery(): void
    {
        if ($this->isQuerySlow() && !$this->isQueryMetaQuery()) {
            $this->slowQuery->save();
        }
    }

    /**
     * @return void
     */
    private function setRequest(): void
    {
        $request = request();

        if ($request instanceof Request) {
            $this->request = $request;
        }
    }

    /**
     * @param QueryExecuted $queryExecuted
     * @return SlowQuery
     */
    private function getDataFromQueryExecuted(QueryExecuted $queryExecuted): SlowQuery
    {
        $slowQuery = new SlowQuery();
        $slowQuery->uri = $this->getUri();
        $slowQuery->action = $this->getAction();
        $slowQuery->query = $this->getQueryWithParams($queryExecuted);
        $slowQuery->duration = $this->getDuration($queryExecuted);

        return $slowQuery;
    }

    /**
     * @param QueryExecuted $query
     * @return string
     */
    private function getQueryWithParams(QueryExecuted $query): string
    {
        return Str::replaceArray('?', $query->bindings, $query->sql);
    }

    /**
     * @return string
     */
    private function getUri(): string
    {
        return $this->request->getRequestUri();
    }

    /**
     * @return string
     */
    private function getAction(): string
    {
        return '';
    }

    /**
     * @param QueryExecuted $query
     * @return float
     */
    private function getDuration(QueryExecuted $query): float
    {
        return $query->time;
    }

    /**
     * @return bool
     */
    private function isQuerySlow(): bool
    {
        return $this->slowQuery->duration >= $this->getSlowerThan();
    }

    private function isQueryMetaQuery(): bool
    {
        return str_contains($this->slowQuery->query, 'slow_queries');
    }


}
