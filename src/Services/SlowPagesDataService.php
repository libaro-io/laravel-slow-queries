<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class SlowPagesDataService
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
     * @var int|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    protected int $numberOfItems;

    /**
     *
     */
    public function __construct()
    {
        $defaultDateRangeDays = config('slow-queries.default_date_range');
        $this->from = now()->subDays($defaultDateRangeDays);
        $this->to = now();

        $this->numberOfItems = config('slow-queries.items_per_widget');
    }

    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return void
     */
    public function setDateRange(Carbon $from, Carbon $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getSlowestQueries(): \Illuminate\Database\Eloquent\Collection|array
    {
        // TODO: change query to only fetch the slowest query per query_without_bindings, but without using group by

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
    public function getSlowestPages()
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
