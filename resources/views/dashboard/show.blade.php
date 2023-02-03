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
               <div id="drilldowndiv"></div>
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
        #gaugediv {
            width: 100%;
            height: 305px;
        }

        #drilldowndiv {
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
        var root = am5.Root.new("drilldowndiv");

        const myTheme = am5.Theme.new(root);

        myTheme.rule("RoundedRectangle", ["hierarchy", "node", "shape", "depth1"]).setAll({
            strokeWidth: 2
        });

        myTheme.rule("RoundedRectangle", ["hierarchy", "node", "shape", "depth2"]).setAll({
            fillOpacity: 0,
            strokeWidth: 1,
            strokeOpacity: 0.2
        });

        myTheme.rule("Label", ["node", "depth1"]).setAll({
            forceHidden: true
        });

        myTheme.rule("Label", ["node", "depth2"]).setAll({
            fontSize: 10
        });

        root.setThemes([
            am5themes_Animated.new(root),
            myTheme
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
                sort: "descending",
                singleBranchOnly: false,
                downDepth: 1,
                upDepth: 0,
                initialDepth: 1,
                valueField: "value",
                categoryField: "name",
                childDataField: "children",
                nodePaddingOuter: 0,
                nodePaddingInner: 0
            })
        );

        series.get("colors").set("step", 1);


        container.children.moveValue(
            am5hierarchy.BreadcrumbBar.new(root, {
                series: series
            }), 0
        );


