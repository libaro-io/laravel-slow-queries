<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Data\SlowPageAggregation;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class TimeRangeService
{

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getTimeRange()
    {
        // Check if the timerange is set in the session
        if (session()->has('timerange')) {
            $timerange = session('timerange');
        } else {
            // If the timerange is not set in the session, get the default value from the configuration
            $timerange = config('app.default_timerange');
        }

        return $timerange;
    }


}