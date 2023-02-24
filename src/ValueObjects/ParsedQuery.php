<?php

namespace Libaro\LaravelSlowQueries\ValueObjects;

use Illuminate\Support\Collection;

class ParsedQuery
{
    /**
     * @var Collection<int, TableAlias>
     */
    public $tableAliases;

    /**
     * @var Collection<int, Field>
     */
    public $whereFields;

    /**
     * @var Collection<int, OrderByField>
     */
    public $orderByFields;
}
