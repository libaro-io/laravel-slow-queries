<?php

namespace Libaro\LaravelSlowQueries\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Libaro\LaravelSlowQueries\LaravelSlowQueriesServiceProvider;

class TestCase extends Orchestra
{
	protected function getPackageProviders($app)
	{
		return [
			LaravelSlowQueriesServiceProvider::class,
		];
	}
}