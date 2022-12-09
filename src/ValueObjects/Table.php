<?php

namespace Libaro\LaravelSlowQueries\ValueObjects;

use Illuminate\Support\Collection;

class Table
{
    /**
     * @var string
     */
    public $tableName;

    /**
     * @var ?string
     */
    public $alias;


    /**
     * @var Collection<int, string>
     */
    public $columnNames;


}
