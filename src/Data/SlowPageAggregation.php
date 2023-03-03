<?php

namespace Libaro\LaravelSlowQueries\Data;

/* data object to define the data for pages at the first level: grouped by same uri */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Models\SlowPage;

class SlowPageAggregation extends Model
{
    public string $uri;

    public int $avgDuration;

    public int $avgQueryCount;

    public int $count;

    /**
     * @var Collection<int, SlowPage>
     */
    public Collection $details;
}
