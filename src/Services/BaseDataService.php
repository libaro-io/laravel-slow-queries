<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BaseDataService
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
    public function setDateRange(Carbon $from, Carbon $to): void
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @param int $numberOfItems
     * @return void
     */
    public function setNumberOfItems(int $numberOfItems): void
    {
        $this->numberOfItems = $numberOfItems;
    }


}
