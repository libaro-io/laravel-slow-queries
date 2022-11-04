<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class SlowQueriesController extends Controller
{
    public function index():  Factory|View
    {
        /** @phpstan-ignore-next-line */
        $queries = SlowQuery::paginate();

        return view('slow-queries::slow-queries.index', compact('queries'));
    }

    public function show(SlowQuery $slowQuery):  Factory|View
    {
        return view('slow-queries::slow-queries.show', ['query' => $slowQuery]);
    }
}
