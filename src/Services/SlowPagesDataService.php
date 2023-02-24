<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Data\SlowPageAggregation;
use Libaro\LaravelSlowQueries\Models\SlowPage;

class SlowPagesDataService extends BaseDataService
{
    /**
     * @return Collection<int, SlowPageAggregation>
     */
    public function getSlowestPagesAggregation(): Collection
    {
        /**
         * @var Collection<int, SlowPageAggregation> $slowestPagesAggregation
         */
        $slowestPagesAggregation = $this
            ->getBaseQuery()
            ->orderByDesc('avgDuration')
            ->limit($this->numberOfItemsPerWidget)
            ->get();

//        dd($slowestPagesAggregation);

        return $slowestPagesAggregation;
    }

    /**
     * @return Collection<int, SlowPageAggregation>
     */
    public function getAggregations()
    {
        /**
         * @var Collection<int, SlowPageAggregation> $slowPagesAggregation
         */
        $slowPagesAggregation = $this
            ->getBaseQuery()
            ->orderByDesc('avgDuration')
            ->paginate($this->numberOfItemsPerPage);

        return $slowPagesAggregation;
    }

    private function getBaseQuery(): Builder
    {
        $builder = SlowPage::query()
            ->selectRaw('the_uri as uri')
            ->selectRaw('avg(the_duration) as avgDuration')
            ->selectRaw('round(avg(the_count), 0) as queryCount')
            ->groupBy('the_uri');

        /** @phpstan-ignore-next-line */
        return $builder;
    }
}
