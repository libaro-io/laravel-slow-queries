<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class DashboardDataService
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
        $tenSlowestQueries = SlowQuery::query()
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->orderByDesc('duration')
            ->limit($this->numberOfItems)
            ->get();

        return $tenSlowestQueries;
    }

    public function getAvgDuration(){
        $avgDuration = SlowQuery::query()
            ->where('created_at', '>=', $this->from)
            ->where('created_at', '<=', $this->to)
            ->avg('duration');

        return $avgDuration;
    }
}
