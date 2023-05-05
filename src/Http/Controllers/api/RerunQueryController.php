<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers\api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Libaro\LaravelSlowQueries\Http\Controllers\Controller;

class RerunQueryController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $slowQueryId = intval($request->get('slowQueryId'));

        return Response::json(['message' => 'Query rerun started']);
    }
}
