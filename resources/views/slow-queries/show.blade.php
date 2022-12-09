@extends('slow-queries::layouts.default')

@section('content')

    <a href="{{ url()->previous() }}" type="button"
       class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             class="w-4 h-4 mr-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75"/>
        </svg>
        Back
    </a>
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
                    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
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
                                <dt class="text-sm font-medium text-gray-500">Query</dt>
                                <dd class="mt-1 text-sm bg-gray-900 text-white p-4 rounded-md">{!! $query->prettyQuery !!}</dd>
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

@endsection
