<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Libaro\LaravelSlowQueries\Data\SlowQueryData;
use Libaro\LaravelSlowQueries\Models\SlowQuery;


/**
 *
 */
class SlowQueriesDataService extends BaseDataService
{
    /**
     * @return Collection<int, SlowQueryData>
     *     fetches the slowest n queries, grouped by query_without_bindings
     */
    public function getSlowestQueries(): Collection
    {
        /**
         * @var Collection<int, SlowQueryData> $slowestQueries
         */
        $slowestQueries = $this
            ->getBaseQuery()
            ->orderByDesc('avgDuration')
            ->limit($this->numberOfItems)
            ->get();

        return $slowestQueries;
    }

    /**
     * @return Collection<int, SlowQueryData>
     *     fetches the slowest n queries, grouped by query_without_bindings
     */
    public function get(): Collection
    {
        /**
         * @var Collection<int, SlowQueryData> $slowQueries
         */
        $slowQueries = $this
            ->getBaseQuery()
            ->orderByDesc('avgDuration')
//            ->paginate(10)
            ->get();

        return $slowQueries;
    }


    /**
     * @param string $queryHashed
     * @return SlowQueryData|null
     */
    public function getWithDetails(string $queryHashed)
    {
        /**
         * @var Collection<int, SlowQuery> $slowQueries
         */
        $slowQueries = SlowQuery::query()
            ->where('query_hashed', '=', $queryHashed)
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->get();

        if(!$slowQueries->count()){
            return null;
        }

        $first = $slowQueries->first();

        $slowQueryData = new SlowQueryData();
        $slowQueryData->queryHashed = $first->query_hashed ?? '';
        $slowQueryData->uri = $first->uri ?? '';
        $slowQueryData->sourceFile = $first->source_file ?? '';
        $slowQueryData->minLine = intval($slowQueries->min('line'));
        $slowQueryData->maxLine = intval($slowQueries->max('line'));
        $slowQueryData->queryWithoutBindings = $first->query_without_bindings ?? '';
        $slowQueryData->queryWithBindings = '';
        $slowQueryData->minDuration = intval($slowQueries->min('duration'));
        $slowQueryData->maxDuration = intval($slowQueries->max('duration'));
        $slowQueryData->avgDuration = intval($slowQueries->avg('duration'));
        $slowQueryData->queryCount = $slowQueries->count();

        $slowQueryData->details = $slowQueries;
        return $slowQueryData;
    }

    /**
     * @return Builder
     */
    private function getBaseQuery(): Builder
    {
        $builder = SlowQuery::query()
            ->groupBy('query_hashed', 'uri')
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->selectRaw('query_hashed as queryHashed')
            ->selectRaw('uri')
            ->selectRaw('min(source_file) as sourceFile')
            ->selectRaw('min(line) as minLine')
            ->selectRaw('max(line) as maxLine')
            ->selectRaw('min(query_without_bindings) as queryWithoutBindings')
            ->selectRaw('min(duration) as minDuration')
            ->selectRaw('max(duration) as maxDuration')
            ->selectRaw('avg(duration) as avgDuration')
            ->selectRaw('count(*) as queryCount')
        ;

        /** @phpstan-ignore-next-line */
        return $builder;
    }
}
