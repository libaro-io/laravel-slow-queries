<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Libaro\LaravelSlowQueries\Models\SlowQuery;

class DashboardController extends Controller
{
    public function show()
    {
        $queries = SlowQuery::paginate();
        return view('slow-queries::dashboard.show', ['title' => 'Dashboard', 'queries' => $queries]);
    }
}
