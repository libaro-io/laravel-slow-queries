<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Libaro\LaravelSlowQueries\Models\SlowQuery;


class SlowPagesDataService extends BaseDataService
{
    
    /**
     * @return Collection<int, mixed>
     */
    public function get(): Collection
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

        $records = DB::select($sql, [$this->numberOfItemsPerWidget]);
        $collection = collect($records);

        return $collection;
    }
}
