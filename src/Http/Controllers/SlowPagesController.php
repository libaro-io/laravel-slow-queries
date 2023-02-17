<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\Services\SlowPagesDataService;

class SlowPagesController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index(): Factory|View
    {
        $slowPagesService = new SlowPagesDataService();
        $slowPagesService->setNumberOfItemsPerWidget(999);
        $slowPages = $slowPagesService->get();

        return view('slow-queries::slow-pages.index', compact('slowPages'));
    }

    /**
     * @param $slowPage
     * @return Application|RedirectResponse|Redirector
     */
    public function show(string $slowPage): Redirector|RedirectResponse|Application
    {
        /** @var SlowQuery $query */
        $query = SlowQuery::query()
            ->where('request_guid', 'like', $slowPage)
            ->firstOrFail();

        return redirect( route('slow-queries.slow-queries.show', ['slowQuery' => $query->id ]));
    }
}
