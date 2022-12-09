<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class SlowQueriesController extends Controller
{
    public function index(): Factory|View
    {
        $queries = SlowQuery::query()
            ->groupBy('query_hashed', 'uri')
            ->select('query_hashed', 'uri')
            ->selectRaw('min(source_file) as source_file')
            ->selectRaw('min(line) as min_line')
            ->selectRaw('max(line) as max_line')
            ->selectRaw('min(query_without_bindings) as query_without_bindings')
            ->selectRaw('min(duration) as min_duration')
            ->selectRaw('max(duration) as max_duration')
            ->selectRaw('avg(duration) as avg_duration')
            ->orderByDesc('avg_duration')

            ->get();

//        dd($queries);

//        echo("ok");

        return view('slow-queries::slow-queries.index', compact('queries'));
    }

    public function show(SlowQuery $slowQuery): Factory|View
    {
        return view('slow-queries::slow-queries.show', ['query' => $slowQuery]);
    }
}
