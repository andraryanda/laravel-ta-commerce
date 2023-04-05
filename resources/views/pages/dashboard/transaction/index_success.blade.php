<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Transaction Success') }}
        </h2>
    </x-slot>

    {{-- <x-slot name="slot">
    </x-slot> --}}

    @section('transaction')
        <x-slot name="styles">
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
        </x-slot>

        <x-slot name="script">
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
                                    $(element).css('width', '8%'); // Set width for id column
                                } else if (index == 2) {
                                    $(element).css('width', '9.5%'); // Set width for id column
                                } else if (index == 3) {
                                    $(element).css('width', '14%'); // Set width for id column
                                } else if (index == 4) {
                                    $(element).css('width', '10%'); // Set width for id column
                                } else if (index == 5) {
                                    $(element).css('width', '10%'); // Set width for id column
                                } else {
                                    $(element).css('width', 'auto'); // Set width for other columns
                                }
                            });
                        },
                        processing: true,
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
                                className: ' dt-body-start',
                            },
                            {
                                data: 'user.name',
                                name: 'user.name',
                                title: 'Nama',
                                className: 'dt-body-start',

                            },
                            {
                                data: 'total_price',
                                name: 'total_price',
                                title: 'Total Pembayaran',
                                className: 'dt-body-start',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp '),
                            },
                            {
                                data: 'status',
                                name: 'status',
                                title: 'Status',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'payment',
                                name: 'payment',
                                title: 'Status',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                title: 'Tanggal Transaksi',
                                className: 'dt-body-start',
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
                        order: [
                            // [1, 'desc'], // Kolom indeks 1 diurutkan secara descending
                            // [0, 'asc'] // Kolom indeks 0 (DT_RowIndex) diurutkan secara ascending
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
                    if (typeof value === 'string' && value.includes('Rp')) {
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
        </x-slot>

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
                        Account Balance
                    </p>
                    <p class="count-up text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-value="{{ $total_amount_success }}" data-is-price="true">
                        0
                    </p>
                </div>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class=" overflow-x-auto bg-white ">
                <div class="mb-5 mt-3 flex justify-start space-x-2 my-3 mx-3 py-2">
                    <button type="button"
                        onclick="window.location.href='{{ route('dashboard.transaction.exportTransactionSuccess') }}'"
                        title="Export All Transactions"
                        class="text-gray-900 shadow-sm bg-white hover:bg-blue-100 border border-blue-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export Transaction Success</p>
                        </div>
                    </button>
                </div>
                <table id="crudTable" class="w-full row-border whitespace-no-wrap mt-2 pt-2">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-700 uppercase border-b">
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                            <th>Metode Pembayaran</th>
                            <th>Tanggal Transaksi</th>
                            <th>Aksi</th>
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
                            <th>Total Pembayaran</th>
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
