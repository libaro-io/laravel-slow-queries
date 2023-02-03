<?php

namespace Libaro\LaravelSlowQueries\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Libaro\LaravelSlowQueries\Models\SlowQuery;


class SlowQueriesDataService extends BaseDataService
{
    
    /**
     * @return Collection<int, mixed>
     */
    public function get(): Collection
    {
        // TODO : filter on date range
        $slowQueries = SlowQuery::query()
            ->groupBy('query_hashed', 'uri')
            ->select('query_hashed', 'uri')
            ->selectRaw('min(source_file) as source_file')
            ->selectRaw('min(line) as min_line')
            ->selectRaw('max(line) as max_line')
            ->selectRaw('min(query_without_bindings) as query_without_bindings')
            ->selectRaw('min(duration) as min_duration')
            ->selectRaw('max(duration) as max_duration')
            ->selectRaw('avg(duration) as avg_duration')
            ->selectRaw('max(id) as id')
            ->orderByDesc('avg_duration')

            ->get();

//        dd($slowQueries);

        return $slowQueries;
    }
}
