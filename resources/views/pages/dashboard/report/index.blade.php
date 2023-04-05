<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Report Users/Category/Product/Transaction') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <x-slot name="styles">

        </x-slot>

        @push('javascript')
            <script>
                $(document).ready(function() {
                    // Action when the form is submitted
                    $('#report-form').submit(function(event) {
                        event.preventDefault();
                        var form = $(this);

                        $.ajax({
                            url: form.attr('action'),
                            method: form.attr('method'),
                            data: form.serialize(),
                            dataType: 'json',
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Please wait',
                                    text: 'Generating report...',
                                    allowOutsideClick: false,
                                    showConfirmButton: false,
                                    onBeforeOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Report generated',
                                    showConfirmButton: true,
                                }).then(function() {
                                    window.location.href = response.download_link;
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON.message,
                                    showConfirmButton: true,
                                });
                            }
                        });
                    });

                    // Action when the export button is clicked
                    $('#export').click(function() {
                        var form = $('#report-form');
                        form.attr('action', '{{ url('#') }}');
                        form.attr('method', 'POST');
                        form.submit();
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    // Hide all buttons on page load
                    $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                        .hide();

                    // Show button when an option is selected
                    $('#laporan').on('change', function() {
                        var selectedOption = $(this).val();

                        if (selectedOption === '') {
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-all-users') {
                            $('#btn-laporan-all-users').show();
                            $('#btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-user-admin') {
                            $('#btn-laporan-user-admin').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-user-customer') {
                            $('#btn-laporan-user-customer').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-kategori') {
                            $('#btn-laporan-kategori').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-produk') {
                            $('#btn-laporan-produk').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-all-transaksi') {
                            $('#btn-laporan-all-transaksi').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-transaksi-success') {
                            $('#btn-laporan-transaksi-success').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-transaksi-pending') {
                            $('#btn-laporan-transaksi-pending').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-transaksi-cancelled') {
                            $('#btn-laporan-transaksi-cancelled').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending')
                                .hide();
                        }
                    });

                    // Access export URL on button click
                    $('#btn-laporan-all-users').on('click', function() {
                        var exportUrl = "{{ route('dashboard.report.exportAllUsers') }}";
                        window.location.href = exportUrl;
                    });
                    $('#btn-laporan-user-admin').on('click', function() {
                        var exportUrl = "{{ route('dashboard.report.exportRoleAdmin') }}";
                        window.location.href = exportUrl;
                    });
                    $('#btn-laporan-user-customer').on('click', function() {
                        var exportUrl = "{{ route('dashboard.report.exportRoleUser') }}";
                        window.location.href = exportUrl;
                    });
                    $('#btn-laporan-kategori').on('click', function() {
                        var exportUrl = "{{ route('dashboard.report.exportProductCategories') }}";
                        window.location.href = exportUrl;
                    });
                    $('#btn-laporan-produk').on('click', function() {
                        var exportUrl = "{{ route('dashboard.report.exportProducts') }}";
                        window.location.href = exportUrl;
                    });
                    $('#btn-laporan-all-transaksi').on('click', function() {
                        var exportUrl = "{{ route('dashboard.report.exportAllTransactions') }}";
                        window.location.href = exportUrl;
                    });
                    $('#btn-laporan-transaksi-success').on('click', function() {
                        var exportUrl = "{{ route('dashboard.report.exportTransactionSuccess') }}";
                        window.location.href = exportUrl;
                    });
                    $('#btn-laporan-transaksi-pending').on('click', function() {
                        var exportUrl = "{{ route('dashboard.report.exportTransactionPending') }}";
                        window.location.href = exportUrl;
                    });
                    $('#btn-laporan-transaksi-cancelled').on('click', function() {
                        var exportUrl = "{{ route('dashboard.report.exportTransactionCancelled') }}";
                        window.location.href = exportUrl;
                    });
                });
            </script>
        @endpush


        {{-- Code function halaman Report --}}
        <div class="py-3">
            <div
                class="w-full p-6 mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <label for="laporan" class="block font-medium text-sm text-gray-700"><strong>Pilih
                        Laporan:</strong></label>
                <select name="laporan" id="laporan"
                    class="block w-full mt-1 rounded-md p-3 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value=""> -- Select --</option>
                    <option value="laporan-all-users">Laporan All Users</option>
                    <option value="laporan-user-admin">Laporan User Admin</option>
                    <option value="laporan-user-customer">Laporan User Customer</option>
                    <option value="laporan-kategori">Laporan Kategori</option>
                    <option value="laporan-produk">Laporan Produk</option>
                    <option value="laporan-all-transaksi">Laporan All Transaksi</option>
                    <option value="laporan-transaksi-success">Laporan Transaksi Success</option>
                    <option value="laporan-transaksi-pending">Laporan Transaksi Pending</option>
                    <option value="laporan-transaksi-cancelled">Laporan Transaksi Cancelled</option>
                </select>

                <div id="btn-container" class="mt-3 space-y-3">
                    <div class="flex">
                        <span class="text-red-500 mx-1">*</span>
                        <i>Export Laporan dibawah ini menggunakan format</i> <strong class="text-green-500 mx-1">Excel
                            CSV</strong>
                    </div>

                    <button type="button" id="btn-laporan-all-users" title="Export All Users"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export All Users</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-user-admin" title="Export User Admin"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export User Admin</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-user-customer" title="Export User Customer"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export User Customer</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-kategori" title="Export Category"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export Kategori</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-produk" title="Export Product"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export Produk</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-all-transaksi" title="Export All Transaction"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export All Transaksi</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-transaksi-success" title="Export Transaction Success"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export Transaksi Success</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-transaksi-pending" title="Export Transaction Pending"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export Transaksi Pending</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-transaksi-cancelled" title="Export Transaction Cancelled"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25"
                                class="mr-2">
                            <p>Export Transaksi Cancelled</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>




    </x-slot>

</x-layout.apps>
