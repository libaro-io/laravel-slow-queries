<?php

namespace Libaro\LaravelSlowQueries\Jobs;

use Error;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Libaro\LaravelSlowQueries\Models\SlowQuery;

class SaveSlowQueries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * The number of times the job may be attempted.
	 *
	 * @var int
	 */
	public $tries = 3;

    /**
     * @var Collection<int, SlowQuery>
     */
    public Collection $slowQueries;
    /**
     * @var Collection<int, string>
     */
    protected Collection $excludedRoutes;

    /**
     * @param Collection<int, SlowQuery> $slowQueries
     */
    public function __construct(Collection $slowQueries)
    {
        $this->slowQueries = $slowQueries;
        $this->excludedRoutes = $this->getExcludeRoutes();
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $this->backoffJobWhenHeavyLoad();

        $isPageSlow = $this->isPageSlow();

        foreach ($this->slowQueries as $slowQuery) {
            if (
                (
                    $isPageSlow
                    || $this->isQuerySlow($slowQuery)
                    || $this->hasManyQueries()
                )
                && !$this->isMetaQuery($slowQuery)
                && !$this->isExcluded($slowQuery)
            ) {
                $slowQuery->save();
            }
        }
    }

    /**
     * @return Collection<int, string>
     */
    public function getExcludeRoutes(): Collection
    {
        $paths = config('slow-queries.exclude_paths');
        $excludePaths = collect();

        if ($paths && is_string($paths)) {
            $pathsArray = explode(',', $paths);
            $excludePaths = collect(array_map('strval', $pathsArray));
        }

        return $excludePaths;

    }

    public function getQueriesSlowerThan(): float
    {
        $queriesSlowerThan = config('slow-queries.log_queries_slower_than');

        return is_numeric($queriesSlowerThan) ? (float)$queriesSlowerThan : 0;
    }

    public function getPagesSlowerThan(): float
    {
        $pagesSlowerThan = config('slow-queries.log_pages_slower_than');

        return is_numeric($pagesSlowerThan) ? (float)$pagesSlowerThan : 0;
    }

    private function isQuerySlow(SlowQuery $slowQuery): bool
    {
        return $slowQuery->duration >= $this->getQueriesSlowerThan();
    }

    private function isPageSlow(): bool
    {
        $pageDuration = $this->slowQueries->sum('duration');
        $pagesSlowerThan = $this->getPagesSlowerThan();

        return ($pageDuration >= $pagesSlowerThan);
    }

    /**
     * @return bool
     */
    private function hasManyQueries()
    {
        $moreThan = config('slow-queries.log_queries_more_than');

        return $this->slowQueries->count() > $moreThan;
    }

    private function isMetaQuery(SlowQuery $slowQuery): bool
    {
        return
            str_contains($slowQuery->query_without_bindings, 'slow_queries')
            ||
            str_contains($slowQuery->source_file, 'laravel-slow-queries')
            ||
            str_contains($slowQuery->uri, strval(config('slow-queries.url_prefix')))
            ||
            str_contains($slowQuery->action, 'LaravelSlowQueries')
            ||
            str_contains($slowQuery->route, 'slow-queries')
            ;
    }

    private function isExcluded(SlowQuery $slowQuery): bool
    {
        $isExcluded = false;

        foreach ($this->excludedRoutes as $excludedRoute) {
            if($excludedRoute === $slowQuery->route){
                $isExcluded = true;
            }
        }

        return $isExcluded;
    }

    /**
     * @return void
     * @throws Exception
     */
    private function backoffJobWhenHeavyLoad(){
		// TODO : refactor and test
		// so that it works both in sync and in queue
		// note: retry of job will not be possible when in sync; just stop the job when cpu is too high
        $isHighLoad = $this->isHighLoad();

        if($isHighLoad){
            Log::info('high load --');

			$reason = new Exception('Server load is too high at the moment to process the slow query. Backing off');
			$this->fail($reason);

			$this->release(60);;
			throw $reason;
        } else {

			Log::info('no high load -- continue');
		}
    }

//    public function backoff(): int
//    {
//        $load = $this->getLoad();
//        $load = ($load + 1) * ($load + 1);      // backoff exponentially slower
////        Log::info('load_1 ' . $load);
//        $backoffSeconds = $load * intval(config('slow-queries.jobs_delay'));
////        Log::info('backoff seconds' . $backoffSeconds);
//		$backoffSeconds = min(30*60, $backoffSeconds);
//		$backoffSeconds = max(60, $backoffSeconds);
////		Log::info('backoff seconds ' . $backoffSeconds);
//		$backoffMinutes = intval($backoffSeconds / 60);
//
//        Log::info("backing off for -- " . strval($backoffMinutes) . ' minutes');
//        return $backoffMinutes;
//    }


    /**
     * @return bool
     */
    private function isHighLoad(){
//		Log::info('getLoad: ' . $this->getLoad());
//		Log::info('config.load: ' . intval(config('slow-queries.delay_jobs_when_load_is_higher_than')));

        return $this->getLoad() > intval(config('slow-queries.delay_jobs_when_load_is_higher_than'));
    }

    public function getLoad(): float|int
    {
        $avgLoad = sys_getloadavg();
        $weightedAverage = $avgLoad ? ($avgLoad[0] * 3 + $avgLoad[1] * 2 + $avgLoad[2]) / 6 : 0;

        $load = $weightedAverage / $this->numberOfCores();

//        Log::info(strval($load));
//        Log::info(strval($this->numberOfCores()));
        return $load;
    }

    /**
     * @return int
     */
    private function numberOfCores(): int
    {
        $cores = 1; // default value
        if (is_readable('/proc/cpuinfo')) {
            $cpuinfo = file_get_contents('/proc/cpuinfo');
            preg_match_all('/^processor/m', strval($cpuinfo), $matches);
            $cores = count($matches[0]);
        } else if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
            $process = @popen('wmic cpu get NumberOfCores', 'rb');
            if (false !== $process) {
                fgets($process);
                $cores = intval(fgets($process));
                pclose($process);
            }
        } else {
            $cores = intval(shell_exec('sysctl -n hw.ncpu'));
        }

        return max(1, $cores);
    }
}
