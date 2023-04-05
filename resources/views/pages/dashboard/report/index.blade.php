<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Report Daily/Week/Mont/Year') }}
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
                });
            </script>
        @endpush


        {{-- Code function halaman Report --}}
        <div class="py-3">
            <div
                class="w-full p-6 mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                {{-- <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            {{ __('Generate Report') }}
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <form id="report-form" action="#" method="POST">
                            @csrf
                            <div class="grid grid-cols-4 gap-4">
                                <div class="col-span-4 sm:col-span-2">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">
                                                {{ __('Start Date') }}
                                            </label>
                                            <input type="date" name="start_date"
                                                class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-500 dark:focus:ring-indigo-500 dark:text-gray-300">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">
                                                {{ __('End Date') }}
                                            </label>
                                            <input type="date" name="end_date"
                                                class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-500 dark:focus:ring-indigo-500 dark:text-gray-300">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-4 sm:col-span-1">
                                    <button type="submit"
                                        class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">{{ __('Generate Report') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            {{ __('Export Report') }}
                        </h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <button id="export"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">{{ __('Export Report') }}</button>
                    </div>
                </div>
                </div> --}}

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

                    <button id="btn-laporan-all-users"
                        class="bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded">Export
                        Laporan All Users</button>
                    <button id="btn-laporan-user-admin"
                        class="bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded">Export
                        Laporan User Admin</button>
                    <button id="btn-laporan-user-customer"
                        class="bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded">Export
                        Laporan User Customer</button>
                    <button id="btn-laporan-kategori"
                        class="bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded">Export
                        Laporan Kategori</button>
                    <button id="btn-laporan-produk"
                        class="bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded">Export
                        Laporan Produk</button>
                    <button id="btn-laporan-all-transaksi"
                        class="bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded">Export
                        Laporan All Transaksi</button>
                    <button id="btn-laporan-transaksi-success"
                        class="bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded">Export
                        Laporan Transaksi Success</button>
                    <button id="btn-laporan-transaksi-pending"
                        class="bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded">Export
                        Laporan Transaksi Pending</button>
                    <button id="btn-laporan-transaksi-cancelled"
                        class="bg-blue-500 hover:bg-blue-300 text-white py-2 px-4 rounded">Export
                        Laporan Transaksi Cancelled</button>
                </div>
            </div>
        </div>




    </x-slot>

</x-layout.apps>
