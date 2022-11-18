<?php

namespace Libaro\LaravelSlowQueries\Services;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use PHPSQLParser\PHPSQLParser;


class QueryService
{
    public function breakupQuery(string $query): array
    {
        $t = new PHPSQLParser();
        $parsed = $t->parse($query);

        $tableAliases = collect([]);
        $whereFields = collect([]);
        $joinFields = collect([]);
        $orderFields = collect([]);

        dd($parsed);


        return [];
//        return $parsed;
    }
}
