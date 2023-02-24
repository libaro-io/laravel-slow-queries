<?php

namespace Libaro\LaravelSlowQueries\Data;

/* data object to define the data for pages at the first level: grouped by same uri */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class SlowPageAggregation extends Model
{
    public string $uri;

    public int $avgDuration;

    public int $queryCount;

//    /**
//     * @var Collection<int, SlowQuery>
//     */
//    public Collection $details;
}
