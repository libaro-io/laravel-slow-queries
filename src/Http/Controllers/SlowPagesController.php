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
        $pages = $slowPagesService->getSlowestPages();

//        dd($pages);

        return view('slow-queries::slow-pages.index', compact('pages'));
    }

    public function show($slowPage)
    {
        $query = SlowQuery::query()
            ->where('request_guid', 'like', $slowPage)
            ->firstOrFail();

//        dd($slowQuery);

        return redirect( route('slow-queries.slow-queries.show', ['slowQuery' => $query->id ]));
//        return view('slow-queries::all-queries.show', ['query' => $slowQuery]);
    }
}
