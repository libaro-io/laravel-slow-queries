<?php

namespace Libaro\LaravelSlowQueries\ValueObjects;

class SourceFrame
{
    /**
     * @var int
     */
    public $line;

    /**
     * @var string
     */
    public $source_file;

    /**
     * @var string
     */
    public $action;
}
