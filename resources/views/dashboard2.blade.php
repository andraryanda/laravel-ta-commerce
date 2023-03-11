{{-- <x-app-layout> --}}
<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total clients
                    </p>
                    <p class="counter text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-target="{{ $users_count }}">
                        {{-- {{ $users_count ?? '0' }} --}}
                        0
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Account balance
                    </p>
                    <p class="count-up text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-value="{{ $total_amount_success }}" data-is-price="true">
                        {{-- $ {{ $total_amount_success }}{{ __('.00') }} --}}
                        0
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div
                    class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-100 dark:bg-yellow-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Account Pending
                    </p>
                    <p class="count-up text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-value="{{ $total_amount_pending }}" data-is-price="true">
                        {{-- $ {{ $total_amount_pending }}{{ __('.00') }} --}}
                        0
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        New Transaction
                    </p>
                    <p class="counter text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-target="{{ $new_transaction }}">
                        0
                        {{-- {{ $new_transaction }} --}}
                    </p>
                </div>
            </div>
        </div>

        <x-slot name="styles">

        </x-slot>

        <x-slot name="script">

            <script>
                $(document).ready(function() {
                    // Setup - add a text input to each footer cell
                    $('#crudTable tfoot th:not(:last-child)').each(function() {
                        var title = $(this).text();
                        $(this).html(
                            '<input type="text" class="text-xs rounded-full font-semibold tracking-wide text-left " placeholder="Search ..." ' +
                            title + '" />');
                    });

                    // DataTable
                    var table = $('#crudTable').DataTable({
                        initComplete: function() {
                            // Apply the search
                            this.api()
                                .columns(':not(:last-child)')
                                .every(function() {
                                    var that = this;

                                    $('input', this.footer()).on('keyup change clear', function() {
                                        if (that.search() !== this.value) {
                                            that.search(this.value).draw();
                                        }
                                    });
                                });
                        },
                        // responsive: true,
                        // searching: true,
                        // ordering: true,
                        processing: true,
                        // serverSide: true,
                        ajax: {
                            url: '{!! url()->current() !!}',
                        },
                        columns: [{
                                data: 'id',
                                name: 'id',
                                width: '5%',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'user.name',
                                name: 'user.name',

                            },
                            {
                                data: 'total_price',
                                name: 'total_price',
                                className: 'dt-body-start',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp '),
                            },
                            {
                                data: 'status',
                                name: 'status',
                                className: 'dt-body-start',

                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false,
                                width: '25%',
                            },
                        ],
                        pagingType: 'full_numbers',
                        order: [
                            [0, 'desc'] // Kolom indeks 0 diurutkan secara descending
                        ],
                        language: {
                            searchPlaceholder: "Search Data Transaction",
                            decimal: ',',
                            thousands: '.',
                            paginate: {
                                first: "First",
                                last: "Last",
                                next: "Next",
                                previous: "Prev",
                            },
                        }
                    });
                });
            </script>

            {{-- count Rupiah --}}
            <script>
                function animateValue(el, start = 0, end = 0, is_price = false, duration = 800) {
                    let startTimestamp = null;
                    const step = (timestamp) => {
                        if (!startTimestamp) startTimestamp = timestamp;

                        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                        el.innerHTML = is_price ?
                            prettyPrice(Math.floor(progress * (end - start) + start)) :
                            prettyNum(Math.floor(progress * (end - start) + start))

                        // if not at end, continue
                        // if at end, return final number WITHOUT math operation to preserve decimals
                        if (progress < 1) window.requestAnimationFrame(step);
                        else el.innerHTML = is_price ?
                            this.prettyPrice(end) :
                            this.prettyNum(end)
                    };
                    window.requestAnimationFrame(step);
                }

                function prettyNum(value = 0) {
                    return value.toLocaleString('id-ID');
                    //   return value.toLocaleString('en-US');
                }

                function prettyPrice(value = 0) {
                    if (typeof value === 'string' && value.includes('Rp')) {
                        value = this.numericCurrency(value);
                    }

                    // if 0, manually convert to currency. otherwise !Number is falsy and returns unformatted 0
                    if (value == 0) return 'Rp0';

                    // preserve string and exit, no need for currency conversion
                    if (!Number(value)) return value;

                    return Number(value).toLocaleString('id-ID', {
                        //   return Number(value).toLocaleString('en-US', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }

                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelectorAll('.count-up').forEach(el => {
                        animateValue(el, 0, el.dataset.value, el.dataset.isPrice);
                    })
                })
            </script>
            {{-- count Biasa --}}
            <script>
                const counters = document.querySelectorAll('.counter');
                const speed = 200;

                counters.forEach(counter => {
                    const animate = () => {
                        const target = +counter.getAttribute('data-target');
                        const count = +counter.innerText.replace(/,/g, '');
                        const increment = Math.ceil(target / speed);
                        if (count < target) {
                            counter.innerText = (count + increment).toLocaleString('id-ID');
                            setTimeout(animate, 1);
                        } else {
                            counter.innerText = target.toLocaleString('id-ID');
                        }
                    }
                    animate();
                });
            </script>

        {{-- Chart --}}
        {!! $usersChart->script() !!}
        {!! $transactionChart->script() !!}
        {!! $userRegistrationChart->script() !!}

        </x-slot>
        {{-- <style>
            /* Style untuk tbody */
            #crudTable tbody {
                /* background-color: #a43f3f; warna latar belakang */
                /* font-size: 19px; ukuran font */
                /* font-weight: bold; ketebalan font */
                /* color: #333; warna font */
            }
            #crudTable tbody tr {
                background-color: #9b8686; /* warna latar belakang */
                font-size: 19px; /* ukuran font */
                font-weight: bold; /* ketebalan font */
                color: #333; /* warna font */
            }
        </style> --}}

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="px-3 py-3 overflow-x-auto bg-white sm:p-6">
                <div class="mb-10 mt-3">
                    <a href="{{ route('dashboard.transaction.exportAllTransactions') }}" title="Export All Transactions"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold mx-2 py-2 px-4 rounded shadow-lg">
                        <i class="fa fa-file"></i> Export All Transactions
                    </a>
                </div>
                <table id="crudTable" class="w-full row-border whitespace-no-wrap mt-2 pt-2">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-700 uppercase border-b">
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    </tbody>
                    <tfoot>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-600 uppercase border-b dark:border-gray-800 bg-gray-50 dark:text-gray-800 dark:bg-gray-400">
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <br>

        <!-- Charts -->
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Charts
        </h2>
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Users
                </h4>
                {{-- {!! $usersChart->container() !!} --}}
                {!! $userRegistrationChart->container() !!}
            </div>
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Transactions
                </h4>
                {!! $transactionChart->container() !!}
            </div>
        </div>
        {{-- {!! $usersChart->container() !!} --}}
        {{-- <div style="width: 50%">
        </div>

        <div style="width: 50%">
        </div> --}}
    </x-slot>
</x-layout.apps>
