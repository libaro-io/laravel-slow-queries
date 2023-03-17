@extends('slow-queries::layouts.default')

@section('content')
    <h1>Dashboard</h1>

    <div class="grid grid-cols-2 gap-5">
        {{----------------------------------}}
        {{-- slowest queries              --}}
        {{----------------------------------}}
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Slowest queries</h3>
                <h5 class="text-sm font-sm leading-6 text-gray-400">Showing the last 2 weeks</h5>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                <table class="table-auto w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-2 py-3">
                            QUERY
                        </th>
                        <th scope="col" class="px-2 py-3 text-right bg-primary">
                            Duration
                        </th>
                        <th scope="col" class="px-2 py-3 text-right">
                            Count
                        </th>
                        <th scope="col" class="px-2 py-3 text-center">
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($slowestQueriesAggregations as $slowQueryAggregation)
                        <tr class="bg-white border-b">
                            <td class="px-2 py-4 d-block overflow-hidden whitespace-nowrap truncate" >
                                <div class="text-ellipsis overflow-hidden whitespace-nowrap truncate">
                                    {{ \Libaro\LaravelSlowQueries\FormatHelper::abbreviate($slowQueryAggregation->queryWithoutBindings, 70, false)}}

                                </div>
                            </td>
                            <td class="px-2 py-4 text-right">
                                {{\Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowQueryAggregation->avgDuration)}}
                            </td>
                            <td class="px-2 py-4 text-right">
                                {{$slowQueryAggregation->queryCount}}
                            </td>
                            <td class="px-2 py-4 text-center">
                                <a href="{{ route('slow-queries.slow-queries.show', ['slowQuery' => $slowQueryAggregation->queryHashed ]) }}"><i
                                            class="fa-solid fa-eye text-indigo-600"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{----------------------------------}}
        {{-- gauge                        --}}
        {{----------------------------------}}
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Average query duration</h3>
                <h5 class="text-sm font-sm leading-6 text-gray-400">In milliseconds</h5>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                <div id="gaugediv"></div>
            </div>
        </div>

        {{----------------------------------}}
        {{-- slowest pages     --}}
        {{----------------------------------}}
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Slowest pages</h3>
                <h5 class="text-sm font-sm leading-6 text-gray-400">Showing the last 2 weeks</h5>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                <table class="table-auto w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-2 py-3">
                            URI
                        </th>
                        {{--                        <th scope="col" class="px-6 py-3">--}}
                        {{--                            URL--}}
                        {{--                        </th>--}}
                        <th scope="col" class="px-2 py-3 text-right">
                            Duration
                        </th>
                        <th scope="col" class="px-2 py-3 text-right">
                            Count
                        </th>
                        <th scope="col" class="px-2 py-3 text-center">

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($slowestPages as $slowPage)
                        <tr class="bg-white border-b">
                            <th scope="row"
                                class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{\Libaro\LaravelSlowQueries\FormatHelper::abbreviate($slowPage->uri, 500)}}
                            </th>
                            <td class="px-2 py-4 text-right">
                                {{\Libaro\LaravelSlowQueries\FormatHelper::formatNumber($slowPage->avgDuration)}}
                            </td>
                            <td class="px-2 py-4 text-right">
                                {{$slowPage->count}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('slow-queries.slow-pages.show', ['uriBase64Encoded' => base64_encode($slowPage->uri) ]) }}"><i
                                            class="fa-solid fa-eye text-indigo-600"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{----------------------------------}}
        {{-- drill down slowest pages     --}}
        {{----------------------------------}}
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Slowest pages hierarchy</h3>
                <h5 class="text-sm font-sm leading-6 text-gray-400">Showing the last 2 weeks</h5>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                <div id="treemapdiv"></div>
            </div>
        </div>
    </div>

    <style>
        #gaugediv {
            width: 100%;
            height: 305px;
        }

        #treemapdiv {
            width: 100%;
            height: 305px;
        }
    </style>

