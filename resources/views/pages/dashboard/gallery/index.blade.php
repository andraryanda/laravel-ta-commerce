<x-layout.apps>
    <x-slot name="header">
        <button onclick="window.location.href='{{ route('dashboard.product.index') }}'"
            class="w-24 my-6 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
            <div class="flex items-center">
                <img src="{{ asset('icon/left.png') }}" class="mr-2 bg-white rounded-full" alt="Back" width="25">
                <p class="inline-block">Back</p>
            </div>
        </button>

        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Product &raquo; {{ $product->name }} &raquo; Gallery
        </h2>
    </x-slot>

    <x-slot name="slot">
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
                            // Set width for search tfoot
                            $('tfoot tr').children().each(function(index, element) {
                                if (index == 0) {
                                    $(element).css('width', '5%'); // Set width for id column
                                } else if (index == 1) {
                                    $(element).css('width', '12%'); // Set width for id column
                                } else if (index == 2) {
                                    $(element).css('width', 'auto'); // Set width for id column
                                } else if (index == 3) {
                                    $(element).css('width', 'auto'); // Set width for id column
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
                                width: '5%',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'url',
                                name: 'url',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'is_featured',
                                name: 'is_featured',
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
                            searchPlaceholder: "Search Data Gallery",
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
                });
            </script>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
        </x-slot>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="overflow-x-auto bg-white">
                <div class="flex justify-start space-x-2 my-3 mx-3">
                    <button type="button"
                        onclick="window.location.href='{{ route('dashboard.product.gallery.create', encrypt($product->id)) }}'"
                        title="Create"
                        class="text-gray-900 shadow-sm bg-white hover:bg-green-100 border border-green-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/create.png') }}" alt="Create" width="25" class="mr-2">
                            <p>Upload Photos</p>
                        </div>
                    </button>
                </div>
                <table id="crudTable" class="w-full row-border whitespace-no-wrap mt-2 pt-2">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-2 py-4">No</th>
                            <th class="px-2 py-4">ID</th>
                            <th class="px-6 py-4">Photo</th>
                            <th class="px-6 py-4">Featured</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    </tbody>
                    <tfoot
                        class="text-xs font-semibold tracking-wide text-left text-gray-600 uppercase border-b dark:border-gray-800 bg-gray-50 dark:text-gray-800 dark:bg-gray-400">
                        <th class="no-search"></th>
                        <th>ID</th>
                        <th class="no-search"></th>
                        <th>Featured</th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>

        @push('javascript')
            <script>
                $('body').on('click', '.delete-button', function() {
                    var product_gallery_id = $(this).data("id");
                    Swal.fire({
                        title: 'Apakah anda yakin ingin menghapus gallery ini?',
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
                                url: "{{ route('dashboard.gallery.destroy', ':id') }}".replace(
                                    ':id', product_gallery_id),
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
            </script>
        @endpush

    </x-slot>

</x-layout.apps>
