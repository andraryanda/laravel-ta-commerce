<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Landing Page Home') }}
        </h2>
    </x-slot>

    {{-- <x-slot name="slot">
    </x-slot> --}}

    @section('dashboard')
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
                                    $(element).css('width', '2%'); // Set width for id column
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
                        // serverSide: true,
                        // responsive: true,
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
                                data: 'header_title_carousel',
                                name: 'header_title_carousel',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'title_carousel',
                                name: 'title_carousel',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'image_carousel',
                                name: 'image_carousel',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
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
                        language: {
                            searchPlaceholder: "Search Data Category",
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


        </x-slot>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="overflow-x-auto bg-white ">
                <div class="flex justify-start space-x-2 my-3 mx-3">
                    <!-- Modal toggle -->
                    <button data-modal-target="defaultModal" data-modal-toggle="defaultModal"
                        class="text-gray-900 shadow-sm bg-white hover:bg-green-100 border border-green-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-green-600 dark:bg-gray-800 dark:border-green-700 dark:text-white dark:hover:bg-green-700 mr-2 mb-2"
                        type="button" title="Create">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/create.png') }}" alt="Create" width="25" class="mr-2">
                            <p>Create Landing Page Home</p>
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
                                    Create Landing Page Home
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
                                <form action="{{ route('dashboard.carousel.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="flex flex-wrap -mx-3 mb-6">
                                        <div class="w-full px-3">
                                            <label
                                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                                for="header_title_carousel">
                                                Judul Atas Carousel
                                            </label>
                                            <input value="{{ old('header_title_carousel') }}" name="header_title_carousel"
                                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                id="header_title_carousel" type="text"
                                                placeholder="Header Title Carousel">
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3 mb-6">
                                        <div class="w-full px-3">
                                            <label
                                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                                for="title_carousel">
                                                Judul Carousel
                                            </label>
                                            <input value="{{ old('title_carousel') }}" name="title_carousel"
                                                class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                id="title_carousel" type="text" placeholder="Title Carousel">
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-3 mb-6">
                                        <div class="w-full px-3">
                                            <label
                                                class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                                for="image_carousel">
                                                Gambar Carousel
                                            </label>
                                            <input multiple accept="image/*" value="{{ old('image_carousel') }}"
                                                name="image_carousel"
                                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                id="file_input" type="file" required>

                                            <div class="my-3">
                                                <img id="image_element" class="rounded-lg" width="300"
                                                    style="display: none;">

                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <!-- Modal footer -->
                            <div
                                class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600 justify-end">
                                <button
                                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                    Simpan
                                </button>
                                </form>
                                <button data-modal-hide="defaultModal" type="button"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button>
                            </div>
                        </div>
                    </div>
                </div>

                @if (Session::get('success'))
                    <div id="success-message"
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 my-2.5 rounded relative"
                        role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ Session::get('success') }}</span>
                    </div>
                    <script>
                        $(document).ready(function() {
                            // Hide the success message after 5 seconds
                            setTimeout(function() {
                                $("#success-message").fadeOut("slow");
                            }, 10000);

                            // Hide the success message when the close button is clicked
                            function closeAlert() {
                                $("#success-message").fadeOut("slow");
                            }
                        });
                    </script>
                @endif

                @if ($errorMessage = Session::get('errorMessage'))
                    <div id="error-message"
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 my-2.5 rounded relative"
                        role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ $errorMessage }}</span>
                    </div>
                    <script>
                        $(document).ready(function() {
                            // Hide the error message after 5 seconds
                            setTimeout(function() {
                                $("#error-message").fadeOut("slow");
                            }, 10000);

                            // Hide the error message when the close button is clicked
                            function closeAlert() {
                                $("#error-message").fadeOut("slow");
                            }
                        });
                    </script>
                @endif

                <table id="crudTable" class="w-full row-border whitespace-no-wrap my-2 py-2">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th>No</th>
                            <th>Judul Atas Carousel</th>
                            <th>Judul Carousel</th>
                            <th>Gambar Carousel</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    </tbody>
                    <tfoot
                        class="text-xs font-semibold tracking-wide text-left text-gray-600 uppercase border-b dark:border-gray-800 bg-gray-50 dark:text-gray-800 dark:bg-gray-400">
                        <th class="no-search"></th>
                        <th>Judul Atas Carousel</th>
                        <th>Judul Carousel</th>
                        <th>Gambar</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>


        @push('javascript')
            <script>
                $('body').on('click', '.edit-button', function() {
                    var home_id = $(this).data('id');
                    $.ajax({
                        url: "{{ route('dashboard.category.edit', ['category' => ':id']) }}".replace(':id',
                            home_id),
                        cache: false,
                        type: "GET",
                        success: function(response) {
                            window.location.href =
                                "{{ route('dashboard.category.edit', ['category' => ':id']) }}".replace(':id',
                                    home_id) + '?_=' + new Date().getTime();
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
                        var home_id = $(this).data("id");
                        Swal.fire({
                            title: 'Apakah anda yakin ingin menghapus landing page home ini?',
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
                                    url: "{{ route('dashboard.carousel.destroy', ':id') }}"
                                        .replace(
                                            ':id', home_id),
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
