<?php /** @var  Libaro\LaravelSlowQueries\Data\SlowPageAggregation $slowPageAggregation */ ?>
@extends('slow-queries::layouts.default')

@section('custom_css')
    <style>
        .collapsible .collapsible-content {
            display: none;
        }

        .collapsible.active .collapsible-content {
            display: block;
        }

        .collapsible.active a {
            padding-bottom: 1.25rem;
        }
    </style>
@endsection

@section('content')

    <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-xl font-medium leading-6 text-gray-900 sm:truncate">Slow Page Details</h1>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4">
            <a href="{{ url()->previous() }}" type="button"
               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor"
                     class="w-4 h-4 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75"/>
                </svg>
                Back
            </a>
            {{--            <button type="button" class="sm:order-0 order-1 ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:ml-0">Back</button>--}}
        </div>
    </div>
    <!-- Pinned projects -->
    <div class="mt-6 px-4 sm:px-6 lg:px-8">
        <ul role="list" class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-3">

            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-file"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Uri</p>
                        <p class="text-gray-500">
                            {{ $slowPageAggregation->uri }}
                        </p>
                    </div>
                </div>
            </li>
            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-stopwatch"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Avg. Query Count</p>
                        <p class="text-gray-500">
                            {{ \Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowPageAggregation->avgQueryCount ) }}
                        </p>
                    </div>
                </div>
            </li>
            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-hashtag"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Count</p>
                        <p class="text-gray-500">
                            {{ $slowPageAggregation->count }}
                        </p>
                    </div>
                </div>
            </li>


            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-file"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Avg. Duration</p>
                        <p class="text-gray-500">
                            {{ $slowPageAggregation->avgDuration }}
                            ms
                        </p>
                    </div>
                </div>
            </li>
            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-stopwatch"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Max Duration</p>
                        <p class="text-gray-500">
                            {{ \Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowPageAggregation->maxDuration) }}
                            ms</p>
                    </div>
                </div>
            </li>
            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-hashtag"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Min Duration</p>
                        <p class="text-gray-500">
                            {{ $slowPageAggregation->minDuration }}
                            ms
                        </p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    {{--    <div class="mt-10 px-4 sm:px-6 lg:px-8">--}}
    {{--        <h2 class="text-md font-medium text-gray-900">Query</h2>--}}
    {{--        <div class="fmx-auto max-w-7xl sm:px-6 lg:px-8 rounded-lg border border-gray-300 mt-3">--}}
    {{--            <dd class=" mt-4 mb-4 text-sm bg-gray-900 text-white">--}}
    {{--                --}}{{--                {!! $slowQueryAggregation->prettyQuery !!}--}}
    {{--            </dd>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    @if($slowPageAggregation->details)
        <div class="mt-10 px-4 sm:px-6 lg:px-8 w-100">
            <div class="flex justify-between mb-5">

                    <span class="isolate inline-flex rounded-md shadow-sm">
                                <button
                                        onclick="showCategory('pageRequests')"
                                        type="button"
                                        class="pageRequestsButton categoriesButton relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"><i
                                            class="fa-regular fa-calendar-days fa-fw">
                                    </i>&nbsp;&nbsp;Page Requests
                                </button>
                                <button
                                        onclick="showCategory('queries')"
                                        type="button"
                                        class="queriesButton categoriesButton relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                    <i class="fa-solid fa-clock fa-fw"></i>&nbsp;&nbsp;Queries
                                </button>
                            </span>

                <div class="pageRequestsTabs">
                    <span class="font-normal text-xs text-gray-400 mr-3"> Sort by</span>
                    <span class="isolate inline-flex rounded-md shadow-sm">
                                <button
                                        onclick="showList('pagesByLatest')"
                                        type="button"
                                        class="pagesByLatestButton detailsListButton relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"><i
                                            class="fa-regular fa-calendar-days fa-fw">
                                    </i>&nbsp;&nbsp;Latest first
                                </button>
                                <button
                                        onclick="showList('pagesByDuration')"
                                        type="button"
                                        class="pagesByDurationButton detailsListButton relative -ml-px inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                    <i class="fa-solid fa-clock fa-fw"></i>&nbsp;&nbsp;Slowest first
                                </button>
                                <button
                                        onclick="showList('pagesByMostQueries')"
                                        type="button"
                                        class="pagesByMostQueriesButton detailsListButton relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                    <i class="fa-solid fa-clock fa-fw"></i>&nbsp;&nbsp;Most queries
                                </button>
                            </span>
                </div>

                <div class="queriesTabs hidden">
                    <span class="font-normal text-xs text-gray-400 mr-3"> Sort by</span>
                    <span class="isolate inline-flex rounded-md shadow-sm">
                                <button
                                        onclick="showList('queriesByLatest')"
                                        type="button"
                                        class="queriesByLatestButton detailsListButton relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"><i
                                            class="fa-regular fa-calendar-days fa-fw">
                                    </i>&nbsp;&nbsp;Latest first
                                </button>
                                <button
                                        onclick="showList('queriesByDuration')"
                                        type="button"
                                        class="queriesByDurationButton detailsListButton relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                    <i class="fa-solid fa-clock fa-fw"></i>&nbsp;&nbsp;Slowest first
                                </button>
                            </span>
                </div>
            </div>
            <div class="detailsLists block">
                @include('slow-queries::slow-pages.partials._detail_list',['classes' => 'pagesByLatest detailsList block', 'details' => $slowPageAggregation->details->sortByDesc('created_at')])
                @include('slow-queries::slow-pages.partials._detail_list',['classes' => 'pagesByDuration detailsList hidden', 'details' => $slowPageAggregation->details->sortByDesc('the_page_duration')])
                @include('slow-queries::slow-pages.partials._detail_list',['classes' => 'pagesByMostQueries detailsList hidden', 'details' => $slowPageAggregation->details->sortByDesc('the_query_count')])
            </div>

            <div class="queriesLists hidden">
            @include('slow-queries::slow-pages.partials._query_list',['classes' => 'queriesByLatest queriesList block', 'slowQueries' => $slowPageAggregation->slowQueries->sortByDesc('created_at')])
            @include('slow-queries::slow-pages.partials._query_list',['classes' => 'queriesByDuration queriesList hidden', 'slowQueries' => $slowPageAggregation->slowQueries->sortByDesc('duration')])
            </div>


        </div>
    @endif

@endsection

@section('custom_js')
    <script src="{{ asset('laravel-slow-queries/js/collapsible.js?') }}{{\Illuminate\Support\Str::random(10)}}"></script>
    <script src="{{ asset('laravel-slow-queries/js/pages.js?') }}{{\Illuminate\Support\Str::random(10)}}"></script>
@endsection