@endsection
<script src="//cdn.amcharts.com/lib/5/index.js"></script>
<script src="//cdn.amcharts.com/lib/5/xy.js"></script>
<script src="//cdn.amcharts.com/lib/5/radar.js"></script>
<script src="//cdn.amcharts.com/lib/5/hierarchy.js"></script>
<script src="//cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script>
    am5.ready(function () {
        var root = am5.Root.new("gaugediv");

        var gauge = root.container.children.push(
            am5radar.RadarChart.new(root, {
                startAngle: -180,
                endAngle: 0,
                radius: am5.percent(90),
                innerRadius: am5.percent(10),
            })
        );

        var axisRenderer = am5radar.AxisRendererCircular.new(root, {
            innerRadius: am5.percent(10),
            strokeOpacity: 1,
            strokewidth: 15,
            strokeGradient: am5.LinearGradient.new(root, {
                rotation: 0,
                stops: [
                    {color: am5.color(0x19d228)},
                    {color: am5.color(0xf4fb16)},
                    {color: am5.color(0xf6d32b)},
                    {color: am5.color(0xfb7116)},
                ]
            })

        });

        axisRenderer.ticks.template.setAll({
            visible: true,
            strokeOpacity: 0.5,
        });

        axisRenderer.grid.template.setAll({
            visible: false,
        })

        let maxValue = 5000;
        if ({{round($avgDuration)}} > 5000) {
            maxValue = Math.round({{round($avgDuration)}} / 1000 * 1.3) * 1000;
        }

        var axis = gauge.xAxes.push(
            am5xy.ValueAxis.new(root, {
                min: 0,
                max: maxValue,
                renderer: axisRenderer,
            })
        );

        var rangeDataItem = axis.makeDataItem({
            value: 0,
            value: {{round($avgDuration)}},
        });

        var range = axis.createAxisRange(rangeDataItem);

        var handDataItem = axis.makeDataItem({});
        handDataItem.set("value", 0);

        var hand = handDataItem.set("bullet", am5xy.AxisBullet.new(root, {
            sprite: am5radar.ClockHand.new(root, {
                radius: am5.percent(98),
                innerRadius: 15,
                pinRadius: 10,
            })
        }));

        axis.createAxisRange(handDataItem);

        handDataItem.get("grid").set("visible", false);

        setInterval(() => {
            handDataItem.animate({
                key: "value",
                to: {{round($avgDuration)}} + Math.round(Math.random() * {{round($avgDuration)}} / 10),
                duration: 600,
                easing: am5.ease.out(am5.ease.cubic)
            });
        }, 3500);
    });


    // DRILL DOWN CHART


    am5.ready(function () {
        // Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root2 = am5.Root.new("treemapdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
        root2.setThemes([
            am5themes_Animated.new(root2)
        ]);

// Create wrapper container
        var container = root2.container.children.push(
            am5.Container.new(root2, {
                width: am5.percent(100),
                height: am5.percent(100),
                layout: root2.verticalLayout
            })
        );

// Create series
// https://www.amcharts.com/docs/v5/charts/hierarchy/#Adding
        var series = container.children.push(
            am5hierarchy.Treemap.new(root2, {
                singleBranchOnly: false,
                downDepth: 1,
                upDepth: -1,
                initialDepth: 2,
                valueField: "value",
                categoryField: "name",
                childDataField: "children",
                nodePaddingOuter: 0,
                nodePaddingInner: 0,
            })
        );

        series.rectangles.template.setAll({
            strokeWidth: 2,
        });

// Generate and set data
// https://www.amcharts.com/docs/v5/charts/hierarchy/#Setting_data
        var maxLevels = 2;
        var maxNodes = 3;
        var maxValue = 100;

        var data = {
            name: "Root2",
            children: [
                {
                    name: "node5",
                    children: [
                        {
                            name: "/ (Home)",
                            value: 1200
                        },
                        // {
                        //     name: "/home/search",
                        //     value: 148
                        // }
                    ]
                },
                {
                    name: "node4",
                    children: [
                        {
                            name: "/slow-queries/queries/1",
                            value: 700
                        },
                        // {
                        //     name: "/products/id?=1389",
                        //     value: 148
                        // },
                        // {
                        //     name: "/products/id?=609",
                        //     value: 89
                        // },
                        // {
                        //     name: "/products/id?=207",
                        //     value: 64
                        // },
                        // {
                        //     name: "/product/id?=45",
                        //     value: 16
                        // }
                    ]
                },
                {
                    name: "node3",
                    children: [
                        {
                            name: "/login",
                            value: 600
                        },
                        // {
                        //     name: "/checkout/thankyou",
                        //     value: 98
                        // },
                        // {
                        //     name: "/checkout",
                        //     value: 56
                        // }
                    ]
                }, {
                    name: "node2",
                    children: [
                        {
                            name: "/logout",
                            value: 300
                        },
                        // {
                        //     name: "/account",
                        //     value: 60
                        // },
                        // {
                        //     name: "/login",
                        //     value: 30
                        // }
                    ]
                },
                // {
                //     name: "Third",
                //     children: [
                //         {
                //             name: "/categories",
                //             value: 335
                //         },
                //         {
                //             name: "/categories/id?=3",
                //             value: 148
                //         },
                //         {
                //             name: "/categories/id?=5",
                //             value: 126
                //         },
                //         {
                //             name: "/categories/id?=2",
                //             value: 26
                //         }
                //     ]
                // },
                {
                    name: "node1",
                    children: [
                        {
                            name: "/account",
                            value: 250
                        },
                        // {
                        //     name: "/account",
                        //     value: 60
                        // },
                        // {
                        //     name: "/login",
                        //     value: 30
                        // }
                    ]
                },
            ]
        };

        series.data.setAll([data]);
        series.set("selectedDataItem", series.dataItems[0]);

        series.labels.template.setAll({
            // text: "{category}: [bold]{sum}[/]",
            text: "{category}[/]",
            fontSize: 13
        });

// Make stuff animate on load
        series.appear(1000, 100);

    }); // end am5.ready()
</script>
