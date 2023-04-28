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
        // Check if the timerange is set in the session
        if (Session::has('timeRange')) {
            $timerange = intval(session('timeRange'));
        } else {
            // If the timerange is not set in the session, get the default value from the configuration
            $timerange = intval(config('app.default_timerange'));
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