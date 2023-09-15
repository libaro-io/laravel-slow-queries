<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Data\SlowPageAggregation;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class DashboardDataService extends BaseDataService
{

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

    /**
     * @param Collection<int, SlowPageAggregation> $slowestPages
     * @return mixed
     */
    public function getSlowestPagesHierarchy(Collection $slowestPages)
    {
        $data = $slowestPages->map(function ($item, $key) {
            return [
                'name' => 'node' . ($this->numberOfItemsPerWidget - $key),
                'children' => [[
                    'name' => $item->uri === '/' ? '/ (home)' : $item->uri,
                    'value' => ceil($item->avgDuration),
                    'url' => $item->uri,
                ]]
            ];
        });

        return $data;
    }
}