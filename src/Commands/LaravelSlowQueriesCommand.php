<?php

namespace libaro\LaravelSlowQueries\Commands;

use Illuminate\Console\Command;

class LaravelSlowQueriesCommand extends Command
{
    public $signature = 'laravel-slow-queries';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
