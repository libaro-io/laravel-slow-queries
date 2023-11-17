<?php

namespace Libaro\LaravelSlowQueries\Jobs;

use Error;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class RerunQuery implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public SlowQuery $slowQuery;

    public function __construct(int $slowQueryId)
    {
        /** @var SlowQuery $slowQuery */
        $slowQuery = SlowQuery::query()
            ->where('id', '=', $slowQueryId)
            ->first();

        if(!$slowQueryId){
            throw new Error('No query found for id '. $slowQueryId);
        }

        $this->slowQuery = $slowQuery;
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $sql = $this->slowQuery->query_with_bindings;

        $start = microtime(true);
        DB::raw($sql);
        $time = microtime(true) - $start;

//        dd($time, $sql);
    }
}
