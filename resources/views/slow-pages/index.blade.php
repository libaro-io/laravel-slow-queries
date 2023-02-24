<?php /** @var  Illuminate\Support\Collection<int, Libaro\LaravelSlowQueries\Data\SlowPageAggregation> $slowPagesAggregations */ ?>

@extends('slow-queries::layouts.default')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8">
        <h1>Slow pages</h1>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    uri
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    duration (s)
                                </th>
                                <th scope="col"
                                    class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-6">
                                    count
                                </th>

                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    info
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($slowPagesAggregations as $slowPagesAggregation)
                                <tr>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ \Libaro\LaravelSlowQueries\FormatHelper::abbreviate($slowPagesAggregation->uri, 50)}}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ ceil($slowPagesAggregation->avgDuration / 1000) }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 sm:pl-6">{{ $slowPagesAggregation->queryCount}}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">
                                        <a href="{{ route('slow-queries.slow-pages.show', ['slowPage' => urlencode($slowPagesAggregation->uri) ]) }}"><i
                                                    class="fa-solid fa-eye text-indigo-600"></i></a>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="flex items-center justify-between bg-white px-4 py-3 sm:px-6" aria-label="Pagination">
        <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ $slowPagesAggregations->firstItem() }}</span>
                to
                <span class="font-medium">{{ $slowPagesAggregations->lastItem() }}</span>
                of
                <span class="font-medium">{{ $slowPagesAggregations->total() }}</span>
                results
            </p>
        </div>
        <div class="flex flex-1 justify-between sm:justify-end">
            <a href="{{ $slowPagesAggregations->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="{{ $slowPagesAggregations->nextPageUrl() }}" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        </div>
    </nav>

@endsection
