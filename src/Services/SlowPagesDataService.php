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

        if (! $slowPages->count()) {
            return null;
        }

        /**
         * @var SlowPageAggregation $slowPageAggregation
         */
        $slowPageAggregation = $this
            ->getBaseQuery()
            ->where('the_uri', '=', $uri)
            ->first();

//        if($slowPageAggregation->count()){
            $slowPageAggregation->details = $slowPages;
//        }

        return $slowPageAggregation;
    }

    /**
     * @return Builder
     */
    private function getBaseQuery(): Builder
    {
        $builder = SlowPage::query()
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->selectRaw('the_uri as uri')
            ->selectRaw('avg(the_page_duration) as avgDuration')
            ->selectRaw('round(avg(the_query_count), 0) as avgQueryCount')
            ->selectRaw('count(*) as count')
            ->groupBy('the_uri');

        /** @phpstan-ignore-next-line */
        return $builder;
    }
}
