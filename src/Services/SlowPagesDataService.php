<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Data\SlowPageAggregation;
use Libaro\LaravelSlowQueries\Data\SlowQueryAggregation;
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
     * @return Collection<int, SlowPageAggregation>
     */
    public function getAggregations()
    {
        /**
         * @var Collection<int, SlowPageAggregation> $slowPagesAggregation
         */
        $slowPagesAggregations = $this
            ->getBaseQuery()
            ->orderByDesc('avgDuration')
            ->paginate($this->numberOfItemsPerPage);

        return $slowPagesAggregations;
    }

    public function getSlowPageAggregation(string $uriHashed)
    {
        $slowPageAggregation = new SlowPageAggregation();
        $slowPageAggregation->uri = 'test';
        $slowPageAggregation->avgDuration = 10;
        $slowPageAggregation->queryCount = 17;
        $slowPageAggregation->count =  60;

        return $slowPageAggregation;
    }

    private function getBaseQuery(): Builder
    {
        $builder = SlowPage::query()
            ->selectRaw('the_uri as uri')
            ->selectRaw('avg(the_page_duration) as avgDuration')
            ->selectRaw('round(avg(the_query_count), 0) as avgQueryCount')
            ->selectRaw('count(*) as count')
            ->groupBy('the_uri');

        /** @phpstan-ignore-next-line */
        return $builder;
    }
}
