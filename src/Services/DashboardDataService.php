<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class DashboardDataService
{
    protected Carbon $from;

    protected Carbon $to;

    protected int $numberOfItems;

    public function __construct()
    {
        $defaultDateRangeDays = intval(config('slow-queries.default_date_range'));
        $this->from = now()->subDays($defaultDateRangeDays);
        $this->to = now();

        $this->numberOfItems = intval(config('slow-queries.items_per_widget'));
    }

    /**
     * @return mixed
     */
    public function getAvgDuration()
    {
        $avgDuration = SlowQuery::query()
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->avg('duration');

        return $avgDuration;
    }
}
