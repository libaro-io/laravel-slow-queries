@extends('slow-queries::layouts.default')

@section('content')

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-6">
                                    uri
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    duration (ms)
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    source_file
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    line
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    query
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    info
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($queries as $query)
                                <tr>
                                    <th scope="col" class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-6">ID</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">uri</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">action (ms)</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">duration</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">source_file</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">line</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">info</th>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ substr($query->uri, 0, 20)   }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ round($query->avg_duration) }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ \Libaro\LaravelSlowQueries\FormatHelper::abbreviate($query->source_file, 30, true) }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $query->min_line }} {{ $query->max_line !== $query->min_line ? ' -> ' . $query->max_line : '' }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ \Libaro\LaravelSlowQueries\FormatHelper::abbreviate($query->query_without_bindings, 50)}}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">
                                        <a href="{{ route('slow-queries.slowqueries.show', ['slowQuery' => $query->query_hashed ]) }}"><i
                                                    class="fa-solid fa-eye"></i></a>
                                    </td>

                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($queries as $query)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $query->id }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $query->uri }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $query->action }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $query->duration }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $query->source_file }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{ $query->line }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">
                                            <a href="{{ route('slow-queries.queries.show', ['slowQuery' => $query->id ]) }}"><i class="fa-solid fa-eye"></i></a>
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <nav class="flex items-center justify-between bg-white px-4 py-3 sm:px-6" aria-label="Pagination">--}}
    {{--        <div class="hidden sm:block">--}}
    {{--            <p class="text-sm text-gray-700">--}}
    {{--                Showing--}}
    {{--                <span class="font-medium">{{ $queries->firstItem() }}</span>--}}
    {{--                to--}}
    {{--                <span class="font-medium">{{ $queries->lastItem() }}</span>--}}
    {{--                of--}}
    {{--                <span class="font-medium">{{ $queries->total() }}</span>--}}
    {{--                results--}}
    {{--            </p>--}}
    {{--        </div>--}}
    {{--        <div class="flex flex-1 justify-between sm:justify-end">--}}
    {{--            <a href="{{ $queries->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>--}}
    {{--            <a href="{{ $queries->nextPageUrl() }}" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>--}}
    {{--        </div>--}}
    {{--    </nav>--}}

@endsection
