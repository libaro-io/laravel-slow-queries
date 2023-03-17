<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Data\SlowQueryAggregation;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class SlowQueriesDataService extends BaseDataService
{
    /**
     * @return Collection<int, SlowQueryAggregation>
     *     fetches the slowest n queries, grouped by query_without_bindings
     */
    public function getSlowestQueriesAggregations(): Collection
    {
        /**
         * @var Collection<int, SlowQueryAggregation> $slowestQueriesAggregations
         */
        $slowestQueriesAggregations = $this
            ->getBaseQuery()
            ->orderByDesc('avgDuration')
            ->limit($this->numberOfItemsPerWidget)
            ->get();

        return $slowestQueriesAggregations;
    }

    /**
     * @return Collection<int, SlowQueryAggregation>
     */
    public function getAggregations()
    {
        /**
         * @var Collection<int, SlowQueryAggregation> $slowQueriesAggregations
         */
        $slowQueriesAggregations = $this
            ->getBaseQuery()
            ->orderByDesc('avgDuration')
            ->paginate($this->numberOfItemsPerPage);

        return $slowQueriesAggregations;
    }

    /**
     * @param string $uri
     * @return Collection<int, SlowQuery>
     */
    public function getSlowQueriesByUri(string $uri)
    {
        /**
         * @var Collection<int, SlowQuery> $slowQueries
         */
        $slowQueries = SlowQuery::query()
            ->where('uri', '=', $uri)
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->get();;

        return $slowQueries;
    }

    /**
     * @return SlowQueryAggregation|null
     */
    public function getSlowQueryAggregation(string $queryHashed)
    {
        /**
         * @var Collection<int, SlowQuery> $slowQueries
         */
        $slowQueries = SlowQuery::query()
            ->where('query_hashed', '=', $queryHashed)
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->get();

        if (!$slowQueries->count()) {
            return null;
        }

        $first = $slowQueries->first();

        $slowQueryAggregation = new SlowQueryAggregation();
        $slowQueryAggregation->queryHashed = $first->query_hashed ?? '';
        $slowQueryAggregation->uri = $first->uri ?? '';
        $slowQueryAggregation->sourceFile = $first->source_file ?? '';
        $slowQueryAggregation->minLine = intval($slowQueries->min('line'));
        $slowQueryAggregation->maxLine = intval($slowQueries->max('line'));
        $slowQueryAggregation->queryWithoutBindings = $first->query_without_bindings ?? '';
        $slowQueryAggregation->queryWithBindings = '';
        $slowQueryAggregation->minDuration = intval($slowQueries->min('duration'));
        $slowQueryAggregation->maxDuration = intval($slowQueries->max('duration'));
        $slowQueryAggregation->avgDuration = intval($slowQueries->avg('duration'));
        $slowQueryAggregation->queryCount = $slowQueries->count();

        $slowQueryAggregation->details = $slowQueries;

        return $slowQueryAggregation;
    }

    /**
     * @return Builder
     */
    private function getBaseQuery(): Builder
    {
        /** @var \Illuminate\Database\Eloquent\Builder $builder */
        $builder = SlowQuery::query()
            ->groupBy('query_hashed')
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->selectRaw('query_hashed as queryHashed')
            ->selectRaw('min(uri) as uri')
            ->selectRaw('min(source_file) as sourceFile')
            ->selectRaw('min(line) as minLine')
            ->selectRaw('max(line) as maxLine')
            ->selectRaw('min(query_without_bindings) as queryWithoutBindings')
            ->selectRaw('min(duration) as minDuration')
            ->selectRaw('max(duration) as maxDuration')
            ->selectRaw('avg(duration) as avgDuration')
            ->selectRaw('count(*) as queryCount');

        return $builder;
    }
}
