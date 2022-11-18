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
     * @var Collection<int, WhereField>
     */
    public $whereFields;




}