// Generate and set data
// https://www.amcharts.com/docs/v5/charts/hierarchy/#Setting_data
        var data = {
            Acura: {
                ILX: 11757,
                MDX: 54886,
                NSX: 581,
                RDX: 51295,
                RLX: 1237,
                TLX: 34846
            },
            "Alfa Romeo": {"4C": 407, Giulia: 8903, Stelvio: 2721},
            Audi: {
                A3: 20733,
                "A3 e-tron": 2877,
                A4: 37674,
                A5: 21301,
                A6: 16304,
                A7: 4810,
                A8: 3127,
                Q3: 20633,
                Q5: 57640,
                Q7: 38346,
                R8: 772,
                TT: 2294
            },
            Bentley: {
                Bentayga: 1152,
                "Continental GT": 898,
                "Flying Spur": 257,
                Mulsanne: 98
            },
            BMW: {
                "2-Series": 11737,
                "3-Series": 59449,
                "4-Series": 39634,
                "5-Series": 40658,
                "6-Series": 3355,
                "7-Series": 9276,
                i3: 6276,
                i8: 488,
                X1: 30826,
                X3: 40691,
                X4: 5198,
                X5: 50815,
                X6: 6780,
                Z4: 502
            },
            Buick: {
                Cascada: 5595,
                Enclave: 48564,
                Encore: 88035,
                Envision: 41040,
                LaCrosse: 20161,
                Regal: 11559,
                Verano: 4277
            },
            Cadillac: {
                ATS: 13100,
                CT6: 10542,
                CTS: 10344,
                ELR: 17,
                Escalade: 37694,
                SRX: 156,
                XT5: 68312,
                XTS: 16275
            },
            Chevrolet: {
                Bolt: 23297,
                Camaro: 67940,
                "Caprice PPV": 693,
                "City Express": 8348,
                Colorado: 112996,
                Corvette: 25079,
                Cruze: 184751,
                Equinox: 290458,
                Express: 69164,
                Impala: 75877,
                Malibu: 185857,
                Silverado: 585864,
                Sonic: 30290,
                Spark: 22589,
                SS: 4055,
                Suburban: 56516,
                Tahoe: 98961,
                Traverse: 123506,
                Trax: 79289,
                Volt: 20349
            },
            Chrysler: {200: 18457, 300: 51237, Pacifica: 118274, "Town & Country": 577},
            Dodge: {
                Avenger: 14,
                Challenger: 64537,
                Charger: 88351,
                Dart: 10082,
                Durango: 68761,
                "Grand Caravan": 125196,
                Journey: 89470,
                Viper: 585,
                "RAM P/U": 500723,
                "RAM ProMaster": 40483,
                "RAM ProMaster City": 15584
            },
            Fiat: {"124 Spider": 4478, 500: 12685, "500L": 1664, "500X": 7665},
            Ford: {
                "C-Max": 18390,
                Edge: 142603,
                Escape: 308296,
                "E-Series": 53304,
                Expedition: 51883,
                Explorer: 271131,
                Fiesta: 46249,
                Flex: 22389,
                Focus: 158385,
                "F-Series": 896764,
                Fusion: 209623,
                GT: 89,
                Mustang: 81866,
                Taurus: 41236,
                Transit: 127360,
                "Transit Connect": 34473
            },
            Genesis: {G80: 16196, G90: 4398},
            GMC: {
                Acadia: 111276,
                Canyon: 32106,
                Savana: 29679,
                Sierra: 217943,
                Terrain: 85441,
                Yukon: 49183,
                "Yukon XL": 35059
            },
            Honda: {
                Accord: 322655,
                Civic: 377286,
                "Clarity FCV": 2455,
                Crosstour: 5,
                "CR-V": 377895,
                "CR-Z": 705,
                Fit: 49454,
                "HR-V": 94034,
                Insight: 3,
                Odyssey: 100307,
                Pilot: 127279,
                Ridgeline: 34749
            },
            Hyundai: {
                Accent: 58955,
                Azera: 3060,
                Elantra: 198210,
                Equus: 20,
                Genesis: 1152,
                Ioniq: 11197,
                "Santa Fe": 133171,
                Sonata: 131803,
                Tucson: 114735,
                Veloster: 12658
            },
            Infiniti: {
                Q50: 40739,
                Q60: 10751,
                Q70: 5772,
                QX30: 14093,
                QX50: 16857,
                QX60: 40444,
                QX70: 6878,
                QX80: 17881
            },
            Jaguar: {"F-Pace": 18946, "F-Type": 4108, XE: 9278, XF: 4541, XJ: 2721},
            Jeep: {
                Cherokee: 169882,
                Compass: 83253,
                "Grand Cherokee": 240696,
                Patriot: 10735,
                Renegade: 103434,
                Wrangler: 190522
            },
            Kia: {
                Cadenza: 7249,
                Forte: 117596,
                K900: 455,
                Niro: 27237,
                Optima: 107493,
                Rio: 16760,
                Sedona: 23815,
                Sorento: 99684,
                Soul: 115712,
                Sportage: 72824,
                Stinger: 843
            },
            "Land Rover": {
                "Discovery / LR4": 6398,
                "Discovery Sport": 14187,
                "Range Rover": 16869,
                "Range Rover Evoque": 11979,
                "Range Rover Sport": 19153,
                "Range Rover Velar": 6153
            },
            Lexus: {
                CT: 4690,
                ES: 51398,
                GS: 7773,
                GX: 27190,
                IS: 26482,
                LC: 2487,
                LFA: 3,
                LS: 4094,
                LX: 6004,
                NX: 59341,
                RC: 7363,
                RX: 108307
            },
            Lincoln: {
                Continental: 12012,
                MKC: 27048,
                MKS: 153,
                MKT: 3005,
                MKX: 31031,
                MKZ: 27387,
                Navigator: 10523
            },
            Maserati: {
                Ghibli: 5531,
                GranTurismo: 1018,
                Levante: 5448,
                Quattroporte: 1700
            },
            Mazda: {
                3: 75018,
                5: 10,
                6: 33402,
                "CX-3": 16355,
                "CX-5": 127563,
                "CX-9": 25828,
                "MX-5 Miata": 11294
            },
            "Mercedes-Benz": {
                "B-Class": 744,
                "C-Class": 77447,
                "CLA-Class": 20669,
                "E / CLS-Class": 51312,
                "G-Class": 4188,
                "GLA-Class": 24104,
                "GLC-Class": 48643,
                "GLE-Class": 54595,
                "GLS-Class": 32248,
                Metris: 7579,
                "S-Class": 15888,
                "SLC-Class": 2860,
                "SL-Class": 2940,
                Sprinter: 27415
            },
            Mini: {Cooper: 32232, Countryman: 14864, Paceman: 9},
            Mitsubishi: {
                "i MiEV": 6,
                Lancer: 12725,
                Mirage: 22386,
                Outlander: 35310,
                "Outlander PHEV": 99,
                "Outlander Sport": 33160
            },
            Nissan: {
                "370Z": 4614,
                Altima: 254996,
                Armada: 35667,
                Frontier: 74360,
                "GT-R": 578,
                Juke: 10157,
                Leaf: 11230,
                Maxima: 67627,
                Murano: 76732,
                NV: 17858,
                NV200: 18602,
                Pathfinder: 81065,
                Quest: 4950,
                Rogue: 403465,
                Sentra: 218451,
                Titan: 52924,
                Versa: 106772,
                Xterra: 1
            },
            Porsche: {
                911: 8970,
                Boxster: 2287,
                Cayenne: 13203,
                Cayman: 2800,
                Macan: 21429,
                Panamera: 6431
            },
            Smart: {Fortwo: 3071},
            Subaru: {
                BRZ: 4131,
                Crosstrek: 110138,
                Forester: 177563,
                Impreza: 117401,
                Legacy: 49837,
                Outback: 188886
            },
            Tesla: {"Model 3": 2320, "Model S †": 28800, "Model X †": 24000},
            Toyota: {
                "4Runner": 128296,
                "86/Scion FR-S": 6846,
                Avalon: 32583,
                Camry: 387081,
                "C-HR": 25755,
                Corolla: 329196,
                "FJ Cruiser": 4,
                Highlander: 215775,
                "Land Cruiser": 3100,
                Mirai: 1838,
                Prius: 108662,
                RAV4: 407594,
                Sequoia: 12156,
                Sienna: 111489,
                Tacoma: 198124,
                Tundra: 116285,
                Venza: 14,
                Yaris: 44380
            },
            Volkswagen: {
                Atlas: 27119,
                Beetle: 15166,
                CC: 1355,
                Eos: 1,
                Golf: 68978,
                Jetta: 115807,
                Passat: 60722,
                Tiguan: 46983,
                Touareg: 3545
            },
            Volvo: {S60: 16825, S80: 7, S90: 11090, XC60: 22516, XC90: 30996}
        };

        function processData(data) {
            var treeData = [];

            var smallBrands = {name: "Other", children: []};

            am5.object.eachOrdered(
                data,
                (brand) => {
                    var brandData = {name: brand, children: []};
                    var brandTotal = 0;
                    for (var model in data[brand]) {
                        brandTotal += data[brand][model];
                    }

                    for (var model in data[brand]) {
                        // do not add very small
                        if (data[brand][model] > 100) {
                            brandData.children.push({name: model, value: data[brand][model]});
                        }
                    }

                    // only bigger brands
                    if (brandTotal > 200000) {
                        treeData.push(brandData);
                    }
                },
                (a, b) => {
                    let aval = 0;
                    let bval = 0;
                    am5.object.each(data[a], (key, val) => (aval += val));
                    am5.object.each(data[b], (key, val) => (bval += val));
                    if (aval > bval) return -1;
                    if (aval < bval) return 1;
                    return 0;
                }
            );

            return [{
                children: treeData
            }];
        }

        series.data.setAll(processData(data));
        series.set("selectedDataItem", series.dataItems[0]);

        series.bullets.push(function (root, series, dataItem) {
            var depth = dataItem.get("depth");

            if (depth == 1) {
                var picture = am5.Picture.new(root, {
                    src: "https://www.amcharts.com/wp-content/uploads/assets/logos/" + dataItem.dataContext.name.toLowerCase() + ".png",
                    centerX: am5.p50,
                    centerY: am5.p50,
                    width: am5.percent(30),
                    isMeasured: true
                });

                picture.states.lookup("default").setAll({opacity: 0.15});

                return am5.Bullet.new(root, {sprite: picture});
            }
        });
    })
</script>
