<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Pembayaran Perbulan Wifi') }}
        </h2>
    </x-slot>

    @push('javascript')
    @endpush


    @section('pembayaran_bulan_wifi')
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
                        serverSide: false,
                        responsive: false,
                        ajax: {
                            url: '{!! url()->current() !!}',
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                width: '5%',
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
                                className: 'dt-body-start',
                            },
                            {
                                data: 'user.name',
                                name: 'user.name',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'wifi_items.0.product.name',
                                name: 'wifi_items.product.name',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'total_price_wifi',
                                name: 'total_price_wifi',
                                className: 'dt-body-start',
                                render: $.fn.dataTable.render.number(',', '.', 2, 'Rp '),
                            },
                            {
                                data: 'expired_wifi',
                                name: 'expired_wifi',
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
                                data: 'status',
                                name: 'status',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'action',
                                name: 'action',
                                className: 'dt-body-start',
                                orderable: false,
                                searchable: false,
                                width: '25%',
                            }

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
        @endpush

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class=" overflow-x-auto bg-white ">
                <div class="flex justify-start space-x-2 my-3 mx-3">
                </div>
                <table id="crudTable" class="w-full row-border whitespace-no-wrap my-2 py-2">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Customer</th>
                            <th>Nama Produk</th>
                            <th>Total Harga Wifi</th>
                            <th>Expired Tanggal Wifi</th>
                            <th>Status Wifi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    </tbody>
                    <tfoot
                        class="text-xs font-semibold tracking-wide text-left text-gray-600 uppercase border-b dark:border-gray-800 bg-gray-50 dark:text-gray-800 dark:bg-gray-400">
                        <th class="no-search"></th>
                        <th>ID</th>
                        <th>Nama Customer</th>
                        <th>Nama Produk</th>
                        <th>Total Harga Wifi</th>
                        <th>Expired Tanggal Wifi</th>
                        <th>Status Wifi</th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>
    @endsection
</x-layout.apps>
