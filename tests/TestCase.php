<?php

namespace Libaro\LaravelSlowQueries\Tests;

use Libaro\LaravelSlowQueries\LaravelSlowQueriesServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
	public function setUp(): void
	{
		parent::setUp();
		// additional setup
	}

	protected function getPackageProviders($app)
	{
		return [
			LaravelSlowQueriesServiceProvider::class,
		];
	}

	protected function getEnvironmentSetUp($app)
	{
		// perform environment setup
	}
}