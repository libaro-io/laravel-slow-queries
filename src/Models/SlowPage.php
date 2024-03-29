<?php

namespace Libaro\LaravelSlowQueries\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $the_uri
 * @property numeric $the_page_duration
 * @property int $the_query_count
 * @property string $the_route
 */
class SlowPage extends Model
{
    protected $table = 'view_slow_pages';           // the view view_slow_pages is a view based on a grouped by request_guid view on slow_queries
}
