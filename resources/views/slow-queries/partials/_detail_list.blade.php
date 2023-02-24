<?php /** @var  \Illuminate\Support\Collection<int, Libaro\LaravelSlowQueries\Models\SlowQuery> $details */ ?>
<div class="overflow-hidden bg-white shadow sm:rounded-md {{$classes ?? ''}}">
    <ul role="list" class="divide-y divide-gray-200">
        @foreach($details as $slowQuery)
            <li class="collapsible">
                <a href="#" onclick="return false;" class="  block hover:bg-gray-50 fpb-3 cursor-pointer">
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
                                            &nbsp;{{ \Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowQuery->duration)}}
                                            ms
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-2 flex">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <p>
                                            <span>{{config('app.url') ?? '/'}}{{ $slowQuery->uri }}</span>
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
</div>