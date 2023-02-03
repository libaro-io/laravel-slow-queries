<?php

namespace Libaro\LaravelSlowQueries\Services;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\ValueObjects\OrderByField;
use Libaro\LaravelSlowQueries\ValueObjects\ParsedQuery;
use Libaro\LaravelSlowQueries\ValueObjects\TableAlias;
use Libaro\LaravelSlowQueries\ValueObjects\Field;
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

    const DIRECTION = 'direction';

    const WHERE = 'WHERE';
    const ORDER = 'ORDER';

    const FIELD_COLLECTIONS = ['whereFields', 'orderByFields'];
    const CLEANUP_CHARS = ['[', ']'];

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
        $parsedQuery->orderByFields = $this->getOrderByFields($parsed);



        $parsedQuery = $this->cleanup($parsedQuery);
//        dd($parsedQuery);
        return $parsedQuery;
    }

    /**
     * @param array $parsed
     * @return Collection<int, TableAlias>
     */
    private function getAliases(array $parsed): Collection
    {
        if(!isset($parsed[self::FROM])){
            return collect();
        }

        $parts = $parsed[self::FROM];
        $results = collect([]);


//        dd($parts);


        foreach ($parts as $part) {
            if (
                $part[self::EXPR_TYPE] && $part[self::EXPR_TYPE] === self::TABLE
                && $part[self::ALIAS] && count($part[self::ALIAS])

            ) {
                $tableAlias = new TableAlias();
                $tableAlias->tableName = $part[self::TABLE];
                $tableAlias->alias = $part[self::ALIAS]['name'];

                $results->push($tableAlias);
            } else {


            }

        }

        return $results;
    }

    /**
     * @param array $parsed
     * @return Collection<int, Field>
     */
    private function getWhereFields(array $parsed): Collection
    {
        if(!isset($parsed[self::WHERE])){
            return collect();
        }

        $items = $parsed[self::WHERE];
        $results = collect([]);

        foreach ($items as $item) {
            if ($item[self::EXPR_TYPE] && $item[self::EXPR_TYPE] === self::COLREF) {
                $field = new Field();


                // try if needed data can be found in the parts
                if($item[self::NO_QUOTES] && $item[self::NO_QUOTES][self::PARTS]){
                    // try to guess fieldname (and sometimes tablename)
                    $parts = $item[self::NO_QUOTES][self::PARTS];

                    if(count($parts) === 2){
                        // probably both tablename and fieldname are supplied
//                        dd($item);

                        $fieldName = $parts[1];
                        $tableName = $parts[0];
                    } else if(count($parts) === 1){
                        // probably only fieldname is supplied // no tablename
                        $fieldName = $parts[0];
                        $tableName = '';
                    } else {
                        $tableName = '';
                        $fieldName = '';
                    }

                    $field->fullName = $tableName ? "$tableName.$fieldName" : $fieldName;
                    $field->tableNameOrAlias = $tableName;
                    $field->fieldName = $fieldName;
                } else {
                    $field->fullName = $item[self::BASE_EXPR];
                    $field->tableNameOrAlias = $item[self::NO_QUOTES][self::PARTS][self::PARTS_TABLE];
                    $field->fieldName = $item[self::NO_QUOTES][self::PARTS][self::PARTS_FIELD] ?? '';
                }
;
                $results->push($field);
            }
        }

        return $results;
    }

    /**
     * @param array $parsed
     * @return Collection<int, OrderByField>
     */
    private function getOrderByFields(array $parsed)
    {
        if(!isset($parsed[self::ORDER])){
            return collect([]);
        }


        $parts = $parsed[self::ORDER];
        $results = collect([]);

        foreach ($parts as $part) {
            if ($part[self::EXPR_TYPE] && $part[self::EXPR_TYPE] === self::COLREF) {
                $field = new OrderByField();

                $field->fullName = $part[self::BASE_EXPR];
                $field->tableNameOrAlias = $part[self::NO_QUOTES][self::PARTS][self::PARTS_TABLE];
                $field->fieldName = $part[self::NO_QUOTES][self::PARTS][self::PARTS_FIELD];
                $field->orderDirection = $part[self::DIRECTION];

                $results->push($field);
            }
        }

        return $results;
    }

    /**
     * @param ParsedQuery $parsedQuery
     * @return ParsedQuery
     */
    private function cleanup(ParsedQuery $parsedQuery)
    {
        $mappedAliases = $this->getMappedAliases($parsedQuery);

        $parsedQuery = $this->cleanupFieldNames($parsedQuery);
        $parsedQuery = $this->replaceAliasesByTableNames($parsedQuery, $mappedAliases);

        return $parsedQuery;
    }

    /**
     * @param ParsedQuery $parsedQuery
     * @return array
     */
    private function getMappedAliases(ParsedQuery $parsedQuery)
    {
        $mappedAliases = [];
        foreach ($parsedQuery->tableAliases as $tableAlias) {
            // only add if not added yet
            if (!isset($mappedAliases[$tableAlias->alias])) {
                $mappedAliases[$tableAlias->alias] = $tableAlias->tableName;
            }
        }

        return $mappedAliases;
    }

    /**
     * @param ParsedQuery $parsedQuery
     * @param array $mappedAliases
     * @return ParsedQuery
     */
    private function replaceAliasesByTableNames(ParsedQuery $parsedQuery, array $mappedAliases)
    {
        foreach (self::FIELD_COLLECTIONS as $collectionName) {
            $collection = $parsedQuery->$collectionName;

            // loop every field in the collection and replace alias names by real table names
            $parsedQuery->$collectionName = $collection->map(function ($field) use ($mappedAliases) {
                /** @var  Field $field */

                $alias = $field->tableNameOrAlias;

                if (isset($mappedAliases[$alias])) {
                    ;
                    $tableName = $mappedAliases[$alias];
                    $field->tableNameOrAlias = str_replace($alias, $tableName, $alias);
                    $field->fullName = "$field->tableNameOrAlias.$field->fieldName";

                }

                return $field;
            });
        }

        return $parsedQuery;
    }

    /**
     * @param ParsedQuery $parsedQuery
     * @return ParsedQuery
     */
    private function cleanupFieldNames(ParsedQuery $parsedQuery)
    {
        foreach (self::FIELD_COLLECTIONS as $collectionName) {
            $collection = $parsedQuery->$collectionName;

            // loop every field in the collection and cleanup the field names
            $parsedQuery->$collectionName = $collection->map(function ($field) {
                foreach (self::CLEANUP_CHARS as $char) {
                    /** @var  Field $field */
                    $field->fieldName = str_replace($char, '', $field->fieldName);
                }

                return $field;
            });
        }

        return $parsedQuery;
    }
}