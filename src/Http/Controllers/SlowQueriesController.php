<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Libaro\LaravelSlowQueries\Services\SlowQueriesDataService;

class SlowQueriesController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index(): Factory|View
    {
        $slowQueriesDataService = new SlowQueriesDataService();
        $slowQueries = $slowQueriesDataService->getAggregations();

        return view('slow-queries::slow-queries.index', compact('slowQueries'));
    }

    /**
     * @param string $queryHashed
     * @return Factory|View|RedirectResponse|Redirector
     */
    public function show(string $queryHashed)
    {
        $slowQueriesDataService = new SlowQueriesDataService();
        $slowQueryAggregation = $slowQueriesDataService->getSlowQueryAggregation($queryHashed);

        if(!$slowQueryAggregation){
            return redirect(route('slow-queries.slow-queries.index'));
        }

        return view('slow-queries::slow-queries.show', ['slowQueryAggregation' => $slowQueryAggregation]);
    }
}
