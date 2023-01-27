<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\Services\DashboardDataService;

class DashboardController extends Controller
{
    public function show():  Factory|View
    {
        /** @phpstan-ignore-next-line */
        $queries = SlowQuery::paginate();

        $itemsPerWidget = config('slow-queries.items_per_widget');

        $dashboardDataService = new DashboardDataService();


        return view('slow-queries::dashboard.show')
            ->with([
                'queries' => $queries,
                'tenSlowestQueries' => $dashboardDataService->getSlowestQueries(),
                'avgDuration' => $dashboardDataService->getAvgDuration(),
            ]);
    }
}
