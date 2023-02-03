<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\Services\SlowPagesDataService;

class SlowPagesController extends Controller
{
    public function index(): Factory|View
    {
        $slowPagesService = new SlowPagesDataService();
        $slowPagesService->setNumberOfItems(999);
        $slowPages = $slowPagesService->getSlowestPages();

        return view('slow-queries::slow-pages.index', compact('slowPages'));
    }

    public function show($slowPage)
    {
        $query = SlowQuery::query()
            ->where('request_guid', 'like', $slowPage)
            ->firstOrFail();

        return redirect( route('slow-queries.slow-queries.show', ['slowQuery' => $query->id ]));
    }
}
