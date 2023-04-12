<x-layout.apps>
    <x-slot name="header">
        <h2 class="my-6 mx-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Report Users/Category/Product/Transaction') }}
        </h2>
    </x-slot>

    <x-slot name="slot">


        {{-- Code function halaman Report --}}
        <div class="py-3 mx-2">
            <div
                class="w-full p-6 mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <label for="laporan" class="block font-medium text-sm text-gray-700"><strong>Pilih
                        Laporan:</strong></label>
                <select name="laporan" id="laporan"
                    class="select-search block w-full mt-1 rounded-md p-3 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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

                <div class="mt-3 space-y-3">
                    {{-- All Users --}}
                    <div id="btn-laporan-custom-all-users">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Custom Date All Users</h2>
                            <form method="GET" action="{{ route('dashboard.report.exportCustomAllUsers') }}">
                                <div class="mb-4">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="start_date" id="start_date" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date" required>
                                </div>

                                <button type="submit"
                                    class="w-full sm:w-full bg-purple-500 text-white rounded-md py-2 px-4 font-medium hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Export</button>
                            </form>
                        </div>
                    </div>

                    {{-- User Admin --}}
                    <div id="btn-laporan-custom-user-admin">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Custom Date User Admin</h2>
                            <form method="GET" action="{{ route('dashboard.report.exportCustomRoleAdmin') }}">
                                <div class="mb-4">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="start_date" id="start_date" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date" required>
                                </div>

                                <button type="submit"
                                    class="w-full sm:w-full bg-purple-500 text-white rounded-md py-2 px-4 font-medium hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Export</button>
                            </form>
                        </div>
                    </div>

                    {{-- User Customer --}}
                    <div id="btn-laporan-custom-user-customer">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Custom Date User Customer</h2>
                            <form method="GET" action="{{ route('dashboard.report.exportCustomRoleUser') }}">
                                <div class="mb-4">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="start_date" id="start_date" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date" required>
                                </div>

                                <button type="submit"
                                    class="w-full sm:w-full bg-purple-500 text-white rounded-md py-2 px-4 font-medium hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Export</button>
                            </form>
                        </div>
                    </div>

                    {{-- Category --}}
                    <div id="btn-laporan-custom-category">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Custom Date Category</h2>
                            <form method="GET"
                                action="{{ route('dashboard.report.exportCustomProductCategories') }}">
                                <div class="mb-4">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="start_date" id="start_date" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date" required>
                                </div>

                                <button type="submit"
                                    class="w-full sm:w-full bg-purple-500 text-white rounded-md py-2 px-4 font-medium hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Export</button>
                            </form>
                        </div>
                    </div>

                    {{-- Product --}}
                    <div id="btn-laporan-custom-products">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Custom Date Products</h2>
                            <form method="GET" action="{{ route('dashboard.report.exportCustomProducts') }}">
                                <div class="mb-4">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="start_date" id="start_date" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date" required>
                                </div>

                                <button type="submit"
                                    class="w-full sm:w-full bg-purple-500 text-white rounded-md py-2 px-4 font-medium hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Export</button>
                            </form>
                        </div>
                    </div>

                    {{-- All Transactions --}}
                    <div id="btn-laporan-custom-all-transaksi">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Custom Date Transaksi</h2>
                            <form method="GET"
                                action="{{ route('dashboard.report.exportAllCustomTransactions') }}">
                                <div class="mb-4">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="start_date" id="start_date" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date" required>
                                </div>

                                <button type="submit"
                                    class="w-full sm:w-full bg-purple-500 text-white rounded-md py-2 px-4 font-medium hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Export</button>
                            </form>
                        </div>
                    </div>

                    {{-- Transaction Success --}}
                    <div id="btn-laporan-custom-transaksi-success">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Custom Date Transaksi Success</h2>
                            <form method="GET"
                                action="{{ route('dashboard.report.exportTransactionCustomSuccess') }}">
                                <div class="mb-4">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="start_date" id="start_date" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date" required>
                                </div>

                                <button type="submit"
                                    class="w-full sm:w-full bg-purple-500 text-white rounded-md py-2 px-4 font-medium hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Export</button>
                            </form>
                        </div>
                    </div>

                    {{-- Transaction Pending --}}
                    <div id="btn-laporan-custom-transaksi-pending">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Custom Date Transaksi Pending</h2>
                            <form method="GET"
                                action="{{ route('dashboard.report.exportTransactionCustomPending') }}">
                                <div class="mb-4">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="start_date" id="start_date" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date" required>
                                </div>

                                <button type="submit"
                                    class="w-full sm:w-full bg-purple-500 text-white rounded-md py-2 px-4 font-medium hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Export</button>
                            </form>
                        </div>
                    </div>

                    {{-- Transaction Cancelled --}}
                    <div id="btn-laporan-custom-transaksi-cancelled">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-lg font-semibold mb-4">Custom Date Transaksi Cancelled</h2>
                            <form method="GET"
                                action="{{ route('dashboard.report.exportTransactionCustomCancelled') }}">
                                <div class="mb-4">
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="start_date" id="start_date" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date" required>
                                </div>

                                <button type="submit"
                                    class="w-full sm:w-full bg-purple-500 text-white rounded-md py-2 px-4 font-medium hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Export</button>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        @push('javascript')
            <script>
                $(document).ready(function() {

                    // Hide all buttons on page load
                    $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-custom-all-users,#btn-laporan-custom-user-admin,#btn-laporan-custom-products,#btn-laporan-custom-user-customer,#btn-laporan-custom-category,#btn-laporan-custom-products, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi,#btn-laporan-custom-all-transaksi,#btn-laporan-custom-transaksi-success,#btn-laporan-custom-transaksi-pending, #btn-laporan-custom-transaksi-cancelled, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                        .hide();

                    // Show button when an option is selected

                    $('#laporan').on('change', function() {
                        var selectedOption = $(this).val();

                        if (selectedOption === '') {
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-custom-user-customer,#btn-laporan-custom-all-users, #btn-laporan-user-customer, #btn-laporan-custom-user-admin,#btn-laporan-custom-products,#btn-laporan-custom-category,#btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-custom-all-transaksi, #btn-laporan-custom-transaksi-success,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-pending, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-all-users') {
                            $('#btn-laporan-all-users').show();
                            $('#btn-laporan-custom-all-users').show();
                            $('#btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-custom-user-customer,#btn-laporan-custom-user-admin,#btn-laporan-custom-products,#btn-laporan-custom-category,#btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-success,#btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-user-admin') {
                            $('#btn-laporan-user-admin').show();
                            $('#btn-laporan-custom-user-admin').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-customer, #btn-laporan-custom-user-customer,#btn-laporan-custom-all-users,#btn-laporan-custom-products,#btn-laporan-custom-category,#btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-success,#btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-user-customer') {
                            $('#btn-laporan-user-customer').show();
                            $('#btn-laporan-custom-user-customer').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-kategori,#btn-laporan-custom-user-admin,#btn-laporan-custom-all-users, #btn-laporan-custom-products,#btn-laporan-custom-category,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-pending,#btn-laporan-produk, #btn-laporan-all-transaksi,#btn-laporan-custom-transaksi-success,#btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-kategori') {
                            $('#btn-laporan-kategori').show();
                            $('#btn-laporan-custom-category').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-custom-user-admin,#btn-laporan-custom-all-users,#btn-laporan-custom-products,#btn-laporan-custom-user-customer,#btn-laporan-user-customer, #btn-laporan-produk, #btn-laporan-custom-transaksi-cancelled, #btn-laporan-all-transaksi,#btn-laporan-custom-all-transaksi, #btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-success,#btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-produk') {
                            $('#btn-laporan-produk').show();
                            $('#btn-laporan-custom-products').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-custom-user-admin,#btn-laporan-custom-all-users,#btn-laporan-custom-category,#btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-custom-user-customer,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-all-transaksi,#btn-laporan-custom-all-transaksi, #btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-success,#btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-all-transaksi') {
                            $('#btn-laporan-all-transaksi').show();
                            $('#btn-laporan-custom-all-transaksi').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-custom-category,#btn-laporan-custom-user-customer,#btn-laporan-custom-user-admin,#btn-laporan-custom-all-users,#btn-laporan-custom-products,#btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-success,#btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-transaksi-success') {
                            $('#btn-laporan-transaksi-success').show();
                            $('#btn-laporan-custom-transaksi-success').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-custom-user-customer,#btn-laporan-custom-user-admin,#btn-laporan-custom-products,#btn-laporan-custom-all-users,#btn-laporan-user-customer, #btn-laporan-custom-category,#btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-custom-transaksi-pending,#btn-laporan-all-transaksi,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-transaksi-pending') {
                            $('#btn-laporan-transaksi-pending').show();
                            $('#btn-laporan-custom-transaksi-pending').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-custom-user-customer,#btn-laporan-custom-user-admin,#btn-laporan-custom-all-users,#btn-laporan-user-customer, #btn-laporan-custom-products,#btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-custom-category,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-success,#btn-laporan-all-transaksi,#btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-transaksi-cancelled') {
                            $('#btn-laporan-transaksi-cancelled').show();
                            $('#btn-laporan-custom-transaksi-cancelled').show();
                            $('#btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-custom-user-customer,#btn-laporan-custom-user-admin,#btn-laporan-custom-products,#btn-laporan-custom-all-users,#btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-custom-category,#btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-success,#btn-laporan-all-transaksi,#btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending')
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

    </x-slot>

</x-layout.apps>
