<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers\api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Libaro\LaravelSlowQueries\Http\Controllers\Controller;

class TimeRangeController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $timeRange = intval($request->input('timeRange'));
        Session::put('timeRange', $timeRange);

        return Response::json(['message' => 'Time range saved successfully']);
    }
}
