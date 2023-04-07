<?php

namespace Libaro\LaravelSlowQueries;

use Illuminate\Support\Facades\Log;
use Libaro\LaravelSlowQueries\ValueObjects\SourceFrame;

class QuerySource
{
    /**
     * @var string[]
     */
    protected $backtraceExcludePaths = [
        '/vendor/laravel/framework/src/Illuminate/Support',
        '/vendor/laravel/framework/src/Illuminate/Database',
        '/vendor/laravel/framework/src/Illuminate/Events',
        '/vendor/october/rain',
        '/vendor/libaro/LaravelSlowQueries',
        'LaravelSlowQueries',
    ];

    public function findSource(): ?SourceFrame
    {
        // TODO: make configurable: backtrace limit 50
        $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS | DEBUG_BACKTRACE_PROVIDE_OBJECT, 50);

        $frame = null;
        foreach ($stack as $index => $trace) {
            /* TODO fix whene refactoring */
            /** @phpstan-ignore-next-line */
            $frame = $this->parseTrace($index, $trace);

//            Log::info(json_encode($frame));

            if ($frame) {
                break;
            }
        }

        return $frame;
    }

    /**
     * @param  array<string>  $trace
     */
    protected function parseTrace(int $index, array $trace): ?SourceFrame
    {
        foreach ($this->backtraceExcludePaths as $excludePath) {
            if (str_contains($trace['file'], $excludePath)) {
                return null;
            }
        }

        $frame = new SourceFrame();
        $frame->source_file = $this->getSourceFile($trace);

        /* TODO fix whene refactoring */
        /** @phpstan-ignore-next-line */
        $frame->line = $this->getLine($trace);
        $frame->action = $this->getAction($trace);

        return $frame;
    }

    /**
     * @param  array<string>  $trace
     */
    private function getSourceFile(array $trace): string
    {
        return $trace['file'];
    }

    /**
     * @param  array<int>  $trace
     */
    private function getLine(array $trace): int
    {
        return $trace['line'] ?? 0;
    }

    /**
     * @param  array<string>  $trace
     */
    private function getAction(array $trace): string
    {
        return $trace['function'];
    }
}
