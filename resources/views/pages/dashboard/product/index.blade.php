<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Produk') }}
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
                        responsive: false,
                        // searching: true,
                        // ordering: true,
                        processing: true,
                        serverSide: true,
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
                            // {
                            //     data: 'id',
                            //     name: 'id',
                            //     width: '12%',
                            //     className: 'dt-body-start',
                            // },
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
                            },
                            {
                                data: 'status_product',
                                name: 'status_product',
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
                        //     [1, 'desc'], // Kolom indeks 1 diurutkan secara descending
                        //     // [0, 'asc'] // Kolom indeks 0 (DT_RowIndex) diurutkan secara ascending
                        // ],
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
                            <p>Create Produk</p>
                        </div>
                    </button>
                    <!-- Modal toggle -->
                    {{-- <button data-modal-target="defaultModal" data-modal-toggle="defaultModal"
                        class="text-gray-900 shadow-sm bg-white hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-yellow-600 dark:bg-gray-800 dark:border-yellow-700 dark:text-white dark:hover:bg-yellow-700 mr-2 mb-2"
                        type="button" title="Import">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/upload.png') }}" alt="Upload" width="25" class="mr-2">
                            <p>Import Product Gallery</p>
                        </div>
                    </button> --}}
                </div>
                <div class="flex justify-start space-x-2 my-3 mx-3">
                    <button type="button" onclick="window.location.href='{{ route('dashboard.report.exportProducts') }}'"
                        title="Export"
                        class="text-gray-900 shadow-sm bg-white hover:bg-blue-100 border border-blue-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export Produk</p>
                        </div>
                    </button>
                </div>

                <!-- Main modal -->
                <div id="defaultModal" tabindex="-1" aria-hidden="true"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                    <div class="relative w-full h-full max-w-2xl md:h-auto">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Import Produk Gambar
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="defaultModal">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-6 space-y-6">
                                <form action="{{ route('dashboard.gallery.importProductGallery') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        for="file_input">Upload file</label>
                                    <input
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                        id="file_input" name="file" type="file" required>
                            </div>
                            <!-- Modal footer -->
                            <div
                                class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600 justify-end">
                                <button
                                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                    Accept
                                </button>
                                </form>
                                <button data-modal-hide="defaultModal" type="button"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="crudTable" class="w-full row-border whitespace-no-wrap mt-2 pt-2">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th>No</th>
                            {{-- <th>ID</th> --}}
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga Produk</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    </tbody>
                    <tfoot
                        class="text-xs font-semibold tracking-wide text-left text-gray-600 uppercase border-b dark:border-gray-800 bg-gray-50 dark:text-gray-800 dark:bg-gray-400">
                        <th class="no-search"></th>
                        {{-- <th>ID</th> --}}
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>
        <br>

        @push('javascript')
            <script>
                $('body').on('click', '.gallery-button', function() {
                    var gallery_id = $(this).data('id');
                    var url = "/dashboard/product/" + gallery_id +
                        "/gallery"; // Replace with the actual URL for dashboard.product.gallery.index
                    $.ajax({
                        url: url,
                        cache: false,
                        type: "GET",
                        success: function(response) {
                            window.location.href = url + '?_=' + new Date().getTime();
                        },
                        error: function() {
                            console.log('Error: Failed to open edit page.');
                        }
                    });
                });
            </script>

            <script>
                $('body').on('click', '.edit-button', function() {
                    var product_id = $(this).data('id');
                    $.ajax({
                        url: "{{ route('dashboard.product.edit', ['product' => ':id']) }}".replace(':id',
                            product_id),
                        cache: false,
                        type: "GET",
                        success: function(response) {
                            window.location.href =
                                "{{ route('dashboard.product.edit', ['product' => ':id']) }}".replace(':id',
                                    product_id) + '?_=' + new Date().getTime();
                        },
                        error: function() {
                            console.log('Error: Failed to open edit page.');
                        }
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    $('body').on('click', '.delete-button', function() {
                        var product_id = $(this).data("id");
                        Swal.fire({
                            title: 'Apakah anda yakin ingin menghapus Produk ini?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Hapus',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "DELETE",
                                    url: "{{ route('dashboard.product.destroy', ':id') }}"
                                        .replace(
                                            ':id', product_id),
                                    data: {
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    error: function(data) {
                                        console.log('Error:', data);
                                    }
                                });
                                setTimeout(function() {
                                        location.reload();
                                    },
                                    1000
                                ); // memberikan jeda selama 1000 milidetik atau 1 detik sebelum reload
                                let timerInterval;
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Your data has been deleted.',
                                    icon: 'success',
                                    timer: 1500,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        timerInterval = setInterval(() => {}, 100);
                                    },
                                    willClose: () => {
                                        clearInterval(timerInterval);
                                        location.reload();
                                    }
                                }).then((result) => {
                                    if (result.dismiss === Swal.DismissReason.timer) {
                                        console.log('I was closed by the timer');
                                    }
                                });
                            }
                        });
                    });
                });
            </script>
        @endpush
    @endsection
</x-layout.apps>
