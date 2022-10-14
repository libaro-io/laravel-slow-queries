<?php

namespace Libaro\LaravelSlowQueries;

use Illuminate\Support\Facades\Log;

class LaravelSlowQueries
{
    /**
     * @return void
     */
    public function startListeningWhenEnabled(): void
    {
        if ($this->isPackageEnabled()) {
            $this->startListening();
        }
    }

    /**
     * @return void
     */
    private function startListening(): void
    {
        Log::debug('testing package');


    }

    /**
     * @return bool
     */
    private function isPackageEnabled()
    {
        return (bool)config('slow-queries.enabled');
    }
}
