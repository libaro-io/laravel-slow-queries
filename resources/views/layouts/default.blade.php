<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Libaro ~ Laravel Slow Queries</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/e9e218acb7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div>
        <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex min-h-0 flex-1 flex-col bg-gray-800">
                <div class="flex h-16 flex-shrink-0 items-center bg-gray-900 text-white px-4">
                    Libaro ~ Slow Queries
                </div>
                <div class="flex flex-1 flex-col overflow-y-auto">
                    <nav class="flex-1 space-y-1 px-2 py-4">
                        <a href="{{ route('slow-queries.dashboard.show') }}" class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fa-solid fa-chart-line fa-fw"></i>&nbsp;&nbsp;
                            Dashboard
                        </a>
{{--                        <a href="{{ route('slow-queries.slowqueries.index') }}" class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">--}}
{{--                            <svg class="text-gray-300 mr-3 flex-shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />--}}
{{--                            </svg>--}}
{{--                            Slow Queries--}}
{{--                        </a>--}}
                        <a href="{{ route('slow-queries.slow-pages.index') }}" class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fa-solid fa-file fa-fw"></i>&nbsp;&nbsp;
                            Slow Pages
                        </a>
                        <a href="{{ route('slow-queries.slow-pages.index') }}" class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fa-solid fa-circle-plus fa-fw"></i>&nbsp;&nbsp;

                            N+1 Queries
                        </a>

                        <a href="{{ route('slow-queries.slow-queries.index') }}" class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fa-regular fa-clock fa-fw"></i>&nbsp;&nbsp;


                            Slow Queries
                        </a>
                        <a href="{{ route('slow-queries.allqueries.index') }}" class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fa-solid fa-clock fa-fw"></i>&nbsp;&nbsp;


                            All Queries
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="flex flex-col md:pl-64">
{{--            <div class="sticky top-0 z-10 flex h-16 flex-shrink-0 bg-white shadow">--}}
{{--                <div class="flex flex-1 justify-between px-4">--}}
{{--                    <div class="flex flex-1">--}}
{{--                        <form class="flex w-full md:ml-0" action="#" method="GET">--}}
{{--                            <label for="search-field" class="sr-only">Search</label>--}}
{{--                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">--}}
{{--                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center">--}}
{{--                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
{{--                                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                                <input id="search-field" class="block h-full w-full border-transparent py-2 pl-8 pr-3 text-gray-900 placeholder-gray-500 focus:border-transparent focus:placeholder-gray-400 focus:outline-none focus:ring-0 sm:text-sm" placeholder="Search" type="search" name="search">--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <main class="flex-1">
                <div class="py-6">
                    <div class="mx-auto fmax-w-7xl px-4 sm:px-6 md:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
