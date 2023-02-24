<?php

namespace Libaro\LaravelSlowQueries\Data;

/* data object to define the data for queries at the first level: grouped by same query */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\Services\QueryHintService;
use SqlFormatter;

class SlowQueryAggregation extends Model
{
    public string $queryHashed;

    public string $uri;

    public string $sourceFile;

    public int $minLine;

    public int $maxLine;

    public string $queryWithoutBindings;

    public string $queryWithBindings;

    public int $minDuration;

    public int $maxDuration;

    public int $avgDuration;

    public int $queryCount;

    /**
     * @var Collection<int, SlowQuery>
     */
    public Collection $details;

    public function getPrettyQueryAttribute(): string
    {
        return SqlFormatter::format($this->queryWithoutBindings);
    }

    /**
     * @return array<string>
     */
    public function getHintsAttribute(): array
    {
        return (new QueryHintService())->performQueryAnalysis($this->queryWithBindings);
    }
}
