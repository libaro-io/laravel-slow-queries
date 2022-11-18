<?php

namespace Libaro\LaravelSlowQueries\Models;

use Doctrine\DBAL\Query;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Libaro\LaravelSlowQueries\Services\MissingIndexService;
use Libaro\LaravelSlowQueries\Services\QueryHintService;
use Libaro\LaravelSlowQueries\Services\QueryService;

/**
 * @property integer $id
 * @property string $uri
 * @property string $action
 * @property string $source_file
 * @property string $query_hashed               // hashed query is used for easier grouping and handling queries that are the same (except for the bindings values)
 * @property string $query_with_bindings
 * @property string $query_without_bindings
 * @property integer $line
 * @property numeric $duration
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property array $hints
 *
 */
class SlowQuery extends Model
{
//    use HasFactory;
    protected $table = 'slow_queries';

    // Disable Laravel's mass assignment protection
    protected $guarded = [];

    /**
     * @return array
     */
    public function getHintsAttribute(): array
    {
        return (new QueryHintService())->performQueryAnalysis($this->query_with_bindings);
    }

    /**
     * @return Collection
     */
    public function getMissingIndexesAttribute(): Collection
    {

        $t = (new QueryService())->breakupQuery($this->query_with_bindings);


        return (new MissingIndexService())->getMissingIndexesForQuery($this);
    }

    /**
     * @return array
     */
    public function getQueryParts()
    {
    }
}