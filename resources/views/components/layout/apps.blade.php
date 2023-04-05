<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Store') }}</title>
    {{-- <title>{{ __('Als Store RT/RW NET') }}</title> --}}
    <link rel="shortcut icon" href="{{ asset('icon/store.png') }}">

    <link href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css') }}" rel="stylesheet" />
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js') }}"></script>

    <link rel="stylesheet"
        href="{{ url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200') }}" />
    {{-- <script src="https://kit.fontawesome.com/fe6aa2d4ea.js" crossorigin="anonymous"></script> --}}

    <link rel="stylesheet"
        href="{{ url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}">

    <script src="{{ url('https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js') }}"></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css') }}">

    <script src="{{ asset('assets/js/charts-lines.js') }}" defer></script>
    <script src="{{ asset('assets/js/charts-pie.js') }}" defer></script>

    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js') }}"></script>

    <link href="{{ url('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ url('https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css') }}"
        rel="stylesheet">
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

    {{-- @vite('resources/css/app.css') --}}

    {{-- <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script> --}}

    {{-- <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js') }}"></script> --}}

    <script src="{{ mix('js/app.js') }}" defer></script>


    <!-- Scripts -->

    <script src="{{ url('https://cdn.jsdelivr.net/npm/sweetalert2@11') }}"></script>
    {{-- <script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="{{ url('https://code.jquery.com/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('https://code.jquery.com/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ url('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js') }}"></script>
    <!-- You need focus-trap.js to make the modal accessible -->
    <script src="{{ asset('assets/js/focus-trap.js') }}" defer></script>



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
                    {{ $slot }}
                    @yield('dashboard')
                    @yield('user')
                    @yield('categoryProduct')
                    @yield('product')
                    @yield('transaction')
                    @yield('report')
                    @yield('chart')
                    @yield('notification')
                    @yield('report')
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
            icon1.classList.toggle("rotate-180");
            menu1.classList.toggle("hidden");
        }
    };

    let icon2 = document.getElementById("icon2");
    let menu2 = document.getElementById("menu2");

    const showMenu2 = (flag) => {
        if (flag) {
            icon2.classList.toggle("rotate-180");
            menu2.classList.toggle("hidden");
        }
    };

    let icon3 = document.getElementById("icon3");
    let menu3 = document.getElementById("menu3");

    const showMenu3 = (flag) => {
        if (flag) {
            icon3.classList.toggle("rotate-180");
            menu3.classList.toggle("hidden");
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
            showMenu2(false);
        }
        // Mobile
        if (!event.target.closest("#menu11") && !event.target.closest("#icon11")) {
            showMenu11(false);
        }
        if (!event.target.closest("#menu12") && !event.target.closest("#icon12")) {
            showMenu12(false);
        }

        // Uncomment the following code if you have other menus to close
        /*
              if (!event.target.closest("#menu3") && !event.target.closest("#icon3")) {
                  showMenu3(false);
              }
              */
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#master').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                $('.sub_chk').prop('checked', true)
            } else {
                $('.sub_chk').prop('checked', false)
            }
        });
        $('.delete_all').on('click', function(e) {
            var allVals = [];
            $('.sub_chk:checked').each(function() {
                allVals.push($(this).attr('data-id'));
            });
            if (allVals.length <= 0) {
                // alert("Please select row.");
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: '<b class="fs-4 alert alert-danger">Silahkan pilih data yang akan dihapus</b>'
                });
            } else {
                // var check = confirm("Are you sure you want to delete this row?");
                var check = Swal.fire({
                    title: 'Apakah File Data ingin di <b>Hapus</b> ?',
                    text: "Jika Tidak, Klik Cancel",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    // if (check == true) {
                    if (result['isConfirmed']) {
                        var join_selected_values = allVals.join(",");
                        $.ajax({
                            url: $(this).data('url'),
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            data: 'ids=' + join_selected_values,
                            success: function(data) {
                                console.log(data);
                                if (data['success']) {
                                    $(".sub_chk:checked").each(function() {
                                        $(this).parents("tr").remove();
                                    });
                                    // alert(data['success']);
                                    // Swal.fire('success','Delete data success!');
                                    // location.reload();
                                    Swal.fire(
                                            'Success!',
                                            'Delete Data Successfully!',
                                            'success'
                                        )
                                        .then((result) => {
                                            if (result['isConfirmed']) {
                                                let timerInterval
                                                Swal.fire({
                                                    title: 'Auto close alert!',
                                                    html: 'I will close in <b></b> milliseconds.',
                                                    timer: 500,
                                                    timerProgressBar: true,
                                                    didOpen: () => {
                                                        Swal.showLoading()
                                                        const b =
                                                            Swal
                                                            .getHtmlContainer()
                                                            .querySelector(
                                                                'b')
                                                        timerInterval
                                                            =
                                                            setInterval(
                                                                () => {
                                                                    b.textContent =
                                                                        Swal
                                                                        .getTimerLeft()
                                                                },
                                                                100)
                                                    },
                                                    willClose: () => {
                                                        clearInterval
                                                            (
                                                                timerInterval
                                                            )
                                                    }
                                                }).then((result) => {
                                                    if (
                                                        /* Read more about handling dismissals below */
                                                        result
                                                        .dismiss ===
                                                        Swal
                                                        .DismissReason
                                                        .timer
                                                    ) {
                                                        console.log(
                                                            'I was closed by the timer'
                                                        )
                                                        location
                                                            .reload();
                                                    }
                                                });
                                            }
                                        });
                                } else if (data['success']) {
                                    alert(data['error']);
                                } else {
                                    alert('Whoops Something went wrong!!');
                                }
                            },
                            error: function(data) {
                                alert(data.responseText);
                            }
                        });
                        $.each(allVals, function(index, value) {
                            $('table tr').filter("[data-row-id='" + value + "']")
                                .remove();
                        });
                    }
                });
            }
        });
        // });
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function(event, element) {
                element.trigger('confirm');
            }
        });
        $(document).on('confirm', function(e) {
            var ele = e.target;
            e.preventDefault();
            $.ajax({
                url: ele.href,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data['success']) {
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } else if (data['error']) {
                        alert(data['error']);
                    } else {
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function(data) {
                    alert(data.responseText);
                }
            });
            return false;
        });
    });
</script>


</html>
