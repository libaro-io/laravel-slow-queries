<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\Services\SlowPagesDataService;

class SlowPagesController extends Controller
{
    public function index(): Factory|View
    {
        $slowPagesService = new SlowPagesDataService();
        $slowPagesAggregations = $slowPagesService->getAggregations();

        return view('slow-queries::slow-pages.index', compact('slowPagesAggregations'));
    }

    public function show(string $slowPage): Redirector|RedirectResponse|Application
    {
        /** @var SlowQuery $query */
        $query = SlowQuery::query()
            ->where('request_guid', 'like', $slowPage)
            ->firstOrFail();

        return redirect(route('slow-queries.slow-queries.show', ['slowQuery' => $query->id]));
    }
}
