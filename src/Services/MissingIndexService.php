<?php

namespace Libaro\LaravelSlowQueries\Services;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\ValueObjects\Field;
use Libaro\LaravelSlowQueries\ValueObjects\ParsedQuery;

class MissingIndexService
{

    /**
     * @return array<string>
     */
    public function getGlobalMissingIndexes(): array
    {
        $schemaName = $this->getSchemaName();

        $query = /** @lang text */
            <<<SQL
            SELECT t.TABLE_SCHEMA, t.TABLE_NAME, c.COLUMN_NAME, IFNULL(kcu.CONSTRAINT_NAME, 'Not indexed') AS `Index`
            FROM information_schema.TABLES t
            INNER JOIN information_schema.`COLUMNS` c
                ON c.TABLE_SCHEMA = t.TABLE_SCHEMA
                AND c.TABLE_NAME = t.TABLE_NAME
                AND c.COLUMN_NAME LIKE '%Id'
            LEFT JOIN information_schema.`KEY_COLUMN_USAGE` kcu
                ON kcu.TABLE_SCHEMA = t.TABLE_SCHEMA
                AND kcu.TABLE_NAME = t.TABLE_NAME
                AND kcu.COLUMN_NAME = c.COLUMN_NAME
                AND kcu.ORDINAL_POSITION = 1
            WHERE kcu.TABLE_SCHEMA IS NULL
            AND t.TABLE_SCHEMA NOT IN ('information_schema', 'performance_schema', 'mysql', 'sys')
            AND t.TABLE_SCHEMA IN ('$schemaName')
SQL;

        $missingIndexes = DB::select($query);
        return $missingIndexes;

    }

    /**
     * @param SlowQuery $slowQuery
     * @return Collection<int, string>
     */
    public function getGuessedMissingIndexes(SlowQuery $slowQuery): Collection
    {
        $missingIndexes = collect([]);

        foreach ($this->getGlobalMissingIndexes() as $globalMissingIndex) {
            // TODO : also check table name

            /* TODO fix whene refactoring */
            /** @phpstan-ignore-next-line */
            if (str_contains($slowQuery->query_with_bindings, $globalMissingIndex->COLUMN_NAME)) {
                /* TODO fix whene refactoring */
                /** @phpstan-ignore-next-line */
                $missingIndexes->push($globalMissingIndex->COLUMN_NAME);
            }
        }

        return $missingIndexes;
    }

    /**
     * @param SlowQuery $slowQuery
     * @return Collection<int, string>
     */
    public function getSuggestedMissingIndexes(SlowQuery $slowQuery): Collection
    {
        $parsedQuery = (new QueryService())->breakupQuery($slowQuery->query_with_bindings);
        return $this->mapParsedQueryToFieldsArray($parsedQuery);
    }

    /**
     * @param ParsedQuery $parsedQuery
     * @return Collection<int, string>
     */
    private function mapParsedQueryToFieldsArray(ParsedQuery $parsedQuery): Collection
    {
        $columns = collect([]);

        foreach (QueryService::FIELD_COLLECTIONS as $collection) {
            foreach ($parsedQuery->$collection as $field) {
                /** @var  Field $field */
                $fieldType = $this->getFieldTypeForCollection($collection);
                $column = "$field->tableNameOrAlias.$field->fieldName ($fieldType)";

                $columns->push($column);
            }
        };

        return $columns->unique();
    }

    /**
     * @param string $collection
     * @return string
     */
    private function getFieldTypeForCollection(string $collection)
    {
        switch($collection){
            case 'whereFields':
                return 'where';
            case 'orderByFields':
                return 'order by';
            default:
                return '';
        }
    }
    /**
     * @return string
     */
    private
    function getSchemaName(): string
    {
        /** @phpstan-ignore-next-line */
        return DB::getDatabaseName();
    }
}
