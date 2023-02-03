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
                                    class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    duration (s)
                                </th>
                                <th scope="col"
                                    class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 sm:pl-6">
                                    uri
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    count
                                </th>
                                <th scope="col"
                                    class="px-3 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">
                                    info
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($pages as $page)
                                <tr>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ ceil($page->the_duration / 1000) }}</td>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ \Libaro\LaravelSlowQueries\FormatHelper::abbreviate($page->the_uri, 60) }}</td>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{round($page->the_count) }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">
                                        <a href="{{ route('slow-queries.slow-pages.show', ['slowPage' => urlencode($page->the_guid)]) }}"><i
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
@endsection
