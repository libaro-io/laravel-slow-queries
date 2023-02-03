<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

// TODO : refactore : create base class for the common methods

/**
 *
 */
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
     * @return void
     */
    public function setDateRange(Carbon $from, Carbon $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @param int $numberOfItems
     * @return void
     */
    public function setNumberOfItems(int $numberOfItems)
    {
        $this->numberOfItems = $numberOfItems;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function getSlowestPages()
    {
        // TODO : filter on date range
        $sql = /** @lang sql */
            <<<SQL
            select the_uri, avg(the_duration) as the_duration, avg(the_count) as the_count, max(request_guid) as the_guid
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
}
