<?php

namespace Libaro\LaravelSlowQueries;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\ValueObjects\SourceFrame;

class QuerySource
{
    protected $backtraceExcludePaths = [
        '/vendor/laravel/framework/src/Illuminate/Support',
        '/vendor/laravel/framework/src/Illuminate/Database',
        '/vendor/laravel/framework/src/Illuminate/Events',
        '/vendor/october/rain',
        '/vendor/libaro/LaravelSlowQueries',
        'LaravelSlowQueries',
    ];

    public function findSource()
    {
        $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS | DEBUG_BACKTRACE_PROVIDE_OBJECT, app('config')->get('debugbar.debug_backtrace_limit', 50));

//        dd($stack);

//        $frame = null;
        foreach ($stack as $index => $trace) {
            $frame = $this->parseTrace($index, $trace);
            if ($frame) {
                break;
            }
        }


//        dd($frame);
        return $frame;
    }

    protected function parseTrace($index, array $trace)
    {
        foreach ($this->backtraceExcludePaths as $excludePath) {
            if (str_contains($trace['file'], $excludePath)) {
                return null;
            }
        }

        $frame = new SourceFrame();
        $frame->source_file = $this->getSourceFile($trace);
        $frame->line = $this->getLine($trace);

        return $frame;
    }

    private function getSourceFile($trace)
    {
        return $trace['file'];
    }

    private function getLine($trace)
    {
        return $trace['line'] ?? 0;
    }
}
