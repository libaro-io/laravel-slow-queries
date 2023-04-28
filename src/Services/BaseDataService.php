<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;

// TODO : grouped by data methods implementeren met behulp van https://spatie.be/docs/laravel-data/v2/introduction
// zodat we de structuur van die grouped by data collections toch nog kunnen afdwingen / vastleggen zonder er models voor te moeten maken

class BaseDataService
{
    protected Carbon $from;

    protected Carbon $to;

    protected int $numberOfItemsPerWidget;

    protected int $numberOfItemsPerPage;

    public function __construct()
    {
        $defaultTimeRangeMinutes = TimeRangeService::getCurrentTimeRange();
        $this->from = now()->subMinutes($defaultTimeRangeMinutes);
        $this->to = now();

        $this->numberOfItemsPerWidget = intval(config('slow-queries.items_per_widget'));
        $this->numberOfItemsPerPage = intval(config('slow-queries.items_per_page'));
    }

    public function setDateRange(Carbon $from, Carbon $to): void
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function setDateRangeInDays(int $days): void
    {
    }

    public function setNumberOfItemsPerWidget(int $numberOfItemsPerWidget): void
    {
        $this->numberOfItemsPerWidget = $numberOfItemsPerWidget;
    }

    public function setNumberOfItemsPerPage(int $numberOfItemsPerPage): void
    {
        $this->numberOfItemsPerPage = $numberOfItemsPerPage;
    }
}
