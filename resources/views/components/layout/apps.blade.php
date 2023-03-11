<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{ config('app.name', 'Als Store') }}</title> --}}
    <title>Als Store RT/RW NET</title>

    <link href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css') }}" rel="stylesheet" />
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js') }}"></script>


    <script src="https://kit.fontawesome.com/fe6aa2d4ea.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet"
        href="{{ url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}">
    <script src="{{ url('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js') }}"></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>
    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css') }}">
    <script src="{{ asset('assets/js/charts-lines.js') }}" defer></script>
    <script src="{{ asset('assets/js/charts-pie.js') }}" defer></script>
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js') }}"></script>

    <link href="{{ url('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ url('https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <style>
        /*Form fields*/
        .dataTables_wrapper select,
        .dataTables_wrapper .dataTables_filter input {
            color: #4a5568;
            /*text-gray-700*/
            padding-left: 1rem;
            /*pl-4*/
            padding-right: 1rem;
            /*pl-4*/
            padding-top: .5rem;
            /*pl-2*/
            padding-bottom: .5rem;
            /*pl-2*/
            line-height: 1.25;
            /*leading-tight*/
            border-width: 2px;
            /*border-2*/
            border-radius: .25rem;
            border-color: #edf2f7;
            /*border-gray-200*/
            background-color: #edf2f7;
            /*bg-gray-200*/
        }

        /*Row Hover*/
        table.dataTable.hover tbody tr:hover,
        table.dataTable.display tbody tr:hover {
            background-color: #ebf4ff;
            /*bg-indigo-100*/
        }

        /*Pagination Buttons*/
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            font-weight: 700;
            /*font-bold*/
            border-radius: .25rem;
            /*rounded*/
            border: 1px solid transparent;
            /*border border-transparent*/
        }

        /*Pagination Buttons - Current selected */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: #fff !important;
            /*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
            /*shadow*/
            font-weight: 700;
            /*font-bold*/
            border-radius: .25rem;
            /*rounded*/
            background: #667eea !important;
            /*bg-indigo-500*/
            border: 1px solid transparent;
            /*border border-transparent*/
        }

        /*Pagination Buttons - Hover */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #fff !important;
            /*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
            /*shadow*/
            font-weight: 700;
            /*font-bold*/
            border-radius: .25rem;
            /*rounded*/
            background: #667eea !important;
            /*bg-indigo-500*/
            border: 1px solid transparent;
            /*border border-transparent*/
        }

        /*Add padding to bottom border */
        table.dataTable.no-footer {
            border-bottom: 1px solid #e2e8f0;
            /*border-b-1 border-gray-300*/
            margin-top: 0.75em;
            margin-bottom: 0.75em;
        }

        /*Change colour of responsive icon*/
        table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
            background-color: #667eea !important;
            /*bg-indigo-500*/
        }
    </style>

    @livewireStyles

    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">


    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('https://code.jquery.com/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ url('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js') }}"></script>
<!-- You need focus-trap.js to make the modal accessible -->
    <script src="{{ asset('assets/js/focus-trap.js') }}" defer></script>
    {{ $styles ?? '' }}
    @yield('style')



</head>

<body>
    {{-- <div class="loader"></div> --}}


    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        @include('component_dashboard.sidebar')
        <div class="flex flex-col flex-1 w-full">
            {{-- Header Dashboard --}}
            @include('component_dashboard.navbar')
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    {{ $header }}
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    @stack('modals')

    @livewireScripts

    {{ $script ?? '' }}
    @yield('javascript')

</body>


</html>
