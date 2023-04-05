<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Product') }}
        </h2>
    </x-slot>

    {{-- <x-slot name="slot">
    </x-slot> --}}

    @section('product')
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
                            '<input type="text" class="text-xs rounded-full font-semibold tracking-wide text-left w-full" style="text-align: left;" placeholder="Search ... ' +
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
                                width: '12%',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'name',
                                name: 'name',
                                className: 'dt-body-start',
                                // width: '%',

                            },
                            {
                                data: 'category.name',
                                name: 'category.name',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'price',
                                name: 'price',
                                className: 'dt-body-start',
                                render: function(data, type, row, meta) {
                                    return "Rp " + numberWithCommas(data);
                                },
                                // render: $.fn.dataTable.render.number('0', '0', 'Rp '),
                                // render: function(data, type, row) {
                                //     if (type === 'display') {
                                //         return 'Rp ' + parseFloat(data).toFixed(2).replace(
                                //             /(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                                //     }
                                //     return data;
                                // }
                                // render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                                // render: function(data, type, row) {
                                //     return 'Rp ' + parseFloat(data).toLocaleString('id-ID', {
                                //         minimumFractionDigits: 2
                                //     });
                                // }
                                // render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ', ',000.00'),
                                // render: function(data, type, full, meta) {
                                //     return 'Rp ' + parseFloat(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                                //         '$&,');
                                // },
                                // type: 'num-fmt',
                                // render: function(data, type, row, meta) {
                                //     return "Rp " + $.number(data, 0, ',', '.');
                                // },
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
                        order: [
                            [1, 'desc'], // Kolom indeks 1 diurutkan secara descending
                            // [0, 'asc'] // Kolom indeks 0 (DT_RowIndex) diurutkan secara ascending
                        ],
                        language: {
                            searchPlaceholder: "Search Data Products",
                            decimal: ',',
                            thousands: '.',
                            paginate: {
                                first: "First",
                                last: "Last",
                                next: "Next",
                                previous: "Prev",
                            },
                        },
                        drawCallback: function() {
                            // Remove arrow from first column header
                            $('#crudTable th:first-child .fa').remove();
                        }
                    });

                    function numberWithCommas(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                });
            </script>
        </x-slot>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="overflow-x-auto bg-white ">
                <div class="flex justify-start space-x-2 my-3 mx-3">
                    <button type="button" onclick="window.location.href='{{ route('dashboard.product.create') }}'"
                        title="Create"
                        class="text-gray-900 shadow-sm bg-white hover:bg-green-100 border border-green-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/create.png') }}" alt="Create" width="25" class="mr-2">
                            <p>Create Product</p>
                        </div>
                    </button>
                </div>
                <div class="flex justify-start space-x-2 my-3 mx-3">
                    <button type="button" onclick="window.location.href='{{ route('dashboard.product.exportProducts') }}'"
                        title="Export"
                        class="text-gray-900 shadow-sm bg-white hover:bg-blue-100 border border-blue-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export Product</p>
                        </div>
                    </button>
                </div>
                <table id="crudTable" class="w-full row-border whitespace-no-wrap mt-2 pt-2">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    </tbody>
                    <tfoot
                        class="text-xs font-semibold tracking-wide text-left text-gray-600 uppercase border-b dark:border-gray-800 bg-gray-50 dark:text-gray-800 dark:bg-gray-400">
                        <th class="no-search"></th>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>
        <br>
    @endsection
</x-layout.apps>
