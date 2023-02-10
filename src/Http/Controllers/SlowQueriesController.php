<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\Services\SlowQueriesDataService;

class SlowQueriesController extends Controller
{
    public function index(): Factory|View
    {
        $slowQueriesDataService = new SlowQueriesDataService();
        $slowQueriesDataService->setNumberOfItems(999);
        $slowQueriesDataService->setDateRange(now()->subMonth(), now());

        $slowQueries = $slowQueriesDataService->get();



        return view('slow-queries::slow-queries.index', compact('slowQueries'));
    }

    public function show(SlowQuery $slowQuery): Factory|View
    {
        return view('slow-queries::slow-queries.show', ['slowQuery' => $slowQuery]);
    }
}
