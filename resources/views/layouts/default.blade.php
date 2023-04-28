<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Libaro ~ Laravel Slow Queries</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{--    <script src="https://kit.fontawesome.com/e9e218acb7.js" crossorigin="anonymous"></script>--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
          integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdn.jsdelivr.net/npm/umbrellajs"></script>
    <script src="{{ asset('laravel-slow-queries/js/copy.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @yield('custom_css')
</head>
<body>
<div>
    <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex min-h-0 flex-1 flex-col bg-gray-800">
            <div class="flex h-16 flex-shrink-0 items-center bg-gray-900 text-white px-4">
                Laravel Slow Queries
            </div>
            <div class="flex flex-1 flex-col overflow-y-auto">
                <nav class="flex-1 space-y-1 px-2 py-4">
                    <a href="{{ route('slow-queries.dashboard.show') }}"
                       class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fa-solid fa-chart-line fa-fw"></i>&nbsp;&nbsp;
                        Dashboard
                    </a>
                    <a href="{{ route('slow-queries.slow-queries.index') }}"
                       class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fa-regular fa-clock fa-fw"></i>&nbsp;&nbsp;
                        Slow Queries
                    </a>
                    <a href="{{ route('slow-queries.slow-pages.index') }}"
                       class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fa-solid fa-file fa-fw"></i>&nbsp;&nbsp;
                        Slow Pages
                    </a>
                    {{--                        <a href="{{ route('slow-queries.slow-pages.index') }}" class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">--}}
                    {{--                            <i class="fa-solid fa-circle-plus fa-fw"></i>&nbsp;&nbsp;--}}
                    {{--                            N+1 Queries--}}
                    {{--                        </a>--}}

                </nav>

                <div class="flex mb-10 center ml-10 mr-10 pl-10 pr-10">
                    <a href="http://www.libaro.be" target="_blank">
                        <img class="" src="https://libaro.be/storage/images/libaro_logo_full_white_without_tagline.svg"
                             alt="Libaro Logo">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col md:pl-64">
        <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-white shadow">
            <div class="flex flex-1 justify-between px-4 sm:px-6 md:px-8">
                <div class="flex flex-1 pl-5 pr-8 justify-between items-center text-gray-400 text-2xl capitalize">
                    <div class="pagetitle">
                        @yield('pagetitle')
                    </div>

                    <div class="flex items-center justify-between gap-x-12">
                        @include('slow-queries::components.time-range-picker')

                        <div class="backbutton">@yield('backbutton')</div>
                    </div>
                </div>
            </div>
        </div>

        <main class="flex-1">
            <div class="py-6">
                <div class="mx-auto fmax-w-7xl px-4 sm:px-6 md:px-8 mb-24">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</div>

@stack('custom_js')

</body>
</html>
