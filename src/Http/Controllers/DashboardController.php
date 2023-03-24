<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Libaro\LaravelSlowQueries\Services\DashboardDataService;
use Libaro\LaravelSlowQueries\Services\SlowPagesDataService;
use Libaro\LaravelSlowQueries\Services\SlowQueriesDataService;

class DashboardController extends Controller
{
    /**
     * @return bool|Response|Application|Factory|View|null
     */
    public function show(): View|Factory|Response|bool|Application|null
    {
        $dashboardDataService = new DashboardDataService();
        $slowestPages = (new SlowPagesDataService())->getSlowestPagesAggregation();

        return view('slow-queries::dashboard.show',
            [
                'slowestQueriesAggregations' => (new SlowQueriesDataService())->getSlowestQueriesAggregations(),
                'slowestPages' => $slowestPages,
                'avgDuration' => $dashboardDataService->getAvgDuration(),
                'slowestPagesHierarchy' => $dashboardDataService->getSlowestPagesHierarchy(($slowestPages)),
            ]);
    }
}
