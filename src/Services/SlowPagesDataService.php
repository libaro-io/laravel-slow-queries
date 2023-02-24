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

        return $slowestPagesAggregation;
    }

    /**
     * @return Builder
     */
    private function getBaseQuery(): Builder
    {
        $builder = SlowPage::query()
            ->selectRaw('the_uri')
            ->selectRaw('avg(the_duration) as avgDuration')
            ->selectRaw('avg(the_count) as the_count')
            ->groupBy('the_uri');

        /** @phpstan-ignore-next-line */
        return $builder;
    }
}
