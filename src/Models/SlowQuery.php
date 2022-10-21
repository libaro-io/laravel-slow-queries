<?php

namespace Libaro\LaravelSlowQueries\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property integer $id
 * @property string $uri
 * @property string $action
 * @property string $query
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