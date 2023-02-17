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
    /**
     * @var string
     */
    public string $queryHashed;
    /**
     * @var string
     */
    public string $uri;
    /**
     * @var string
     */
    public string $sourceFile;
    /**
     * @var int
     */
    public int $minLine;
    /**
     * @var int
     */
    public int $maxLine;
    /**
     * @var string
     */
    public string $queryWithoutBindings;
    /**
     * @var string
     */
    public string $queryWithBindings;
    /**
     * @var int
     */
    public int $minDuration;
    /**
     * @var int
     */
    public int $maxDuration;
    /**
     * @var int
     */
    public int $avgDuration;
    /**
     * @var int
     */
    public int $queryCount;

    public string $sonjasTextje;

    /**
     * @var Collection<int, SlowQuery>
     */
    public Collection $details;

    /**
     * @return String
     */
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