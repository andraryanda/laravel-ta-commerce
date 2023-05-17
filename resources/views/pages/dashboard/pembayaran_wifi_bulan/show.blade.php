<x-layout.apps>
    <x-slot name="header">
        <button onclick="goBack()"
            class="w-24 my-6 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
            <div class="flex items-center">
                <img src="{{ asset('icon/left.png') }}" class="mr-2 bg-white rounded-full" alt="Back" width="25">
                <p class="inline-block">Back</p>
            </div>
        </button>

        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Transaction &raquo; #{{ $transaction->id }} {{ $transaction->name }}
        </h2>
    </x-slot>


    @section('transaction')
        <x-slot name="script">
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
            <script>
                $(document).ready(function() {
                    // Setup - add a text input to each footer cell
                    $('#crudTable tfoot th:not(.no-search)').each(function() {
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
                                .columns('')
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
                        serverSide: false,
                        responsive: false,
                        ajax: {
                            url: '{!! url()->current() !!}',
                        },
                        columns: [{
                                data: 'id',
                                name: 'id',
                                width: '5%'
                            },
                            {
                                data: 'product.name',
                                name: 'product.name'
                            },
                            {
                                data: 'wifis.total_price_wifi',
                                name: 'wifis.total_price_wifi',
                                searchable: true,
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp '),
                            },
                            {
                                data: 'payment_transaction',
                                name: 'payment_transaction',
                                searchable: true,
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp '),
                            },
                            {
                                data: 'payment_status',
                                name: 'payment_status'
                            },
                            {
                                data: 'payment_method',
                                name: 'payment_method'
                            },
                            {
                                data: 'description',
                                name: 'description'
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                title: 'Tanggal Transaksi',
                                searchable: true,
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
                        ],
                        pagingType: 'full_numbers',
                        // order: [
                        //     // [1, 'desc'], // Kolom indeks 1 diurutkan secara descending
                        //     // [0, 'asc'] // Kolom indeks 0 (DT_RowIndex) diurutkan secara ascending
                        // ],
                        language: {
                            searchPlaceholder: "Search Data Transaction Wifi",
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
        </x-slot>

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


        <div class="py-2">
            {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
            <h2 class="font-semibold text-lg text-gray-800 leading-tight mb-5">Transaction Details</h2>
            <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-10">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-auto w-full">
                        <tbody>
                            <tr>
                                <th class="border px-6 py-4 text-right">Nama</th>
                                <td class="border px-6 py-4">
                                    <div class="flex items-center text-sm">
                                        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                            <img class="object-cover w-full h-full rounded-full"
                                                src="{{ $transaction->user->profile_photo_url }}"
                                                alt="{{ $transaction->user->name }}" loading="lazy" />
                                        </div>
                                        <div>
                                            <p class="font-semibold">{{ $transaction->user->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                                @ {{ $transaction->user->username }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Email</th>
                                <td class="border px-6 py-4">{{ $transaction->user->email }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Alamat</th>
                                <td
                                    class="border px-6 py-4 {{ strlen($transaction->items->address) > 20 ? 'truncate' : '' }}">
                                    {{ $transaction->items->address }}
                                </td>
                            </tr>
                            {{-- <tr>
                                <th class="border px-6 py-4 text-right">Metode Pembayaran</th>
                                <td class="border px-6 py-4">{{ $transaction->payment }}</td>
                            </tr> --}}
                            <tr>
                                <th class="border px-6 py-4 text-right">Total Pembayaran Wifi Perbulan</th>
                                <td class="border px-6 py-4">{{ 'Rp ' . number_format($transaction->total_price_wifi) }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Tanggal Expired Wifi</th>
                                <td class="border px-6 py-4">
                                    {{ \Carbon\Carbon::parse($transaction->created_at)->timezone('Asia/Jakarta')->locale('id_ID')->isoFormat('dddd, D MMMM Y HH:mm:ss') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Tanggal Transaksi</th>
                                <td class="border px-6 py-4">
                                    {{ \Carbon\Carbon::parse($transaction->created_at)->timezone('Asia/Jakarta')->locale('id_ID')->isoFormat('dddd, D MMMM Y HH:mm:ss') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-4 text-right">Status Wifi</th>
                                <td
                                    class="border px-6 py-4 @if ($transaction->status == 'ACTIVE') bg-green-200 @elseif($transaction->status == 'INACTIVE') bg-red-200 @endif">
                                    {{ $transaction->status }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- </div> --}}
        </div>



        <h2 class="font-semibold text-lg text-gray-800 leading-tight mb-5">Transaction Items</h2>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="px-3 py-3 overflow-x-auto bg-white sm:p-6">
                <table id="crudTable" class="w-full row-border whitespace-no-wrap mt-2 pt-2">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-700 uppercase border-b">
                            <th>ID</th>
                            <th>Nama Produk</th>
                            <th>Harga Wifi Perbulan</th>
                            <th>Total Pembayaran</th>
                            <th>Status Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Description</th>
                            <th>Tanggal Transaksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    </tbody>
                    <tfoot>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-600 uppercase border-b dark:border-gray-800 bg-gray-50 dark:text-gray-800 dark:bg-gray-400">
                            <th>ID</th>
                            <th>Nama Produk</th>
                            <th>Harga Wifi Perbulan</th>
                            <th>Total Pembayaran</th>
                            <th>Status Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Description</th>
                            <th>Tanggal Transaksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endsection


</x-layout.apps>
