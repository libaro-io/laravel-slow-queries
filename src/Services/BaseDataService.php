<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;

// TODO : implement grouped by data methods with https://spatie.be/docs/laravel-data/v2/introduction
// so we can enforce the structure of that grouped data without having to make models for it

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
