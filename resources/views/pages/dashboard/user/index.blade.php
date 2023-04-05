<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('All Users') }}
        </h2>
    </x-slot>

    {{-- <x-slot name="slot">
    </x-slot> --}}

    @section('user')
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
                            '<input type="text" class="text-xs rounded-full font-semibold tracking-wide text-left" style="text-align: left;" placeholder="Search ... ' +
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
                                    $(element).css('width', '8%'); // Set width for id column
                                } else if (index == 4) {
                                    $(element).css('width', '11%'); // Set width for id column
                                } else {
                                    $(element).css('width', 'auto'); // Set width for other columns
                                }
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
                                width: '15%',
                                className: 'dt-body-start',
                            },
                            {
                                data: 'name',
                                name: 'name',
                                className: 'dt-body-start',
                                width: '%',

                            },
                            {
                                data: 'email',
                                name: 'email',
                                className: 'dt-body-start',

                            },
                            {
                                data: 'roles',
                                name: 'roles',
                                className: 'dt-body-start',

                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
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
                                render: function(data, type, full, meta) {
                                    return '<div class="flex justify-start items-center space-x-3.5">\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="button" class="inline-flex btn-edit flex-col items-center justify-center w-20 h-12 bg-yellow-400 text-white rounded-md border border-yellow-500 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline" data-id="' +
                                        full.id +
                                        '">\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <img class="object-cover w-6 h-6 rounded-full" src="{{ asset('icon/edit.png') }}" alt="edit" loading="lazy" width="20" />\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <p class="mt-1 text-xs">Edit</p>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </button>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <button type="button" class="inline-flex btn-delete flex-col items-center justify-center w-20 h-12 bg-red-400 text-white rounded-md border border-red-500 transition duration-500 ease select-none hover:bg-red-500 focus:outline-none focus:shadow-outline" data-id="' +
                                        full.id +
                                        '">\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <img class="w-6 h-6 rounded-full object-cover mr-2" src="{{ asset('icon/delete.png') }}" alt="Delete" loading="lazy" width="20" />\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <span class="text-xs">Hapus</span>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </button>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>';
                                }
                            }
                        ],
                        pagingType: 'full_numbers',
                        order: [
                            [1, 'desc'], // Kolom indeks 1 diurutkan secara descending
                            // [0, 'asc'] // Kolom indeks 0 (DT_RowIndex) diurutkan secara ascending
                        ],
                        language: {
                            searchPlaceholder: "Search Data Users",
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

                    $('body').on('click', '.btn-edit', function() {
                        var user_id = $(this).data('id');
                        $.ajax({
                            url: "{{ route('dashboard.user.edit', ['user' => ':id']) }}".replace(':id',
                                user_id),
                            type: "GET",
                            success: function(response) {
                                window.location.href =
                                    "{{ route('dashboard.user.edit', ['user' => ':id']) }}".replace(
                                        ':id', user_id);
                            },
                            error: function() {
                                console.log('Error: Failed to open edit page.');
                            }
                        });
                    });

                    $('body').on('click', '.btn-delete', function() {
                        var user_id = $(this).data("id");
                        Swal.fire({
                            title: 'Apakah anda yakin ingin menghapus user ini?',
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
                                    url: "{{ route('dashboard.user.destroy', ':id') }}".replace(
                                        ':id', user_id),
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
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Keseluruhan User
                    </p>
                    <p class="counter text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-target="{{ $total_user }}">
                        0
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 hover:bg-yellow-100 transition duration-300 ease-in-out">
                <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-100 dark:bg-yellow-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Admin
                    </p>
                    <p class="counter text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-target="{{ $total_user_admin }}">
                        0
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div
                class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 hover:bg-green-100 transition duration-300 ease-in-out">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Total Customer
                    </p>
                    <p class="counter text-lg font-semibold text-gray-700 dark:text-gray-200"
                        data-target="{{ $total_user_customer }}">
                        0
                    </p>
                </div>
            </div>
        </div>

        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="overflow-x-auto bg-white">
                <div class="flex justify-start  space-x-2 my-3 mx-3">
                    <button type="button" onclick="window.location.href='{{ route('dashboard.user.create') }}'"
                        title="Create"
                        class="text-gray-900 shadow-sm bg-white hover:bg-green-100 border border-green-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/create.png') }}" alt="Create" width="25" class="mr-2">
                            <p>Create User</p>
                        </div>
                    </button>
                    <button type="button" @click="openModal" title="Import"
                        class="text-gray-900 shadow-sm bg-white hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-yellow-600 dark:bg-gray-800 dark:border-yellow-700 dark:text-white dark:hover:bg-yellow-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/upload.png') }}" alt="Upload" width="25" class="mr-2">
                            <p>Import Users</p>
                        </div>
                    </button>
                </div>
                <div class="flex justify-start space-x-2 my-3 mx-3">
                    <button type="button" onclick="window.location.href='{{ route('dashboard.user.export') }}'"
                        title="Export All Users"
                        class="text-gray-900 shadow-sm bg-white hover:bg-blue-100 border border-blue-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export All Users</p>
                        </div>
                    </button>
                </div>

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

                <!-- Modal backdrop. This what you want to place close to the closing body tag -->
                <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center">
                    <!-- Modal -->
                    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="closeModal"
                        @keydown.escape="closeModal"
                        class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
                        role="dialog" id="modal">
                        <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
                        <header class="flex justify-end">
                            <button
                                class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                                aria-label="close" @click="closeModal">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img"
                                    aria-hidden="true">
                                    <path
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                            </button>
                        </header>
                        <!-- Modal body -->
                        <div class="mt-4 mb-6">
                            <!-- Modal title -->
                            <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                                Import Users
                            </p>
                            <form action="{{ route('dashboard.category.importCategory') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    for="file_input">Upload file</label>
                                <input
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="file_input" name="file" type="file" required>
                        </div>
                        <footer
                            class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                            <button
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Accept
                            </button>
                            </form>
                            <button @click="closeModal"
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                                Cancel
                            </button>
                        </footer>
                    </div>
                </div>
                <!-- End of modal backdrop -->

                <table id="crudTable" class="w-full row-border whitespace-no-wrap my-2 py-2">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Tanggal</th>
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
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tfoot>
                </table>
            </div>
        </div>
    @endsection
</x-layout.apps>
