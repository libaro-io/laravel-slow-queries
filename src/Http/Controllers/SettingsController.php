<?php

namespace Libaro\LaravelSlowQueries\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Libaro\LaravelSlowQueries\LaravelSlowQueries;
use Libaro\LaravelSlowQueries\Services\SlowPagesDataService;

class SettingsController extends Controller
{
    public function index(): Factory|View
    {
        $settings = [
            'enabled' => [
                'name' => 'enabled',
                'description' => 'is the package enabled or not ',
                'value' =>  (new LaravelSlowQueries())->isPackageEnabled()
            ],
        ];

        return view('slow-queries::settings.index', compact('settings'));
    }
}
