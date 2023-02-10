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
            ->selectRaw('avg(duration) as avgDuration');

        /** @phpstan-ignore-next-line */
        return $builder;
    }
}
