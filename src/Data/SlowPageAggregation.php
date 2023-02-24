<?php

namespace Libaro\LaravelSlowQueries\Data;

/* data object to define the data for pages at the first level: grouped by same uri */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\Services\QueryHintService;
use SqlFormatter;

class SlowPageAggregation extends Model
{
    /**
     * @var string
     */
    public string $uri;
    /**
     * @var int
     */
    public int $duration;
    /**
     * @var int
     */
    public int $count;

    
//    /**
//     * @var Collection<int, SlowQuery>
//     */
//    public Collection $details;

}