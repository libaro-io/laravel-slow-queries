<?php

namespace Libaro\LaravelSlowQueries\Models;

use Doctrine\DBAL\Query;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Services\MissingIndexService;
use Libaro\LaravelSlowQueries\Services\QueryHintService;
use SqlFormatter;

/**
 * @property int $id
 * @property string $uri
 * @property string $action
 * @property string $source_file
 * @property string $route
 * @property string $query_hashed               // hashed query is used for easier grouping and handling queries that are the same (except for the bindings values)
 * @property string $query_with_bindings
 * @property string $query_without_bindings
 * @property string $prettyQuery
 * @property int $line
 * @property numeric $duration
 * @property string $request_guid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property array $hints
 */
class SlowQuery extends Model
{
//    use HasFactory;
    protected $table = 'slow_queries';

    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    /**
     * @return array<string>
     */
    public function getHintsAttribute(): array
    {
        return (new QueryHintService())->performQueryAnalysis($this->query_with_bindings);
    }

    /**
     * @return Collection<int, string>
     */
    public function getGuessedMissingIndexesAttribute(): Collection
    {
        // guessing missing indexes based on script that tries to find missing indexes globally
        // from information schema and KEY_COLUMN_USAGE
        return (new MissingIndexService())->getGuessedMissingIndexes($this);
    }

    /**
     * @return Collection<int, string>
     */
    public function getSuggestedMissingIndexesAttribute(): Collection
    {
        $result = (new MissingIndexService())->getSuggestedMissingIndexes($this);

        return $result;
    }

//    /**
//     * @return array
//     */
//    public function getQueryParts()
//    {
//    }

    /**
     * @return string
     */
    public function getPrettyQueryAttribute()
    {
        return SqlFormatter::format($this->query_with_bindings);
    }
}
