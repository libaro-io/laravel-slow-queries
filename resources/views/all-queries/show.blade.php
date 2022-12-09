@extends('slow-queries::layouts.default')

@section('content')


    <div class="mx-auto mt-8 grid max-w-3xl grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2 lg:col-start-1">
            <!-- Description list-->
            <section aria-labelledby="applicant-information-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 id="applicant-information-title" class="text-lg font-medium leading-6 text-gray-900">Slow
                            Query Details</h2>
                        {{--                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details and application.</p>--}}
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6 bg-orange-50">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">ID</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $query->id }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $query->duration }} ms</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Source File</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $query->source_file }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Line</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $query->line }}</dd>
                            </div>
{{--                            <div class="sm:col-span-2">--}}
{{--                                <dt class="text-sm font-medium text-gray-500">Query</dt>--}}
{{--                                <dd class="mt-1 text-sm bg-gray-900 text-white p-4 rounded-md">{{ $query->query_with_bindings }}</dd>--}}
{{--                            </div>--}}
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Prettified</dt>
                            </div>

                            @if($query->hints)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Hints</dt>
                                    @foreach($query->hints as $hint)
                                        <dd class="mt-1 text-sm bg-gray-900 text-white p-4 rounded-md">{!! $hint !!}</dd>
                                    @endforeach
                                </div>
                            @endif

                            @foreach([$query->guessedMissingIndexes, $query->suggestedMissingIndexes] as $missingIndexes)
                                @if($missingIndexes->count())
                                    <div class="sm:col-span-2">
                                        <dt class="text-sm font-medium text-gray-500">You might consider creating indexes for these columns (if not already):</dt>
                                        @foreach($missingIndexes as $missingIndex)
                                            <dd class="mt-1 text-sm bg-gray-900 text-white p-4 rounded-md">{!! $missingIndex !!}</dd>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </dl>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-xl font-medium leading-6 text-gray-900 sm:truncate">Slow Query Details</h1>
        </div>
        <div class="mt-4 flex sm:mt-0 sm:ml-4">
            <a href="{{ url()->previous() }}" type="button"
               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-4 h-4 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75"/>
                </svg>
                Back
            </a>
{{--            <button type="button" class="sm:order-0 order-1 ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:ml-0">Back</button>--}}
        </div>
    </div>
    <!-- Pinned projects -->
    <div class="mt-6 px-4 sm:px-6 lg:px-8">
        <h2 class="text-md font-medium text-gray-900">Quick Facts</h2>
        <ul role="list" class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4">
            <li class="relative col-span-1 flex rounded-md rounded-lg border border-gray-300 shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md"><i class="fa-solid fa-hashtag"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Query ID</p>
                        <p class="text-gray-500">{{ $query->id }}</p>
                    </div>
                </div>
            </li>
            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md"><i class="fa-solid fa-stopwatch"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Duration</p>
                        <p class="text-gray-500">{{ $query->duration }} Ms</p>
                    </div>
                </div>
            </li>
            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md"><i class="fa-solid fa-file"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Source File</p>
                        <p class="text-gray-500">{{ $query->source_file }}</p>
                    </div>
                </div>
            </li>
            <li class="relative col-span-1 flex rounded-md shadow-sm">
                <div class="flex-shrink-0 flex items-center justify-center w-16 bg-indigo-900 text-white text-xl font-medium rounded-l-md"><i class="fa-solid fa-grip-lines"></i></div>
                <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                    <div class="flex-1 truncate px-4 py-2 text-sm">
                        <p class="font-medium text-gray-900">Line</p>
                        <p class="text-gray-500">{{ $query->line }}</p>
                    </div>
                </div>
            </li>
            <!-- More items... -->
        </ul>
    </div>
    <div class="mt-10 px-4 sm:px-6 lg:px-8">
        <h2 class="text-md font-medium text-gray-900">Prettified Query</h2>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 rounded-lg border border-gray-300 mt-3">
            <dd class="mt-4 mb-4 text-sm bg-gray-900 text-white">{!! $query->prettyQuery !!}</dd>
        </div>
    </div>
    <div class="mt-10 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </div>
                <div class="min-w-0 flex-1">
                    <a href="#" class="focus:outline-none">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Leslie Alexander</p>
                        <p class="truncate text-sm text-gray-500">Co-Founder / CEO</p>
                    </a>
                </div>
            </div>

            <!-- More people... -->
        </div>
    </div>


@endsection
