<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\Services\DashboardDataService;
use Libaro\LaravelSlowQueries\Services\SlowQueriesDataService;

class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function show(): View|Factory|Application
    {
        /** @phpstan-ignore-next-line */
        $queries = SlowQuery::paginate();
        
        $dashboardDataService = new DashboardDataService();

        /** @phpstan-ignore-next-line */
        return view('slow-queries::dashboard.show')
            ->with([
//                'queries' => $queries,
                'slowestQueriesAggregations' => (new SlowQueriesDataService())->getSlowestQueriesAggregations(),
                'slowestPages' => $dashboardDataService->getSlowestPages(),
                'avgDuration' => $dashboardDataService->getAvgDuration(),
            ]);
    }
}
