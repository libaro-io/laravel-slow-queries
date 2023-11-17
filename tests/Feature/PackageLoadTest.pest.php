<?php

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Libaro\LaravelSlowQueries\LaravelSlowQueries;
use Mockery\MockInterface;
use Tests\TestCase;

test('LaravelSlowQueries can be loaded', function () {
	$laravelSlowQueries = new \Libaro\LaravelSlowQueries\LaravelSlowQueries();

	expect($laravelSlowQueries)->toBeInstanceOf(\Libaro\LaravelSlowQueries\LaravelSlowQueries::class);
});
