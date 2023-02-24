<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
        $slowPagesAggregations = $slowPagesService->getAggregations();

        return view('slow-queries::slow-pages.index', compact('slowPagesAggregations'));
    }

    /**
     * @param string $uriBase64Encoded
     * @return bool|Response|Application|Factory|View|null
     */
    public function show(string $uriBase64Encoded)
    {
        $uri = base64_decode($uriBase64Encoded);

        $slowPagesDataService = new SlowPagesDataService();
        $slowPageAggregation = $slowPagesDataService->getSlowPageAggregation($uri);

        return view('slow-queries::slow-pages.show', ['slowPageAggregation' => $slowPageAggregation]);
    }
}
