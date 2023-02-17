<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Libaro\LaravelSlowQueries\Data\SlowQueryAggregation;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\Services\SlowQueriesDataService;

class SlowQueriesController extends Controller
{
    public function index(): Factory|View
    {
        $slowQueriesDataService = new SlowQueriesDataService();
        $slowQueries = $slowQueriesDataService->getAggregations();

        return view('slow-queries::slow-queries.index', compact('slowQueries'));
    }

    public function show(string $queryHashed): Factory|View
    {
        $slowQueriesDataService = new SlowQueriesDataService();
        $slowQueryAggregation = $slowQueriesDataService->getSlowQueryAggregation($queryHashed);

        return view('slow-queries::slow-queries.show', ['slowQueryAggregation' => $slowQueryAggregation]);
    }
}
