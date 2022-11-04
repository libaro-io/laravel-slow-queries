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
        
        return view('slow-queries::dashboard.show', ['title' => 'Dashboard', 'queries' => $queries]);
    }
}
