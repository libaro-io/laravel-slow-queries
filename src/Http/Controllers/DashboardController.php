<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Libaro\LaravelSlowQueries\Services\DashboardDataService;
use Libaro\LaravelSlowQueries\Services\SlowPagesDataService;
use Libaro\LaravelSlowQueries\Services\SlowQueriesDataService;

class DashboardController extends Controller
{
    public function show(): View|Factory|Application
    {
        $dashboardDataService = new DashboardDataService();

        /** @phpstan-ignore-next-line */
        return view('slow-queries::dashboard.show')
            ->with([
                //                'queries' => $queries,
                'slowestQueriesAggregations' => (new SlowQueriesDataService())->getSlowestQueriesAggregations(),
                'slowestPages' => (new SlowPagesDataService())->getSlowestPagesAggregation(),
                'avgDuration' => $dashboardDataService->getAvgDuration(),
            ]);
    }
}
