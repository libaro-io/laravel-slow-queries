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

class LaravelSlowQueries
{
    private Request $request;

    private string $request_guid;

    /**
     * @var Collection<int, SlowQuery>
     */
    private Collection $slowQueries;

    public function __construct()
    {
        $this->slowQueries = collect([]);
    }

    public function isPackageEnabled(): bool
    {
        return (bool) config('slow-queries.enabled');
    }

    public function startListening(): void
    {
        DB::listen(function (QueryExecuted $queryExecuted) {
            $this->setRequest();

            $slowQuery = $this->getDataFromQueryExecuted($queryExecuted);
            $this->slowQueries->push($slowQuery);
        });

        $this->registerTerminating();
    }

    private function registerTerminating(): void
    {
        $app = app();
        if ($app instanceof Application) {
            $app->terminating(function () {
                $this->saveSlowQueries();
            });
        }
    }

    private function saveSlowQueries(): void
    {
        SaveSlowQueries::dispatch($this->slowQueries);
    }

    private function setRequest(): void
    {
        $request = request();

        if ($request instanceof Request) {
            $this->request = $request;
        }

        $this->request_guid = Str::uuid();
    }

    private function getDataFromQueryExecuted(QueryExecuted $queryExecuted): SlowQuery
    {
        try {
            $sourceFrame = $this->getSourceFrame();
            $action = $this->getActionFromSourceFrame($sourceFrame);
            $sourceFile = $this->getSourceFileFromSourceFrame($sourceFrame);
            $line = $this->getLineFromSourceFrame($sourceFrame);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            $action = '';
            $sourceFile = '';
            $line = 0;
        }

        $slowQuery = new SlowQuery();
        $slowQuery->uri = $this->getUri();
        $slowQuery->action = $action;
        $slowQuery->source_file = $sourceFile;
        $slowQuery->line = $line;
        $slowQuery->query_hashed = $this->getHashedQuery($queryExecuted);
        $slowQuery->query_with_bindings = $this->getQueryWithBindings($queryExecuted);
        $slowQuery->query_without_bindings = $this->getQueryWithoutBindings($queryExecuted);
        $slowQuery->duration = $this->getDuration($queryExecuted);
        $slowQuery->request_guid = $this->request_guid;

        return $slowQuery;
    }

    private function getQueryWithBindings(QueryExecuted $query): string
    {
        return Str::replaceArray('?', $query->bindings, $query->sql);
    }

    private function getQueryWithoutBindings(QueryExecuted $query): string
    {
        return $query->sql;
    }

    private function getHashedQuery(QueryExecuted $query): string
    {
        return md5($query->sql);
    }

    private function getUri(): string
    {
        return $this->request->getRequestUri();
    }

    private function getActionFromSourceFrame(?SourceFrame $sourceFrame): string
    {
        return $sourceFrame->action ?? '';
    }

    private function getSourceFileFromSourceFrame(?SourceFrame $sourceFrame): string
    {
        $result = str_replace(base_path(), '', $sourceFrame->source_file ?? '');

        return $result;
    }

    private function getLineFromSourceFrame(?SourceFrame $sourceFrame): int
    {
        return $sourceFrame->line ?? 0;
    }

    /**
     * @return ?SourceFrame
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getSourceFrame(): ?SourceFrame
    {
        $querySource = new QuerySource();
        $source = $querySource->findSource();

        return $source;
    }

    private function getDuration(QueryExecuted $query): float
    {
        return $query->time;
    }
}
