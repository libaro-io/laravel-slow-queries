# Laravel Slow Queries

[![Latest Version on Packagist](https://img.shields.io/packagist/v/libaro/laravel-slow-queries.svg?style=flat-square)](https://packagist.org/packages/libaro/laravel-slow-queries)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/libaro/laravel-slow-queries/run-tests?label=tests)](https://github.com/libaro/laravel-slow-queries/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/libaro/laravel-slow-queries/Check%20&%20fix%20styling?label=code%20style)](https://github.com/libaro/laravel-slow-queries/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/libaro/laravel-slow-queries.svg?style=flat-square)](https://packagist.org/packages/libaro/laravel-slow-queries)



Laravel Slow Queries is a package that allows you to easily log slow queries in your Laravel application. This package logs queries that exceed a configurable time limit and stores them in the database, making it easy to analyze and optimize your database performance.

## Installation

You can install the package via composer:

```bash
composer require libaro/laravel-slow-queries
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-slow-queries-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-slow-queries-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-slow-queries-views"
```

## Usage

```php
$laravelSlowQueries = new libaro\LaravelSlowQueries();
echo $laravelSlowQueries->echoPhrase('Hello, libaro!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/libaro-io/.github/blob/main/CONTRIBUTING.md) for details.

## Development Flow

Please see [DEVELOPMENT FLOW](https://github.com/libaro-io/.github/blob/main/DEVELOPMENT_FLOW.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [libaro](https://github.com/libaro)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
