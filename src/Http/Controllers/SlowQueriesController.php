<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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

        if(!$slowQueryAggregation){
            return redirect(route('slow-queries.slow-queries.index'));
        }

        return view('slow-queries::slow-queries.show', ['slowQueryAggregation' => $slowQueryAggregation]);
    }
}
