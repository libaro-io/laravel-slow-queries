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
            <h1 class="text-xl font-medium leading-6 text-gray-900 sm:truncate">Slow Query Details</h1>
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
{{--        <h2 class="text-md font-medium text-gray-900">Quick Facts</h2>--}}
        <ul role="list" class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-3">

            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-file"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Source File</p>
                        <p class="text-gray-500">{{ $slowQueryData->sourceFile }}</p>
                    </div>
                </div>
            </li>
            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-grip-lines"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Line</p>
                        <p class="text-gray-500">{{ \Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowQueryData->minLine) }} {{$slowQueryData->maxLine != $slowQueryData->minLine ? ' - ' . \Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowQueryData->maxLine) : ''}}</p>
                    </div>
                </div>
            </li>
            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-grip-lines"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Count</p>
                        <p class="text-gray-500">{{ $slowQueryData->queryCount }}</p>
                    </div>
                </div>
            </li>

            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-stopwatch"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Avg. Duration</p>
                        <p class="text-gray-500">{{ \Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowQueryData->avgDuration) }} ms</p>
                    </div>
                </div>
            </li>
            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-stopwatch"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Max Duration</p>
                        <p class="text-gray-500">{{ \Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowQueryData->maxDuration) }} ms</p>
                    </div>
                </div>
            </li>
            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md">
                    <i class="fa-solid fa-stopwatch"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Min Duration</p>
                        <p class="text-gray-500">{{ \Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowQueryData->minDuration) }} ms</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="mt-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-md font-medium text-gray-900">Query</h2>
        <div class="fmx-auto max-w-7xl sm:px-6 lg:px-8 rounded-lg border border-gray-300 mt-3">
            <dd class=" mt-4 mb-4 text-sm bg-gray-900 text-white">{!! $slowQueryData->prettyQuery !!}</dd>
        </div>
    </div>

    @if($slowQueryData->details)
        <div class="mt-10 px-4 sm:px-6 lg:px-8">
            <h2 class="text-md font-medium text-gray-900">Occurences</h2>
            <div class="overflow-hidden bg-white shadow sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($slowQueryData->details as $slowQuery)
                        <li class="collapsible">
                            <a href="#" onclick="return false;" class="  block hover:bg-gray-50 fpb-3">
                                <div class="flex items-center px-4 py-4 sm:px-6 collapsible-sub">
                                    <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                        <div class="truncate">
                                            <div class="flex text-sm">
                                                <p class="truncate font-bold text-indigo-600">{{$slowQuery->source_file}}
                                                    :{{\Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowQuery->line)}}</p>
                                                <p class="ml-1 flex-shrink-0 font-normal text-gray-400">{{$slowQuery->action}}</p>
                                            </div>
                                            <div class="mt-2 flex">
                                                <div class="flex items-center font-medium text-sm text-red-400">
                                                    <i class="fa-regular fa-clock fa-fw"></i>

                                                    <p>
                                                        &nbsp;{{ \Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowQuery->duration)}} ms
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="mt-2 flex">
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <i class="fa-regular fa-calendar fa-fw"></i>
                                                    <p>
                                                        &nbsp;{{ $slowQuery->created_at->diffForHumans()}}
                                                        •
                                                        {{ $slowQuery->created_at->format('l M jS, H:i:s')}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="collapsible-content mx-5 fmx-auto max-w-7xl sm:px-6 lg:px-8 rounded-lg border border-gray-300 bg-white fmt-3">
                                    <dd class=" mt-4 mb-4 text-sm bg-gray-900 text-white">{!! $slowQuery->prettyQuery !!}</dd>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>

        {{--    @if($slowQueryData->hints)--}}
        {{--    <div class="mt-10 px-4 sm:px-6 lg:px-8">--}}
        {{--        <h2 class="text-md font-medium text-gray-900">Hints</h2>--}}
        {{--        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-3">--}}
        {{--            @foreach($slowQueryData->hints as $hint)--}}
        {{--            <div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">--}}
        {{--                <div class="flex-shrink-0 text-xl">--}}
        {{--                    <i class="fa-solid fa-lightbulb text-yellow-400"></i>--}}
        {{--                    <i class="fa-solid fa-exclamation text-indigo-900"></i>--}}
        {{--                </div>--}}
        {{--                <div class="min-w-0 flex-1">--}}
        {{--                    <a href="#" class="focus:outline-none">--}}
        {{--                        <span class="absolute inset-0" aria-hidden="true"></span>--}}
        {{--                        <p class="text-sm font-medium text-gray-900">{!! $hint !!}</p>--}}
        {{--                    </a>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--            @endforeach--}}
        {{--            <!-- More people... -->--}}
        {{--        </div>--}}
        {{--    </div>--}}
        {{--    @endif--}}
        {{--    @if($slowQueryData->suggestedMissingIndexes)--}}
        {{--        <div class="mt-10 px-4 sm:px-6 lg:px-8">--}}
        {{--            <h2 class="text-md font-medium text-gray-900">Indexes</h2>--}}
        {{--            <div class="overflow-hidden bg-white border border-gray-300 sm:rounded-md mt-3">--}}
        {{--                <ul role="list" class="divide-y divide-gray-300">--}}
        {{--                    @foreach($slowQuery->suggestedMissingIndexes as $index)--}}
        {{--                        <li>--}}
        {{--                            <a href="#" class="block hover:bg-gray-50">--}}
        {{--                                <div class="flex items-center px-4 py-4 sm:px-6">--}}
        {{--                                    <div class="flex min-w-0 flex-1 items-center">--}}
        {{--                                        <div class="flex-shrink-0 text-red-600">--}}
        {{--                                            <i class="fa-solid fa-circle-question"></i>--}}
        {{--                                        </div>--}}
        {{--                                        <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">--}}
        {{--                                            <div>--}}
        {{--                                                <p class="text-sm font-medium text-red-600">Missing Index!</p>--}}
        {{--                                            </div>--}}
        {{--                                            <div class="hidden md:block">--}}
        {{--                                                <div>--}}
        {{--                                                    <p class="text-sm font-medium text-gray-900">{!! $index !!}</p>--}}
        {{--                                                </div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                    <div>--}}
        {{--                                        <p class="text-sm inline font-medium text-gray-900">ADD</p>--}}
        {{--                                        <!-- Heroicon name: mini/chevron-right -->--}}
        {{--                                        <svg class="h-5 w-5 text-gray-400 inline" xmlns="http://www.w3.org/2000/svg"--}}
        {{--                                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
        {{--                                            <path fill-rule="evenodd"--}}
        {{--                                                  d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"--}}
        {{--                                                  clip-rule="evenodd"/>--}}
        {{--                                        </svg>--}}
        {{--                                    </div>--}}
        {{--                                </div>--}}
        {{--                            </a>--}}
        {{--                        </li>--}}
        {{--                    @endforeach--}}
        {{--                </ul>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--    @endif--}}


        @endsection

        @section('custom_js')
            <script>
                var coll = document.getElementsByClassName("collapsible");
                var i;

                for (i = 0; i < coll.length; i++) {
                    coll[i].addEventListener("click", function () {
                        this.classList.toggle("active");
                        // var content = this.nextElementSibling;
                        // if (content.style.display === "block") {
                        //     content.style.display = "none";
                        // } else {
                        //     content.style.display = "block";
                        // }
                    });
                }
            </script>
        @endsection