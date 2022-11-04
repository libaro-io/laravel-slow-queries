<?php

namespace Libaro\LaravelSlowQueries\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
 */

class SlowQuery extends Model
{
//    use HasFactory;
    protected $table = 'slow_queries';

    // Disable Laravel's mass assignment protection
    protected $guarded = [];
}