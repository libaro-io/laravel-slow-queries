<?php

namespace Libaro\LaravelSlowQueries\Data;

/* data object to define the data for queries at the first level: grouped by same query */

class SlowQueryData
{
    public string $queryHashed;
    public string $uri;
    public string $sourceFile;
    public int $minLine;
    public int $maxLine;
    public string $queryWithoutBindings;
    public int $minDuration;
    public int $maxDuration;
    public int $avgDuration;
}