<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('All Transaction') }}
        </h2>
    </x-slot>

    @section('transaction')
        @push('style')
            <style>
                #crudTable tbody tr:hover {
                    background-color: #f7fafc;
                    transition: all 0.3s ease-in-out;
                    /* background-color: rgba(0, 0, 0, 0.075); */
                }

                #crudTable:hover {
                    cursor: pointer;
                }

                #crudTable.hover:bg-gray-100 tbody tr:hover {
                    background-color: #edf2f7;
                }

                #crudTable tfoot input {
                    width: 100%;
                }
            </style>
        @endpush

        @push('javascript')
            <script>
                $(document).ready(function() {
                    // Setup - add a text input to each footer cell
                    $('#crudTable tfoot th:not(:last-child):not(.no-search)').each(function() {
                        var title = $(this).text();
                        $(this).html(
                            '<input type="text" class="text-xs rounded-full font-semibold tracking-wide text-left " style="text-align: left;" placeholder="Search ... ' +
                            title + '" />'
                        );
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
                            // Set width for search tfoot
                            $('tfoot tr').children().each(function(index, element) {
                                if (index == 0) {
                                    $(element).css('width', '2%'); // Set width for id column
                                } else if (index == 1) {
                                    $(element).css('width', '7%'); // Set width for id column
                                } else if (index == 2) {
                                    $(element).css('width', '7%'); // Set width for id column
                                } else if (index == 3) {
                                    $(element).css('width', '10%'); // Set width for id column
                                } else if (index == 4) {
                                    $(element).css('width', '8%'); // Set width for id column
                                } else if (index == 5) {
                                    $(element).css('width', '10%'); // Set width for id column
                                } else {
                                    $(element).css('width', 'auto'); // Set width for other columns
                                }
                            });
                        },
                        processing: true,
                        serverSide: true,
                        responsive: false,
                        ajax: {
                            url: '{!! url()->current() !!}',
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                className: 'dt-body-start',
                                orderable: false,
                                searchable: false,
                                ordering: false,
                                render: function(data, type, full, meta) {
                                    return meta.row + 1;
                                }
                            },
                            {
                                data: 'id',
                                name: 'id',
                                // width: '25%',
                                searchable: true,
                                className: ' dt-body-start',
                            },
                            {
                                data: 'user.name',
                                name: 'user.name',
                                title: 'Nama',
                                className: 'dt-body-start',
                                searchable: true,
                                type: 'text',
                                render: function(data, type, full, meta) {
                                    return '<div class="flex items-center"><div class="w-10 h-10 flex-shrink-0 mr-3">' +
                                        (full.user.profile_photo_url ?
                                            '<img class="object-cover rounded-full w-full h-full" src="' +
                                            full.user.profile_photo_url + '" alt="' + full.user.name +
                                            '">' :
                                            '<span class="inline-block w-full h-full rounded-full overflow-hidden bg-gray-100"><svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z"/></svg></span>'
                                        ) +
                                        '</div><div><p class="text-sm font-medium text-gray-900">' + full
                                        .user.name + '</p><p class="text-sm text-gray-500">@' + full.user
                                        .username + '</p></div></div>';
                                },
                            },
                            {
                                data: 'total_price',
                                name: 'total_price',
                                title: 'Total Pembayaran',
                                className: 'dt-body-start',
                                searchable: true,
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp '),
                            },
                            {
                                data: 'status',
                                name: 'status',
                                title: 'Status',
                                className: 'dt-body-start',
                                searchable: true,
                                render: function(data, type, row) {
                                    if (data == 'SUCCESS') {
                                        return '<span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">' +
                                            data + '</span>';
                                    } else if (data == 'PENDING') {
                                        return '<span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">' +
                                            data + '</span>';
                                    } else if (data == 'CANCELLED') {
                                        return '<span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">' +
                                            data + '</span>';
                                    } else {
                                        return '<span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">' +
                                            data + '</span>';
                                    }
                                }
                            },

                            {
                                data: 'payment',
                                name: 'payment',
                                className: 'dt-body-start',
                                searchable: true,
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                title: 'Tanggal Transaksi',
                                className: 'dt-body-start',
                                searchable: true,
                                render: function(data) {
                                    var date = new Date(data);
                                    return date.toLocaleString('id-ID', {
                                        day: 'numeric',
                                        month: 'long',
                                        year: 'numeric',
                                        hour: 'numeric',
                                        minute: 'numeric',
                                        second: 'numeric',
                                        weekday: 'long'
                                    });
                                }
                            },
                            {
                                data: 'action',
                                name: 'action',
                                title: 'Aksi',
                                orderable: false,
                                searchable: false,
                                width: '25%',
                            },
                        ],
                        pagingType: 'full_numbers',
                        // order: [
                        //     // [1, 'desc'], // Kolom indeks 1 diurutkan secara descending
                        //     // [0, 'asc'] // Kolom indeks 0 (DT_RowIndex) diurutkan secara ascending
                        // ],
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
                        },
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
                    if (typeof value === 'string' && value.includes('Rp ')) {
                        value = this.numericCurrency(value);
                    }

                    // if 0, manually convert to currency. otherwise !Number is falsy and returns unformatted 0
                    if (value == 0) return 'Rp 0';

                    // preserve string and exit, no need for currency conversion
                    if (!Number(value)) return value;

                    return 'Rp ' + Number(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
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
        @endpush

        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 hover:bg-blue-100 transition duration-300 ease-in-out">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Transaction
                    </p>
                    <p class="counter text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-target="{{ $new_transaction }}">
                        0
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 hover:bg-green-100 transition duration-300 ease-in-out">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Transaksi Success
                    </p>
                    <p class="count-up text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-value="{{ $total_amount_success }}" data-is-price="true">
                        0
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 hover:bg-yellow-100 transition duration-300 ease-in-out">
                <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-100 dark:bg-yellow-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Transaksi Pending
                    </p>
                    <p class="count-up text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-value="{{ $total_amount_pending }}" data-is-price="true">
                        0
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 hover:bg-red-100 transition duration-300 ease-in-out">
                <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Transaksi Cancelled
                    </p>
                    <p class="count-up text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-value="{{ $total_amount_cancelled }}" data-is-price="true">
                        0
                    </p>
                </div>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class=" overflow-x-auto bg-white ">
                <div class="mb-5 mt-3 flex justify-start space-x-2 my-3 mx-3 py-2">
                    <button type="button" onclick="window.location.href='{{ route('dashboard.transaction.create') }}'"
                        title="Create"
                        class="text-gray-900 shadow-sm bg-white hover:bg-green-100 border border-green-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/create.png') }}" alt="Create" width="25" class="mr-2">
                            <p>Create Transaction</p>
                        </div>
                    </button>

                    <button type="button"
                        onclick="window.location.href='{{ route('dashboard.report.exportAllTransactions') }}'"
                        title="Export All Transactions"
                        class="text-gray-900 shadow-sm bg-white hover:bg-blue-100 border border-blue-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export All Transactions</p>
                        </div>
                    </button>
                </div>
                <table id="crudTable" class="w-full table-auto row-border whitespace-no-wrap mt-2 pt-2">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-700 uppercase border-b">
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Metode Pembayaran</th>
                            <th>Tanggal Transaksi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    </tbody>
                    <tfoot>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-600 uppercase border-b dark:border-gray-800 bg-gray-50 dark:text-gray-800 dark:bg-gray-400">
                            <th class="no-search"></th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Metode Pembayaran</th>
                            <th>Tanggal Transaksi</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endsection
</x-layout.apps>
