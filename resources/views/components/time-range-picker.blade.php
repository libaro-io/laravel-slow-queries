<div class="daterange fflex justify-end" x-data="{ open: false }" >
    <div class="relative flex justify-end w-full min-w-[200px] border py-3">
        <button type="button"
                class="inline-flex justify-between items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900 px-4 w-full"
                aria-expanded="false"
                x-on:click="open = ! open"

        >
            <span class="text-gray-400">Time picker</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="#9CA3AF" aria-hidden="true">
                <path fill-rule="evenodd"
                      d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                      clip-rule="evenodd"/>
            </svg>
        </button>

        <div class="absolute top-0 mt-[50px] right-0 z-10 fmt-12 flex w-[200px]"
             x-show="open"
             @click.outside="open = false">
            <div class="w-screen max-w-md flex-auto overflow-hidden bg-white text-sm leading-6 shadow-lg ring-1 ring-gray-900/5 lg:max-w-3xl">
                <div class="grid grid-cols-1 gap-x-6 gap-y-1 px-4">
                    <div class="group relative flex gap-x-6 rounded-lg px-4 py-1 w-full ">

                        <ul role="list" class="divide-y divide-gray-100 w-full">

                            @foreach(\Libaro\LaravelSlowQueries\ValueObjects\TimeRanges::getValids() as $timeRange)
                                <li class="flex gap-x-4 py-2 items-center text-gray-400 w-full hover:text-gray-900 hover:cursor-pointer"
                                    @click="sendTimeRange('{{$timeRange['duration']}}')">

                                    {{--                                    <i class="fa-solid fa-circle-check text-"></i>--}}
                                    <i class="fa-regular fa-clock"></i>

                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold leading-6  hover:text-gray-900">{{$timeRange['label']}}</p>

                                    </div>
                                </li>
                            @endforeach

                        </ul>


                    </div>
                </div>
                {{--            <div class="bg-gray-50 px-8 py-6">--}}
                {{--                <div class="flex items-center gap-x-3">--}}
                {{--                    <h3 class="text-sm font-semibold leading-6 text-gray-900">Enterprise</h3>--}}
                {{--                    <p class="rounded-full bg-indigo-600/10 px-2.5 py-1.5 text-xs font-semibold text-indigo-600">New</p>--}}
                {{--                </div>--}}
                {{--                <p class="mt-2 text-sm leading-6 text-gray-600">Empower your entire team with even more advanced tools.</p>--}}
                {{--            </div>--}}
            </div>
        </div>
    </div>
</div>


@push('custom_js')
    <script>
        function sendTimeRange(timeRange) {
            console.log("sending time range", timeRange);

            const url = '{{route('slow-queries.timerange.store')}}';
            const csrfToken = '{{ csrf_token() }}';


            // Replace with your preferred method (POST, PUT, etc.) and headers
            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken, // Set the CSRF token in the headers
                },
                body: JSON.stringify({timeRange}),
            };

            // Send the request to the backend
            fetch(url, options)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to save time range');
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
@endpush