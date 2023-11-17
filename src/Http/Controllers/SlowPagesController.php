<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Libaro\LaravelSlowQueries\Services\SlowPagesDataService;

class SlowPagesController extends Controller
{
    public function index(): Factory|View
    {
        $slowPagesService = new SlowPagesDataService();
        $slowPagesAggregations = $slowPagesService->getAggregations();

        return view('slow-queries::slow-pages.index', ['slowPagesAggregations' => $slowPagesAggregations]);
    }

    /**
     * @param string $uriBase64Encoded
     * @return Factory|View|RedirectResponse|Redirector
     */
    public function show(string $uriBase64Encoded)
    {
        $uri = base64_decode($uriBase64Encoded);

        $slowPagesDataService = new SlowPagesDataService();
        $slowPageAggregation = $slowPagesDataService->getSlowPageAggregation($uri);

        if(!$slowPageAggregation){
            return redirect(route('slow-queries.slow-pages.index'));
        }

        return view('slow-queries::slow-pages.show', ['slowPageAggregation' => $slowPageAggregation]);
    }
}
