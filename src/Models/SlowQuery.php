<?php

namespace Libaro\LaravelSlowQueries\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property integer $id
 * @property string $uri
 * @property string $action
 * @property string $source_file
 * @property string $query
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