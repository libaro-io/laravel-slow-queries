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
                    @foreach($SlowestQueries as $query)
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
                <h3 class="text-lg font-medium leading-6 text-gray-900">Average Query Duration</h3>
                <h5 class="text-sm font-sm leading-6 text-gray-400">In milliseconds</h5>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                <div id="gaugediv"></div>
            </div>
        </div>
        <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Page Speed Hierarchy</h3>
                <h5 class="text-sm font-sm leading-6 text-gray-400">Showing the last 2 weeks</h5>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
               <div id="treemapdiv"></div>
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
                    @foreach($SlowestQueries as $query)
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
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/hierarchy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script>
    am5.ready(function () {
        var root = am5.Root.new("gaugediv");

        var gauge = root.container.children.push(
            am5radar.RadarChart.new(root, {
                startAngle: -180,
                endAngle: 0,
                radius: am5.percent(95),
                innerRadius: am5.percent(98),
            })
        );

        var axisRenderer = am5radar.AxisRendererCircular.new(root, {
            innerRadius: -10,
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

        var axis = gauge.xAxes.push(
            am5xy.ValueAxis.new(root, {
                min: 0,
                max: 5000,
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
                to: {{round($avgDuration)}} + Math.round(Math.random() * 750),
                duration: 800,
                easing: am5.ease.out(am5.ease.cubic)
            });
        }, 2000);
    });


    // DRILL DOWN CHART



    am5.ready(function() {
        // Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("treemapdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);

// Create wrapper container
        var container = root.container.children.push(
            am5.Container.new(root, {
                width: am5.percent(100),
                height: am5.percent(100),
                layout: root.verticalLayout
            })
        );

// Create series
// https://www.amcharts.com/docs/v5/charts/hierarchy/#Adding
        var series = container.children.push(
            am5hierarchy.Treemap.new(root, {
                singleBranchOnly: false,
                downDepth: 1,
                upDepth: -1,
                initialDepth: 2,
                valueField: "value",
                categoryField: "name",
                childDataField: "children",
                nodePaddingOuter: 0,
                nodePaddingInner: 0
            })
        );

        series.rectangles.template.setAll({
            strokeWidth: 2
        });

// Generate and set data
// https://www.amcharts.com/docs/v5/charts/hierarchy/#Setting_data
        var maxLevels = 2;
        var maxNodes = 3;
        var maxValue = 100;

        var data = {
            name: "Root",
            children: [
                {
                    name: "First",
                    children: [
                        {
                            name: "/faq",
                            value: 100
                        },
                        {
                            name: "/account",
                            value: 60
                        },
                        {
                            name: "/login",
                            value: 30
                        }
                    ]
                },
                {
                    name: "Second",
                    children: [
                        {
                            name: "/checkout/step1",
                            value: 135
                        },
                        {
                            name: "/checkout/thankyou",
                            value: 98
                        },
                        {
                            name: "/checkout",
                            value: 56
                        }
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
                    name: "Fourth",
                    children: [
                        {
                            name: "/products/index",
                            value: 415
                        },
                        {
                            name: "/products/id?=1389",
                            value: 148
                        },
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
                    name: "Fifth",
                    children: [
                        {
                            name: "/home",
                            value: 687
                        },
                        // {
                        //     name: "/home/search",
                        //     value: 148
                        // }
                    ]
                }
            ]
        };

        series.data.setAll([data]);
        series.set("selectedDataItem", series.dataItems[0]);

// Make stuff animate on load
        series.appear(1000, 100);

    }); // end am5.ready()
</script>
