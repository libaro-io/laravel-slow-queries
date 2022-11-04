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
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


//TODO  id for request to slowQuery table
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
        $slowQuery->action = $this->getActionFromSourceFrame($sourceFrame);
        $slowQuery->source_file = $this->getSourceFileFromSourceFrame($sourceFrame);
        $slowQuery->line = $this->getLineFromSourceFrame($sourceFrame);
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
     * @param SourceFrame|null $sourceFrame
     * @return string
     */
    private function getActionFromSourceFrame(?SourceFrame $sourceFrame): string
    {
        return $sourceFrame->action ?? '';
    }

    /**
     * @param SourceFrame|null $sourceFrame
     * @return string
     */
    private function getSourceFileFromSourceFrame(?SourceFrame $sourceFrame): string
    {
        $result = str_replace(base_path(), '', $sourceFrame->source_file ?? '');
        return $result;
    }

    /**
     * @param SourceFrame|null $sourceFrame
     * @return int
     */
    private function getLineFromSourceFrame(?SourceFrame $sourceFrame): int
    {
        return $sourceFrame->line ?? 0;
    }

    /**
     * @return ?SourceFrame
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getSourceFrame(): ?SourceFrame
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
