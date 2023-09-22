<?php

use Illuminate\Support\Facades\Config;
use Libaro\LaravelSlowQueries\ValueObjects\TimeRanges;

it('checks if slow-enabled config setting is available and is a boolean', function () {
	$isEnabled = Config::get('slow-queries.enabled');

	expect($isEnabled)->not->toBeNull();
	expect($isEnabled)->toBeBool();
});

it('checks if log_queries_slower_than config setting is an integer representing milliseconds', function () {
	$logQueriesSlowerThan = Config::get('slow-queries.log_queries_slower_than');

	expect($logQueriesSlowerThan)->not->toBeNull();
	expect($logQueriesSlowerThan)->toBeInt();
	expect($logQueriesSlowerThan)->toBeGreaterThan(0);
});

it('checks if log_queries_more_than config setting is an integer', function () {
	$logQueriesMoreThan = Config::get('slow-queries.log_queries_more_than');

	expect($logQueriesMoreThan)->not->toBeNull();
	expect($logQueriesMoreThan)->toBeInt();
});

it('checks if log_pages_slower_than config setting is an integer representing milliseconds', function () {
	$logPagesSlowerThan = Config::get('slow-queries.log_pages_slower_than');

	expect($logPagesSlowerThan)->not->toBeNull();
	expect($logPagesSlowerThan)->toBeInt();
	expect($logPagesSlowerThan)->toBeGreaterThan(0);
});

it('checks if middleware config setting is a string', function () {
	$middleware = Config::get('slow-queries.middleware');

	expect($middleware)->not->toBeNull();
	expect($middleware)->toBeString();
});

it('checks if url_prefix config setting is a string and is a valid URL prefix', function () {
	$urlPrefix = Config::get('slow-queries.url_prefix');

	expect($urlPrefix)->not->toBeNull();
	expect($urlPrefix)->toBeString();
	expect(filter_var($urlPrefix, FILTER_SANITIZE_URL))->toBe($urlPrefix);
});

it('checks if items_per_widget config setting is an integer, positive, and not zero', function () {
	$itemsPerWidget = Config::get('slow-queries.items_per_widget');

	expect($itemsPerWidget)->not->toBeNull();
	expect($itemsPerWidget)->toBeInt();
	expect($itemsPerWidget)->toBeGreaterThan(0);
});

it('checks if items_per_page config setting is an integer, positive, and not zero', function () {
	$itemsPerPage = Config::get('slow-queries.items_per_page');

	expect($itemsPerPage)->not->toBeNull();
	expect($itemsPerPage)->toBeInt();
	expect($itemsPerPage)->toBeGreaterThan(0);
});

it('checks if default_time_range config setting is an integer and is one of the values in the time ranges value object', function () {
	$defaultTimeRange = Config::get('slow-queries.default_time_range');

	expect($defaultTimeRange)->not->toBeNull();
	expect($defaultTimeRange)->toBeInt();
	expect(TimeRanges::isValid($defaultTimeRange))->toBeTrue();
});

it('checks if slow-queries.exclude_routes is optional or a string convertible to an array of strings', function () {
	$excludeRoutes = Config::get('slow-queries.exclude_routes');

	// Check if exclude_routes is null or an array of strings
	if ($excludeRoutes !== false && $excludeRoutes !== null) {
		expect($excludeRoutes)->toBeString();
		expect($excludeRoutes)->toContain(',');
	} else {
		expect($excludeRoutes)->toBeFalse();
	}
});