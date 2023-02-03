<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

/**
 *
 */
class DashboardDataService
{

    /**
     * @var Carbon
     */
    protected Carbon $from;
    /**
     * @var Carbon
     */
    protected Carbon $to;

    /**
     * @var integer
     */
    protected int $numberOfItems;

    /**
     *
     */
    public function __construct()
    {
        $defaultDateRangeDays = intval(config('slow-queries.default_date_range'));
        $this->from = now()->subDays($defaultDateRangeDays);
        $this->to = now();

        $this->numberOfItems = intval(config('slow-queries.items_per_widget'));
    }

    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return DashboardDataService
     */
    public function setDateRange(Carbon $from, Carbon $to): self
    {
        $this->from = $from;
        $this->to = $to;

        return $this;
    }


    /**
     * @return Collection<int, SlowQuery>
     */
    public function getSlowestQueries(): Collection
    {
        // TODO: change query to only fetch the slowest query per query_without_bindings, but without using group by

        /**
         * @var Collection<int, SlowQuery> $slowestQueries
         */
        $slowestQueries = SlowQuery::query()
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
//            ->groupBy('query_without_bindings', 'uri')
            ->orderByDesc('duration')
            ->limit($this->numberOfItems)
//            ->selectRaw('query_without_bindings, uri, avg(duration) as duration, min(id) as id')
            ->get();

        return $slowestQueries;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function getSlowestPages(): \Illuminate\Support\Collection
    {
        // TODO : filter on date range
        $sql = /** @lang sql */
            <<<SQL
            select the_uri, avg(the_duration) as the_duration, avg(the_count) as the_count
            from
            (
                select request_guid, sum(duration) as the_duration, count(*) as the_count, min(uri) as the_uri
                from slow_queries
                group by request_guid
                order by 3 desc
            ) derived
            
            group by the_uri
            order by the_duration desc
            limit ?
SQL;

        $records = DB::select($sql, [$this->numberOfItems]);
        $collection = collect($records);

        return $collection;
    }

    /**
     * @return mixed
     */
    public function getAvgDuration(){
        $avgDuration = SlowQuery::query()
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->avg('duration');

        return $avgDuration;
    }
}
