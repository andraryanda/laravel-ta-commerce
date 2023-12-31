<!DOCTYPE html>
<html x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{-- :class="{ 'theme-dark': dark }" --}}

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('AL-N3T Support Gesitnet') }}</title>
    {{-- <title>{{ __('Als Store RT/RW NET') }}</title> --}}

    <link rel="shortcut icon" href="{{ asset('logo/alnet.jpg') }}">
    <link href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet"
        href="{{ url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200') }}" />
    <link rel="stylesheet"
        href="{{ url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="{{ url('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ url('https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css') }}"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css') }}"> --}}



    <style>
        /*Form fields*/
        .dataTables_wrapper select,
        .dataTables_wrapper .dataTables_filter input {
            color: #4a5568;
            margin-right: 1rem;
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

        /*Add padding to show text*/
        .dataTables_length label {
            padding-left: 10px;
        }

        .dataTables_info {
            padding-left: 10px;
        }


        .dataTables_wrapper .dataTables_paginate {
            margin-bottom: 1rem;
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
            background: #4d6aed !important;
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

    <style>
        /* Untuk browser Chrome, Safari, dan Opera */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgb(163, 64, 234);
            border-radius: 20px;
            animation: pulse 1s ease infinite alternate;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.2);
            }
        }

        /* Untuk browser Firefox */
        ::-moz-scrollbar {
            width: 8px;
        }

        ::-moz-scrollbar-thumb {
            background-color: rgb(163, 64, 234);
            border-radius: 20px;
            animation: pulse 1s ease infinite alternate;
        }
    </style>

    @livewireStyles

    <link rel="stylesheet" href="{{ asset('css/loader.css') }}">



    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{ url('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ url('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js') }}"></script>
    <script src="{{ asset('assets/js/focus-trap.js') }}" defer></script>
    {{-- <script src="{{ url('https://cdn.jsdelivr.net/npm/sweetalert2@11') }}"></script> --}}
    <script src="{{ asset('assets/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('chartJS_4-3-0/package/dist/chart.umd.js') }}"></script>

    {{-- <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>



    {{-- @vite('resources/css/app.css') --}}
    {{-- <script src="{{ url('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/charts-lines.js') }}" defer></script> --}}
    {{-- <script src="{{ asset('assets/js/charts-pie.js') }}" defer></script> --}}
    {{-- <script type="text/javascript" src="{{ url('https://code.jquery.com/jquery-3.4.1.min.js') }}"></script> --}}
    <!-- You need focus-trap.js to make the modal accessible -->

    {{-- <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script> --}}

    {{-- <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js') }}"></script> --}}

</head>

<body>
    {{-- <div class="loader"></div> --}}
    {{ $styles ?? '' }}


    @include('sweetalert::alert')
    @stack('style')

    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        @include('component_dashboard.sidebar')
        <div class="flex flex-col flex-1 w-full">
            {{-- Header Dashboard --}}
            @include('component_dashboard.navbar')
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    {{ $header }}
                    {{-- Admin --}}
                    {{ $slot }}
                    @yield('dashboard')
                    @yield('user')
                    @yield('categoryProduct')
                    @yield('product')
                    @yield('transaction')
                    @yield('pembayaran_bulan_wifi')
                    @yield('report')
                    @yield('chart')
                    @yield('notification')
                    @yield('report')
                    @yield('profileUser')
                    @yield('bank')
                    {{-- Admin Penutup --}}
                    {{-- Customer --}}
                    @yield('transactionCustomer')
                    {{-- Customer penutup --}}
                </div>
            </main>
        </div>
    </div>

    @stack('modals')

    @stack('javascript')

    @livewireScripts

    {{ $script ?? '' }}

</body>

<script>
    let icon1 = document.getElementById("icon1");
    let menu1 = document.getElementById("menu1");

    const showMenu1 = (flag) => {
        if (flag) {
            // icon1.classList.toggle("rotate-180");
            menu1.classList.toggle("hidden");
        }
    };

    let icon2 = document.getElementById("icon2");
    let menu2 = document.getElementById("menu2");

    const showMenu2 = (flag) => {
        if (flag) {
            // icon2.classList.toggle("rotate-180");
            menu2.classList.toggle("hidden");
        }
    };

    let icon3 = document.getElementById("icon3");
    let menu3 = document.getElementById("menu3");

    const showMenu3 = (flag) => {
        if (flag) {
            // icon3.classList.toggle("rotate-180");
            menu3.classList.toggle("hidden");
        }
    };

    let icon4 = document.getElementById("icon4");
    let menu4 = document.getElementById("menu4");

    const showMenu4 = (flag) => {
        if (flag) {
            // icon4.classList.toggle("rotate-180");
            menu4.classList.toggle("hidden");
        }
    };

    let icon5 = document.getElementById("icon5");
    let menu5 = document.getElementById("menu5");

    const showMenu5 = (flag) => {
        if (flag) {
            // icon5.classList.toggle("rotate-180");
            menu5.classList.toggle("hidden");
        }
    };

    // Mobile
    let icon11 = document.getElementById("icon11");
    let menu11 = document.getElementById("menu11");

    const showMenu11 = (flag) => {
        if (flag) {
            icon11.classList.toggle("rotate-180");
            menu11.classList.toggle("hidden");
        }
    };

    let icon12 = document.getElementById("icon12");
    let menu12 = document.getElementById("menu12");

    const showMenu12 = (flag) => {
        if (flag) {
            icon12.classList.toggle("rotate-180");
            menu12.classList.toggle("hidden");
        }
    };

    let icon13 = document.getElementById("icon13");
    let menu13 = document.getElementById("menu13");

    const showMenu13 = (flag) => {
        if (flag) {
            icon13.classList.toggle("rotate-180");
            menu13.classList.toggle("hidden");
        }
    };

    let icon14 = document.getElementById("icon14");
    let menu14 = document.getElementById("menu14");

    const showMenu14 = (flag) => {
        if (flag) {
            icon14.classList.toggle("rotate-180");
            menu14.classList.toggle("hidden");
        }
    };

    let icon15 = document.getElementById("icon15");
    let menu15 = document.getElementById("menu15");

    const showMenu15 = (flag) => {
        if (flag) {
            icon15.classList.toggle("rotate-180");
            menu15.classList.toggle("hidden");
        }
    };


    let Main = document.getElementById("Main");
    let open = document.getElementById("open");
    let close = document.getElementById("close");

    const showNav = (flag) => {
        if (flag) {
            Main.classList.toggle("-translate-x-full");
            Main.classList.toggle("translate-x-0");
            open.classList.toggle("hidden");
            close.classList.toggle("hidden");
        }
    };

    document.addEventListener("click", function(event) {
        // Website
        if (!event.target.closest("#menu1") && !event.target.closest("#icon1")) {
            showMenu1(false);
        }
        if (!event.target.closest("#menu2") && !event.target.closest("#icon2")) {
            showMenu2(false);
        }
        if (!event.target.closest("#menu3") && !event.target.closest("#icon3")) {
            showMenu3(false);
        }
        if (!event.target.closest("#menu4") && !event.target.closest("#icon4")) {
            showMenu4(false);
        }
        if (!event.target.closest("#menu5") && !event.target.closest("#icon5")) {
            showMenu5(false);
        }
        // Mobile
        if (!event.target.closest("#menu11") && !event.target.closest("#icon11")) {
            showMenu11(false);
        }
        if (!event.target.closest("#menu12") && !event.target.closest("#icon12")) {
            showMenu12(false);
        }
        if (!event.target.closest("#menu13") && !event.target.closest("#icon13")) {
            showMenu13(false);
        }
        if (!event.target.closest("#menu14") && !event.target.closest("#icon14")) {
            showMenu14(false);
        }
        if (!event.target.closest("#menu15") && !event.target.closest("#icon15")) {
            showMenu15(false);
        }
        // Uncomment the following code if you have other menus to close
        /*
        if (!event.target.closest("#menu3") && !event.target.closest("#icon3")) {
        showMenu3(false);
        }
        */
    });
</script>



</html>
