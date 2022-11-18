<?php

namespace Libaro\LaravelSlowQueries\Services;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\ValueObjects\ParsedQuery;
use Libaro\LaravelSlowQueries\ValueObjects\TableAlias;
use Libaro\LaravelSlowQueries\ValueObjects\WhereField;
use PHPSQLParser\PHPSQLParser;

/*
 * the idea is to break up the query into separate parts: select, from, where, orderby
 * if there are joins or subselects: retrieve those results recursively
 *
 * //TODO : loop the query recursively to also handle the subselects/joins/ and possible other subparts of the main query (derived, unions, etc)
 * // basic handling and parsing of the query is good enough for first poc?
 */

class QueryService
{
    const FROM = 'FROM';
    const EXPR_TYPE = 'expr_type';
    const BASE_EXPR = 'base_expr';
    const TABLE = 'table';
    const COLREF = 'colref';
    const ALIAS = 'alias';
    const NO_QUOTES = 'no_quotes';
    const PARTS = 'parts';
    const PARTS_TABLE = 0;
    const PARTS_FIELD = 1;


    const WHERE = 'WHERE';


    /**
     * @param string $query
     * @return ParsedQuery
     */
    public function breakupQuery(string $query): ParsedQuery
    {
        $t = new PHPSQLParser();
        $parsed = $t->parse($query);

        $tableAliases = collect([]);
        $whereFields = collect([]);
        $joinFields = collect([]);
        $orderFields = collect([]);
        
        $parsedQuery = new ParsedQuery();
        $parsedQuery->tableAliases = $this->getAliases($parsed);
        $parsedQuery->whereFields = $this->getWhereFields($parsed);

        return $parsedQuery;
    }

    /**
     * @param array $parsed
     * @return Collection<int, TableAlias>
     */
    private function getAliases(array $parsed): Collection
    {
        $parts = $parsed[self::FROM];
        $results = collect([]);

        foreach ($parts as $part) {
            if (
                $part[self::EXPR_TYPE] && $part[self::EXPR_TYPE] === self::TABLE
                && $part[self::ALIAS] && count($part[self::ALIAS])

            ) {
                $tableAlias = new TableAlias();
                $tableAlias->tableName = $part[self::TABLE];
                $tableAlias->alias =  $part[self::ALIAS]['name'];

                $results->push($tableAlias);
            }

        }

        return $results;
    }

    /**
     * @param array $parsed
     * @return Collection<int, WhereField>
     */
    private function getWhereFields(array $parsed): Collection
    {
        $parts = $parsed[self::WHERE];
        $results = collect([]);

        foreach($parts as $part){
            if($part[self::EXPR_TYPE] && $part[self::EXPR_TYPE] === self::COLREF){
                $whereField = new WhereField();

                $whereField->fullName = $part[self::BASE_EXPR];
                $whereField->tableNameOrAlias = $part[self::NO_QUOTES][self::PARTS][self::PARTS_TABLE];
                $whereField->fieldName = $part[self::NO_QUOTES][self::PARTS][self::PARTS_FIELD];

                $results->push($whereField);
            }
        }

        return $results;
    }
}
