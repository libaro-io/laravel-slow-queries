@extends('slow-queries::layouts.default')

@section('content')
    <h1>Dashboard</h1>

    <div class="grid grid-cols-2 gap-5">
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">10 Slowest Queries</h3>
                <h5 class="text-sm font-sm leading-6 text-gray-400">Showing the last 2 weeks</h5>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                <table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Query Id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            URL
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Duration
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            View
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tenSlowestQueries as $query)
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$query->id}}
                            </th>
                            <td class="px-6 py-4">
                                {{$query->uri}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{$query->duration}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('slow-queries.slowqueries.show', ['slowQuery' => $query->query_hashed ]) }}"><i
                                            class="fa-solid fa-eye text-indigo-600"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">10 Slowest Pages</h3>
                <h5 class="text-sm font-sm leading-6 text-gray-400">Showing the last 2 weeks</h5>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                <table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Query Id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            URL
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Duration
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            View
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tenSlowestQueries as $query)
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$query->id}}
                            </th>
                            <td class="px-6 py-4">
                                {{$query->uri}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{$query->duration}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('slow-queries.slowqueries.show', ['slowQuery' => $query->query_hashed ]) }}"><i
                                            class="fa-solid fa-eye text-indigo-600"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">10 Queriest Queries</h3>
                <h5 class="text-sm font-sm leading-6 text-gray-400">Showing the last 2 weeks</h5>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                <table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Query Id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            URL
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Duration
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            View
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tenSlowestQueries as $query)
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$query->id}}
                            </th>
                            <td class="px-6 py-4">
                                {{$query->uri}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{$query->duration}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('slow-queries.slowqueries.show', ['slowQuery' => $query->query_hashed ]) }}"><i
                                            class="fa-solid fa-eye text-indigo-600"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">10 Longest Queries</h3>
                <h5 class="text-sm font-sm leading-6 text-gray-400">Showing the last 2 weeks</h5>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                <table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Query Id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            URL
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Duration
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            View
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tenSlowestQueries as $query)
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$query->id}}
                            </th>
                            <td class="px-6 py-4">
                                {{$query->uri}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{$query->duration}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('slow-queries.slowqueries.show', ['slowQuery' => $query->query_hashed ]) }}"><i
                                            class="fa-solid fa-eye text-indigo-600"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
