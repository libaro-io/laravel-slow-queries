<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class DashboardController extends Controller
{
    public function show():  Factory|View
    {
        /** @phpstan-ignore-next-line */
        $queries = SlowQuery::paginate();

        $itemsPerWidget = config('slow-queries.items_per_widget');

        $tenSlowestQueries = SlowQuery::query()
            ->orderByDesc('duration')
            ->limit(10)
            ->get();
        
        return view('slow-queries::dashboard.show')
            ->with([
                'queries' => $queries,
                'tenSlowestQueries' => $tenSlowestQueries,
            ]);
    }
}
