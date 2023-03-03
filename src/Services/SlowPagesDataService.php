<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Data\SlowPageAggregation;
use Libaro\LaravelSlowQueries\Models\SlowPage;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

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
         * @var Collection<int, SlowPageAggregation> $slowPagesAggregations
         */
        $slowPagesAggregations = $this
            ->getBaseQuery()
            ->orderByDesc('avgDuration')
            ->paginate($this->numberOfItemsPerPage);

        return $slowPagesAggregations;
    }


    /**
     * @param string $uri
     * @return ?SlowPageAggregation
     */
    public function getSlowPageAggregation(string $uri): ?SlowPageAggregation
    {
        /**
         * @var Collection<int, SlowPage> $slowPages
         */
        $slowPages = SlowPage::query()
            ->where('the_uri', '=', $uri)
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->get();

        if (!$slowPages->count()) {
            return null;
        }

        /**
         * @var SlowPageAggregation $data
         */
        $data = $this
            ->getBaseQuery()
            ->where('the_uri', '=', $uri)
            ->first();

        $slowPageAggregation = new SlowPageAggregation();
        $slowPageAggregation->uri = $data->uri;
        $slowPageAggregation->count = $data->count;
        $slowPageAggregation->avgQueryCount = $data->avgQueryCount;
        $slowPageAggregation->avgDuration = $data->avgDuration;

        $slowPageAggregation->details = $slowPages;

//        dd($slowPageAggregation);

        return $slowPageAggregation;
    }

    /**
     * @return Builder
     */
    private function getBaseQuery(): Builder
    {
        /** @var \Illuminate\Database\Eloquent\Builder $builder */
        $builder = SlowPage::query()
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->selectRaw('the_uri as uri')
            ->selectRaw('avg(the_page_duration) as avgDuration')
            ->selectRaw('round(avg(the_query_count), 0) as avgQueryCount')
            ->selectRaw('count(*) as count')
            ->groupBy('the_uri');

        return $builder;
    }
}
