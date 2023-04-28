<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Libaro\LaravelSlowQueries\Data\SlowPageAggregation;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\ValueObjects\TimeRanges;

class TimeRangeService
{

    public function __construct()
    {

    }

    /**
     * @return int
     */
    public static function getCurrentTimeRange(): int
    {
        $timerange = 0;
        // Check if the timerange is set in the session
        if (Session::has('timeRange')) {
            $timerange = intval(session('timeRange'));
        }
        if($timerange === 0){
            // If the timerange is not set in the session, get the default value from the configuration
            $timerange = intval(config('app.default_timerange'));
        }
        if($timerange === 0){
            $timerange = 60*24;      // if not timerange is set anywhere: set it hardcoded to a day
        }

        return $timerange;
    }

    /**
     * @return string
     */
    public static function getCurrentTimeRangeLabel(): string
    {
        $minutes = self::getCurrentTimeRange();
        $label = strval(TimeRanges::getValids()[$minutes]['label']);

        return $label;
    }
}