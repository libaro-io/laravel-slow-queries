<?php

namespace Libaro\LaravelSlowQueries\ValueObjects;


use Illuminate\Support\Collection;

class ParsedQuery
{
    /**
     * @var Collection<int, Table>
     */
    public $tables;

    /**
     * @var Collection<int, Field>
     */
    public $whereFields;

    /**
     * @var Collection<int, OrderByField>
     */
    public $orderByFields;




}
