<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

// TODO : grouped by data methods implementeren met behulp van https://spatie.be/docs/laravel-data/v2/introduction
// zodat we de structuur van die grouped by data collections toch nog kunnen afdwingen / vastleggen zonder er models voor te moeten maken

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
    protected int $numberOfItemsPerWidget;
    /**
     * @var integer
     */
    protected int $numberOfItemsPerPage;

    /**
     *
     */
    public function __construct()
    {
        $defaultDateRangeDays = intval(config('slow-queries.default_date_range'));
        $this->from = now()->subDays($defaultDateRangeDays);
        $this->to = now();

        $this->numberOfItemsPerWidget = intval(config('slow-queries.items_per_widget'));
        $this->numberOfItemsPerPage = intval(config('slow-queries.items_per_page'));
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
     * @param int $days
     * @return void
     */
    public function setDateRangeInDays(int $days): void
    {

    }

    /**
     * @param int $numberOfItemsPerWidget
     * @return void
     */
    public function setNumberOfItemsPerWidget(int $numberOfItemsPerWidget): void
    {
        $this->numberOfItemsPerWidget = $numberOfItemsPerWidget;
    }

    /**
     * @param int $numberOfItemsPerPage
     * @return void
     */
    public function setNumberOfItemsPerPage(int $numberOfItemsPerPage): void
    {
        $this->numberOfItemsPerPage = $numberOfItemsPerPage;
    }
}
