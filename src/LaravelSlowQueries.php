<?php

namespace Libaro\LaravelSlowQueries;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Libaro\LaravelSlowQueries\Jobs\SaveSlowQueries;
use Libaro\LaravelSlowQueries\Models\SlowQuery;
use Libaro\LaravelSlowQueries\ValueObjects\SourceFrame;

class LaravelSlowQueries
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var Collection<int, SlowQuery>
     */
    private Collection $slowQueries;

    private $stack;

    public function __construct()
    {
        $this->slowQueries = collect([]);
    }

    /**
     * @return bool
     */
    public function isPackageEnabled(): bool
    {
        return (bool)config('slow-queries.enabled');
    }

    /**
     * @return void
     */
    public function startListening(): void
    {
        DB::listen(function (QueryExecuted $queryExecuted) {
            $this->setRequest();

            $slowQuery = $this->getDataFromQueryExecuted($queryExecuted);
            $this->slowQueries->push($slowQuery);
        });

        $this->registerTerminating();
    }

    /**
     * @return void
     */
    private function registerTerminating(): void
    {
        $app = app();
        if ($app instanceof Application) {
            $app->terminating(function () {
                $this->saveSlowQueries();
            });
        }
    }

    /**
     * @return void
     */
    private function saveSlowQueries(): void
    {
        SaveSlowQueries::dispatch($this->slowQueries);
    }

    /**
     * @return void
     */
    private function setRequest(): void
    {
        $request = request();

        if ($request instanceof Request) {
            $this->request = $request;
        }
    }

    /**
     * @param QueryExecuted $queryExecuted
     * @return SlowQuery
     */
    private function getDataFromQueryExecuted(QueryExecuted $queryExecuted): SlowQuery
    {
        $sourceFrame = $this->getSourceFrame();


        $slowQuery = new SlowQuery();
        $slowQuery->uri = $this->getUri();
        $slowQuery->action = $this->getNameFromSourceFrame($sourceFrame);
        $slowQuery->query = $this->getQueryWithParams($queryExecuted);
        $slowQuery->duration = $this->getDuration($queryExecuted);

        return $slowQuery;
    }

    /**
     * @param QueryExecuted $query
     * @return string
     */
    private function getQueryWithParams(QueryExecuted $query): string
    {
        return Str::replaceArray('?', $query->bindings, $query->sql);
    }

    /**
     * @return string
     */
    private function getUri(): string
    {
        return $this->request->getRequestUri();
    }

    /**
     * @return string
     */
    private function getNameFromSourceFrame(SourceFrame $sourceFrame): string
    {
//        return $this->getNameFromSourceFrame()


        return '';
//        dd($stack);
    }
    /**
     * @return string
     */
    private function getLineFromSourceFrame(SourceFrame $sourceFrame): string
    {
//        return $this->getNameFromSourceFrame()


        return '';
//        dd($stack);
    }


    /**
     * @return SourceFrame
     */
    private function getSourceFrame(): SourceFrame
    {
        $querySource = new QuerySource();
        $source = $querySource->findSource();
        return $source;
    }

    /**
     * @param QueryExecuted $query
     * @return float
     */
    private function getDuration(QueryExecuted $query): float
    {
        return $query->time;
    }
}
