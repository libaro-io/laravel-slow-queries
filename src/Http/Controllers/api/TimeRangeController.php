<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers\api;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Libaro\LaravelSlowQueries\Http\Controllers\Controller;
use Libaro\LaravelSlowQueries\Services\DashboardDataService;
use Libaro\LaravelSlowQueries\Services\SlowPagesDataService;
use Libaro\LaravelSlowQueries\Services\SlowQueriesDataService;

class TimeRangeController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $timeRange = intval($request->input('timeRange'));
        session()->put('timeRange', $timeRange);
        return response()->json(['message' => 'Time range saved successfully']);
    }
}
