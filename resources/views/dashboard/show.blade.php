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
                            URL
                        </th>
                        <th scope="col" class="px-6 py-3">
                            QUERY
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Duration (s)
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
{{--                            View--}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tenSlowestQueries as $query)
                        <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th class="px-6 py-4">
                                {{$query->uri}}
                            </th>
                            <td class="px-6 py-4 text-center">
                                {{ \Libaro\LaravelSlowQueries\FormatHelper::abbreviate($query->query_without_bindings, 30, false)}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ceil($query->duration / 1000)}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('slow-queries.slowqueries.show', ['slowQuery' => $query ]) }}"><i
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
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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

    <style>
        #gaugeDiv {
            width: 100%;
            height: 500px;
        }
    </style>

@endsection
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>

<script>
    var root = am5.Root.new("gaugeDiv");

    var gauge = root.container.children.push(
        am5radar.RadarChart.new(root, {
            startAngle: -180,
            endAngle: 0,
            radius: am5.percent(95),
            innerRadius: am5.percent(98),
        })
    );

    var axisRenderer = am5radar.AxisRendererCircular.new(root, {
        strokeOpacity: 1,
        strokewidth: 15,
        strokeGradient: am5.LinearGradient.new(root, {
            rotation: 0,
            stops: [
                { color: am5.color(0x19d228) },
                { color: am5.color(0xf4fb16) },
                { color: am5.color(0xf6d32b) },
                { color: am5.color(0xfb7116) },
            ]
        })

    });

    axisRenderer.ticks.template.setAll({
        visible: true,
        strokeOpacity: 0.5,
    });

    axisRenderer.grid.template.setAll({
        visible:false,
    })

    var axis = chart.xAxes.push(
        am5xy.ValueAxis.new(root, {
            min: 0,
            max: 15000,
            renderer: axisRenderer,
        })
    );

    var rangeDataItem = axis.makeDataItem({
        value: 0,
        value: 12500,
    });

    var range = axis.createAxisRange(rangeDataItem);

    var handDataItem = axis.makeDataItem({
        value: 0
    });

    var hand = handDataItem.set("bullet", am5xy.AxisBullet.new(root, {
        sprite: am5radar.ClockHand.new(root, {
            radius: am5.percent(98),
            innerRadius: 15,
            pinRadius: 10,
        })
    }));

    axis.createAxisRange(handDataItem);
</script>
