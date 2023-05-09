<x-layout.apps>
    <x-slot name="header">

        <h2 id="header-laporan-none" class="my-6 mx-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Report Users/Category/Product/Transaction') }}
        </h2>

        <h2 id="header-laporan-all-users" class="my-6 mx-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Laporan All Users') }}
        </h2>
        <h2 id="header-laporan-user-admin" class="my-6 mx-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Laporan User Admin') }}
        </h2>
        <h2 id="header-laporan-user-customer" class="my-6 mx-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Laporan User Customer') }}
        </h2>
        <h2 id="header-laporan-kategori" class="my-6 mx-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Laporan Kategori') }}
        </h2>
        <h2 id="header-laporan-produk" class="my-6 mx-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Laporan Produk') }}
        </h2>
        <h2 id="header-laporan-all-transaksi" class="my-6 mx-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Laporan All Transaksi') }}
        </h2>
        <h2 id="header-laporan-transaksi-success"
            class="my-6 mx-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Laporan Transaksi Success') }}
        </h2>
        <h2 id="header-laporan-transaksi-pending"
            class="my-6 mx-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Laporan Transaksi Pending') }}
        </h2>
        <h2 id="header-laporan-transaksi-cancelled"
            class="my-6 mx-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Laporan Transaksi Cancelled') }}
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
                    <option value="" selected disabled>-- Pilih Status --</option>
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
                        onclick="showLoading(this);"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export All Users</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-user-admin" title="Export User Admin"
                        onclick="showLoading(this);"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export User Admin</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-user-customer" title="Export User Customer"
                        onclick="showLoading(this);"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export User Customer</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-kategori" title="Export Category"
                        onclick="showLoading(this);"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export Kategori</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-produk" title="Export Product" onclick="showLoading(this);"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25" class="mr-2">
                            <p>Export Produk</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-all-transaksi" title="Export All Transaction"
                        onclick="showLoading(this);"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25"
                                class="mr-2">
                            <p>Export All Transaksi</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-transaksi-success" title="Export Transaction Success"
                        onclick="showLoading(this);"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25"
                                class="mr-2">
                            <p>Export Transaksi Success</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-transaksi-pending" title="Export Transaction Pending"
                        onclick="showLoading(this);"
                        class="text-gray-900 shadow-sm bg-yellow-300 hover:bg-yellow-100 border border-yellow-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                        <div class="flex items-center">
                            <img src="{{ asset('icon/download.png') }}" alt="Export" width="25"
                                class="mr-2">
                            <p>Export Transaksi Pending</p>
                        </div>
                    </button>
                    <button type="button" id="btn-laporan-transaksi-cancelled" title="Export Transaction Cancelled"
                        onclick="showLoading(this);"
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
                                        name="start_date" id="start_date_1" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date_1" required>
                                </div>

                                <button type="submit" onclick="showLoadingCustom1(event);"
                                    class="w-full sm:w-full bg-purple-500 text-white rounded-md py-2 px-4 font-medium hover:bg-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    Export
                                </button>
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
                                        name="start_date" id="start_date_2" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date_2" required>
                                </div>

                                <button type="submit" onclick="showLoadingCustom2(event);"
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
                                        name="start_date" id="start_date_3" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date_3" required>
                                </div>

                                <button type="submit" onclick="showLoadingCustom3(event);"
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
                                        name="start_date" id="start_date_4" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date_4" required>
                                </div>

                                <button type="submit" onclick="showLoadingCustom4(event);"
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
                                        name="start_date" id="start_date_5" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date_5" required>
                                </div>

                                <button type="submit" onclick="showLoadingCustom5(event);"
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
                                        name="start_date" id="start_date_6" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date_6" required>
                                </div>

                                <button type="submit" onclick="showLoadingCustom6(event);"
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
                                        name="start_date" id="start_date_7" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date_7" required>
                                </div>

                                <button type="submit" onclick="showLoadingCustom7(event);"
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
                                        name="start_date" id="start_date_8" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date_8" required>
                                </div>

                                <button type="submit" onclick="showLoadingCustom8(event);"
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
                                        name="start_date" id="start_date_9" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                        Date</label>
                                    <input type="date" class="form-input mt-1 block w-full sm:w-full rounded-md"
                                        name="end_date" id="end_date_9" required>
                                </div>

                                <button type="submit" onclick="showLoadingCustom9(event);"
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
                    $('#laporan option[value=""]').css('display', 'none');
                });
            </script>

            <script>
                function isOnline() {
                    return window.navigator.onLine;
                }

                function showLoading(button) {
                    button.classList.add("loading");
                    button.disabled = true;

                    // add loading text
                    var loadingSpan = document.createElement("span");
                    loadingSpan.innerText = "Loading...";
                    button.appendChild(loadingSpan);

                    if (!isOnline()) {
                        setTimeout(function() {
                            // remove loading text
                            button.removeChild(loadingSpan);
                            button.classList.remove("loading");
                            button.disabled = false;

                            // show alert message
                            Swal.fire({
                                title: 'Tidak ada koneksi internet',
                                text: 'Harap pastikan internet tersedia untuk mengirim data, tetapi Anda masih bisa melakukan export laporan.',
                                icon: 'error'
                            });
                        }); // show loading for 3 seconds
                    } else {
                        setTimeout(function() {
                            // remove loading text
                            button.removeChild(loadingSpan);
                            button.classList.remove("loading");
                            button.disabled = false;

                            // continue with export process
                            // ...

                        }, 3000); // show loading for 3 seconds
                    }

                    return true;
                }
            </script>

            {{-- custome date --}}
            <script>
                function showLoadingCustom1(event) {
                    event.preventDefault(); // mencegah pengiriman formulir

                    var button = event.target;
                    button.classList.add("loading");
                    button.disabled = true;

                    // add loading text
                    var loadingSpan = document.createElement("span");
                    loadingSpan.innerText = "Loading...";
                    button.appendChild(loadingSpan);

                    // get start and end date input values
                    var startDate = document.getElementById("start_date_1").value;
                    var endDate = document.getElementById("end_date_1").value;

                    // validate start and end date
                    if (startDate === "" || endDate === "") {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Silakan isi tanggal terlebih dahulu',
                            icon: 'warning'
                        });

                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        return;
                    }

                    setTimeout(function() {
                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        // submit form
                        button.form.submit();
                    }, 3000); // show loading for 3 seconds

                    // show alert message if not online
                    if (!isOnline()) {
                        Swal.fire({
                            title: 'Tidak ada koneksi internet',
                            text: 'Harap pastikan internet tersedia untuk mengirim data, tetapi Anda masih bisa melakukan export laporan.',
                            icon: 'warning'
                        });
                    }
                }
            </script>
            <script>
                function showLoadingCustom2(event) {
                    event.preventDefault(); // mencegah pengiriman formulir

                    var button = event.target;
                    button.classList.add("loading");
                    button.disabled = true;

                    // add loading text
                    var loadingSpan = document.createElement("span");
                    loadingSpan.innerText = "Loading...";
                    button.appendChild(loadingSpan);

                    // get start and end date input values
                    var startDate = document.getElementById("start_date_2").value;
                    var endDate = document.getElementById("end_date_2").value;

                    // validate start and end date
                    if (startDate === "" || endDate === "") {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Silakan isi tanggal terlebih dahulu',
                            icon: 'warning'
                        });

                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        return;
                    }

                    setTimeout(function() {
                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        // submit form
                        button.form.submit();
                    }, 3000); // show loading for 3 seconds

                    // show alert message if not online
                    if (!isOnline()) {
                        Swal.fire({
                            title: 'Tidak ada koneksi internet',
                            text: 'Harap pastikan internet tersedia untuk mengirim data, tetapi Anda masih bisa melakukan export laporan.',
                            icon: 'warning'
                        });
                    }
                }
            </script>
            <script>
                function showLoadingCustom3(event) {
                    event.preventDefault(); // mencegah pengiriman formulir

                    var button = event.target;
                    button.classList.add("loading");
                    button.disabled = true;

                    // add loading text
                    var loadingSpan = document.createElement("span");
                    loadingSpan.innerText = "Loading...";
                    button.appendChild(loadingSpan);

                    // get start and end date input values
                    var startDate = document.getElementById("start_date_3").value;
                    var endDate = document.getElementById("end_date_3").value;

                    // validate start and end date
                    if (startDate === "" || endDate === "") {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Silakan isi tanggal terlebih dahulu',
                            icon: 'warning'
                        });

                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        return;
                    }

                    setTimeout(function() {
                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        // submit form
                        button.form.submit();
                    }, 3000); // show loading for 3 seconds

                    // show alert message if not online
                    if (!isOnline()) {
                        Swal.fire({
                            title: 'Tidak ada koneksi internet',
                            text: 'Harap pastikan internet tersedia untuk mengirim data, tetapi Anda masih bisa melakukan export laporan.',
                            icon: 'warning'
                        });
                    }
                }
            </script>
            <script>
                function showLoadingCustom4(event) {
                    event.preventDefault(); // mencegah pengiriman formulir

                    var button = event.target;
                    button.classList.add("loading");
                    button.disabled = true;

                    // add loading text
                    var loadingSpan = document.createElement("span");
                    loadingSpan.innerText = "Loading...";
                    button.appendChild(loadingSpan);

                    // get start and end date input values
                    var startDate = document.getElementById("start_date_4").value;
                    var endDate = document.getElementById("end_date_4").value;

                    // validate start and end date
                    if (startDate === "" || endDate === "") {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Silakan isi tanggal terlebih dahulu',
                            icon: 'warning'
                        });

                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        return;
                    }

                    setTimeout(function() {
                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        // submit form
                        button.form.submit();
                    }, 3000); // show loading for 3 seconds

                    // show alert message if not online
                    if (!isOnline()) {
                        Swal.fire({
                            title: 'Tidak ada koneksi internet',
                            text: 'Harap pastikan internet tersedia untuk mengirim data, tetapi Anda masih bisa melakukan export laporan.',
                            icon: 'warning'
                        });
                    }
                }
            </script>
            <script>
                function showLoadingCustom5(event) {
                    event.preventDefault(); // mencegah pengiriman formulir

                    var button = event.target;
                    button.classList.add("loading");
                    button.disabled = true;

                    // add loading text
                    var loadingSpan = document.createElement("span");
                    loadingSpan.innerText = "Loading...";
                    button.appendChild(loadingSpan);

                    // get start and end date input values
                    var startDate = document.getElementById("start_date_5").value;
                    var endDate = document.getElementById("end_date_5").value;

                    // validate start and end date
                    if (startDate === "" || endDate === "") {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Silakan isi tanggal terlebih dahulu',
                            icon: 'warning'
                        });

                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        return;
                    }

                    setTimeout(function() {
                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        // submit form
                        button.form.submit();
                    }, 3000); // show loading for 3 seconds

                    // show alert message if not online
                    if (!isOnline()) {
                        Swal.fire({
                            title: 'Tidak ada koneksi internet',
                            text: 'Harap pastikan internet tersedia untuk mengirim data, tetapi Anda masih bisa melakukan export laporan.',
                            icon: 'warning'
                        });
                    }
                }
            </script>
            <script>
                function showLoadingCustom6(event) {
                    event.preventDefault(); // mencegah pengiriman formulir

                    var button = event.target;
                    button.classList.add("loading");
                    button.disabled = true;

                    // add loading text
                    var loadingSpan = document.createElement("span");
                    loadingSpan.innerText = "Loading...";
                    button.appendChild(loadingSpan);

                    // get start and end date input values
                    var startDate = document.getElementById("start_date_6").value;
                    var endDate = document.getElementById("end_date_6").value;

                    // validate start and end date
                    if (startDate === "" || endDate === "") {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Silakan isi tanggal terlebih dahulu',
                            icon: 'warning'
                        });

                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        return;
                    }

                    setTimeout(function() {
                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        // submit form
                        button.form.submit();
                    }, 3000); // show loading for 3 seconds

                    // show alert message if not online
                    if (!isOnline()) {
                        Swal.fire({
                            title: 'Tidak ada koneksi internet',
                            text: 'Harap pastikan internet tersedia untuk mengirim data, tetapi Anda masih bisa melakukan export laporan.',
                            icon: 'warning'
                        });
                    }
                }
            </script>
            <script>
                function showLoadingCustom7(event) {
                    event.preventDefault(); // mencegah pengiriman formulir

                    var button = event.target;
                    button.classList.add("loading");
                    button.disabled = true;

                    // add loading text
                    var loadingSpan = document.createElement("span");
                    loadingSpan.innerText = "Loading...";
                    button.appendChild(loadingSpan);

                    // get start and end date input values
                    var startDate = document.getElementById("start_date_7").value;
                    var endDate = document.getElementById("end_date_7").value;

                    // validate start and end date
                    if (startDate === "" || endDate === "") {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Silakan isi tanggal terlebih dahulu',
                            icon: 'warning'
                        });

                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        return;
                    }

                    setTimeout(function() {
                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        // submit form
                        button.form.submit();
                    }, 3000); // show loading for 3 seconds

                    // show alert message if not online
                    if (!isOnline()) {
                        Swal.fire({
                            title: 'Tidak ada koneksi internet',
                            text: 'Harap pastikan internet tersedia untuk mengirim data, tetapi Anda masih bisa melakukan export laporan.',
                            icon: 'warning'
                        });
                    }
                }
            </script>
            <script>
                function showLoadingCustom8(event) {
                    event.preventDefault(); // mencegah pengiriman formulir

                    var button = event.target;
                    button.classList.add("loading");
                    button.disabled = true;

                    // add loading text
                    var loadingSpan = document.createElement("span");
                    loadingSpan.innerText = "Loading...";
                    button.appendChild(loadingSpan);

                    // get start and end date input values
                    var startDate = document.getElementById("start_date_8").value;
                    var endDate = document.getElementById("end_date_8").value;

                    // validate start and end date
                    if (startDate === "" || endDate === "") {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Silakan isi tanggal terlebih dahulu',
                            icon: 'warning'
                        });

                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        return;
                    }

                    setTimeout(function() {
                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        // submit form
                        button.form.submit();
                    }, 3000); // show loading for 3 seconds

                    // show alert message if not online
                    if (!isOnline()) {
                        Swal.fire({
                            title: 'Tidak ada koneksi internet',
                            text: 'Harap pastikan internet tersedia untuk mengirim data, tetapi Anda masih bisa melakukan export laporan.',
                            icon: 'warning'
                        });
                    }
                }
            </script>
            <script>
                function showLoadingCustom9(event) {
                    event.preventDefault(); // mencegah pengiriman formulir

                    var button = event.target;
                    button.classList.add("loading");
                    button.disabled = true;

                    // add loading text
                    var loadingSpan = document.createElement("span");
                    loadingSpan.innerText = "Loading...";
                    button.appendChild(loadingSpan);

                    // get start and end date input values
                    var startDate = document.getElementById("start_date_9").value;
                    var endDate = document.getElementById("end_date_9").value;

                    // validate start and end date
                    if (startDate === "" || endDate === "") {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Silakan isi tanggal terlebih dahulu',
                            icon: 'warning'
                        });

                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        return;
                    }

                    setTimeout(function() {
                        // remove loading text
                        button.removeChild(loadingSpan);
                        button.classList.remove("loading");
                        button.disabled = false;

                        // submit form
                        button.form.submit();
                    }, 3000); // show loading for 3 seconds

                    // show alert message if not online
                    if (!isOnline()) {
                        Swal.fire({
                            title: 'Tidak ada koneksi internet',
                            text: 'Harap pastikan internet tersedia untuk mengirim data, tetapi Anda masih bisa melakukan export laporan.',
                            icon: 'warning'
                        });
                    }
                }
            </script>
            {{-- end custom date --}}

            <script>
                $(document).ready(function() {

                    // Hide all buttons on page load
                    $('#header-laporan-user-admin, #header-laporan-transaksi-success, #header-laporan-transaksi-pending, #header-laporan-transaksi-cancelled, #header-laporan-all-transaksi, #header-laporan-kategori, #header-laporan-produk, #header-laporan-user-customer, #header-laporan-all-users, #btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-user-customer, #btn-laporan-custom-all-users,#btn-laporan-custom-user-admin,#btn-laporan-custom-products,#btn-laporan-custom-user-customer,#btn-laporan-custom-category,#btn-laporan-custom-products, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi,#btn-laporan-custom-all-transaksi,#btn-laporan-custom-transaksi-success,#btn-laporan-custom-transaksi-pending, #btn-laporan-custom-transaksi-cancelled, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                        .hide();
                    // Show button when an option is selected
                    $('#laporan').on('change', function() {
                        var selectedOption = $(this).val();

                        if (selectedOption === '') {
                            $('#header-laporan-none').show();
                            $('#header-laporan-all-users, #header-laporan-all-transaksi, #header-laporan-transaksi-success, #header-laporan-transaksi-pending, #header-laporan-transaksi-cancelled, #header-laporan-user-admin, #header-laporan-kategori, #header-laporan-produk, #header-laporan-user-customer, #btn-laporan-all-users, #btn-laporan-user-admin, #btn-laporan-custom-user-customer,#btn-laporan-custom-all-users, #btn-laporan-user-customer, #btn-laporan-custom-user-admin,#btn-laporan-custom-products,#btn-laporan-custom-category,#btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-custom-all-transaksi, #btn-laporan-custom-transaksi-success,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-pending, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                .hide();
                        } else if (selectedOption === 'laporan-all-users') {
                            Swal.fire({
                                title: 'Tunggu sebentar...',
                                text: 'Sedang memuat laporan all users...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    setTimeout(() => {
                                        $('#btn-laporan-all-users').show();
                                        $('#btn-laporan-custom-all-users').show();
                                        $('#header-laporan-all-users').show();
                                        $('#header-laporan-none, #btn-laporan-user-admin, #btn-laporan-user-customer, #header-laporan-all-transaksi, #header-laporan-transaksi-success, #header-laporan-transaksi-pending, #header-laporan-transaksi-cancelled, #header-laporan-kategori, #header-laporan-produk, #header-laporan-user-admin, #header-laporan-user-customer, #btn-laporan-custom-user-customer,#btn-laporan-custom-user-admin,#btn-laporan-custom-products,#btn-laporan-custom-category,#btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi, #btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-success,#btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                            .hide();
                                        Swal.close();
                                    }, 1000);
                                }
                            });
                        } else if (selectedOption === 'laporan-user-admin') {
                            Swal.fire({
                                title: 'Tunggu sebentar...',
                                text: 'Sedang memuat laporan user admin...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    setTimeout(() => {
                                        $('#btn-laporan-user-admin').show();
                                        $('#btn-laporan-custom-user-admin').show();
                                        $('#header-laporan-user-admin').show();
                                        $('#header-laporan-none, #btn-laporan-all-users, #btn-laporan-user-customer, #header-laporan-all-transaksi, #header-laporan-transaksi-success, #header-laporan-transaksi-pending, #header-laporan-transaksi-cancelled, #header-laporan-kategori, #header-laporan-produk, #header-laporan-user-customer, #header-laporan-all-users, #btn-laporan-custom-user-customer,#btn-laporan-custom-all-users,#btn-laporan-custom-products,#btn-laporan-custom-category,#btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-all-transaksi,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-success,#btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                            .hide();
                                        Swal.close();
                                    }, 1000);
                                }
                            });
                        } else if (selectedOption === 'laporan-user-customer') {
                            Swal.fire({
                                title: 'Tunggu sebentar...',
                                text: 'Sedang memuat laporan user customer...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    setTimeout(() => {
                                        $('#btn-laporan-user-customer').show();
                                        $('#btn-laporan-custom-user-customer').show();
                                        $('#header-laporan-user-customer').show();
                                        $('#header-laporan-none, #btn-laporan-all-users, #btn-laporan-user-admin, #header-laporan-all-transaksi, #header-laporan-transaksi-success, #header-laporan-transaksi-pending, #header-laporan-transaksi-cancelled, #header-laporan-kategori, #header-laporan-produk, #header-laporan-user-admin,  #header-laporan-all-users, #btn-laporan-kategori,#btn-laporan-custom-user-admin,#btn-laporan-custom-all-users, #btn-laporan-custom-products,#btn-laporan-custom-category,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-pending,#btn-laporan-produk, #btn-laporan-all-transaksi,#btn-laporan-custom-transaksi-success,#btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                            .hide();
                                        Swal.close();
                                    }, 1000);
                                }
                            });
                        } else if (selectedOption === 'laporan-kategori') {
                            Swal.fire({
                                title: 'Tunggu sebentar...',
                                text: 'Sedang memuat laporan kategori...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    setTimeout(() => {
                                        $('#btn-laporan-kategori').show();
                                        $('#btn-laporan-custom-category').show();
                                        $('#header-laporan-kategori').show();
                                        $('#header-laporan-none, #btn-laporan-all-users, #btn-laporan-user-admin, #header-laporan-all-transaksi, #header-laporan-transaksi-success, #header-laporan-transaksi-pending, #header-laporan-transaksi-cancelled, #header-laporan-produk, #header-laporan-user-admin, #header-laporan-user-customer, #header-laporan-all-users, #btn-laporan-custom-user-admin,#btn-laporan-custom-all-users,#btn-laporan-custom-products,#btn-laporan-custom-user-customer,#btn-laporan-user-customer, #btn-laporan-produk, #btn-laporan-custom-transaksi-cancelled, #btn-laporan-all-transaksi,#btn-laporan-custom-all-transaksi, #btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-success,#btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                            .hide();
                                        Swal.close();
                                    }, 1000);
                                }
                            });
                        } else if (selectedOption === 'laporan-produk') {
                            Swal.fire({
                                title: 'Tunggu sebentar...',
                                text: 'Sedang memuat laporan produk...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    setTimeout(() => {
                                        $('#btn-laporan-produk').show();
                                        $('#btn-laporan-custom-products').show();
                                        $('#header-laporan-produk').show();
                                        $('#header-laporan-none, #btn-laporan-all-users, #btn-laporan-user-admin, #header-laporan-all-transaksi, #header-laporan-transaksi-success, #header-laporan-transaksi-pending, #header-laporan-transaksi-cancelled, #header-laporan-kategori ,#header-laporan-user-admin, #header-laporan-user-customer, #header-laporan-all-users, #btn-laporan-custom-user-admin,#btn-laporan-custom-all-users,#btn-laporan-custom-category,#btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-custom-user-customer,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-all-transaksi,#btn-laporan-custom-all-transaksi, #btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-success,#btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                            .hide();
                                        Swal.close();
                                    }, 1000);
                                }
                            });
                        } else if (selectedOption === 'laporan-all-transaksi') {
                            Swal.fire({
                                title: 'Tunggu sebentar...',
                                text: 'Sedang memuat laporan all transaksi...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    setTimeout(() => {
                                        $('#btn-laporan-all-transaksi').show();
                                        $('#btn-laporan-custom-all-transaksi').show();
                                        $('#header-laporan-all-transaksi').show();
                                        $('#header-laporan-none, #btn-laporan-all-users, #btn-laporan-user-admin, #header-laporan-kategori, #header-laporan-transaksi-success, #header-laporan-transaksi-pending, #header-laporan-transaksi-cancelled, #header-laporan-produk, #header-laporan-user-admin, #header-laporan-user-customer, #header-laporan-all-users, #btn-laporan-custom-category,#btn-laporan-custom-user-customer,#btn-laporan-custom-user-admin,#btn-laporan-custom-all-users,#btn-laporan-custom-products,#btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-success,#btn-laporan-transaksi-success, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                            .hide();
                                        Swal.close();
                                    }, 1000);
                                }
                            });
                        } else if (selectedOption === 'laporan-transaksi-success') {
                            Swal.fire({
                                title: 'Tunggu sebentar...',
                                text: 'Sedang memuat laporan transaksi success...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    setTimeout(() => {
                                        $('#btn-laporan-transaksi-success').show();
                                        $('#btn-laporan-custom-transaksi-success').show();
                                        $('#header-laporan-transaksi-success').show();
                                        $('#header-laporan-none, #btn-laporan-all-users, #btn-laporan-user-admin, #header-laporan-all-transaksi, #header-laporan-transaksi-pending, #header-laporan-transaksi-cancelled, #header-laporan-kategori, #header-laporan-produk, #header-laporan-user-admin, #header-laporan-user-customer, #header-laporan-all-users, #btn-laporan-custom-user-customer,#btn-laporan-custom-user-admin,#btn-laporan-custom-products,#btn-laporan-custom-all-users,#btn-laporan-user-customer, #btn-laporan-custom-category,#btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-custom-transaksi-pending,#btn-laporan-all-transaksi,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-pending, #btn-laporan-transaksi-cancelled')
                                            .hide();
                                        Swal.close();
                                    }, 1000);
                                }
                            });
                        } else if (selectedOption === 'laporan-transaksi-pending') {
                            Swal.fire({
                                title: 'Tunggu sebentar...',
                                text: 'Sedang memuat laporan transaksi pending...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    setTimeout(() => {
                                        $('#btn-laporan-transaksi-pending').show();
                                        $('#btn-laporan-custom-transaksi-pending').show();
                                        $('#header-laporan-transaksi-pending').show();
                                        $('#header-laporan-none, #btn-laporan-all-users, #btn-laporan-user-admin, #header-laporan-all-transaksi, #header-laporan-transaksi-success, #header-laporan-transaksi-cancelled, #header-laporan-kategori, #header-laporan-produk, #header-laporan-user-admin, #header-laporan-user-customer, #header-laporan-all-users, #btn-laporan-custom-user-customer,#btn-laporan-custom-user-admin,#btn-laporan-custom-all-users,#btn-laporan-user-customer, #btn-laporan-custom-products,#btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-custom-category,#btn-laporan-custom-transaksi-cancelled, #btn-laporan-custom-transaksi-success,#btn-laporan-all-transaksi,#btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-cancelled')
                                            .hide();
                                        Swal.close();
                                    }, 1000);
                                }
                            });
                        } else if (selectedOption === 'laporan-transaksi-cancelled') {
                            Swal.fire({
                                title: 'Tunggu sebentar...',
                                text: 'Sedang memuat laporan transaksi cancelled...',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                allowEnterKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    setTimeout(() => {
                                        $('#btn-laporan-transaksi-cancelled').show();
                                        $('#btn-laporan-custom-transaksi-cancelled').show();
                                        $('#header-laporan-transaksi-cancelled').show();
                                        $('#header-laporan-none, #btn-laporan-all-users, #btn-laporan-user-admin, #header-laporan-all-transaksi, #header-laporan-transaksi-success, #header-laporan-transaksi-pending, #header-laporan-kategori, #header-laporan-produk, #header-laporan-user-admin, #header-laporan-user-customer, #header-laporan-all-users, #btn-laporan-custom-user-customer,#btn-laporan-custom-user-admin,#btn-laporan-custom-products,#btn-laporan-custom-all-users,#btn-laporan-user-customer, #btn-laporan-kategori, #btn-laporan-produk, #btn-laporan-custom-category,#btn-laporan-custom-transaksi-pending,#btn-laporan-custom-transaksi-success,#btn-laporan-all-transaksi,#btn-laporan-custom-all-transaksi, #btn-laporan-transaksi-success, #btn-laporan-transaksi-pending')
                                            .hide();
                                        Swal.close();
                                    }, 1000);
                                }
                            });
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

        @push('style')
            <style>
                .loading {
                    position: relative;
                }

                .loading::before {
                    content: "";
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(255, 255, 255, 0.8);
                    z-index: 1;
                }

                .loading span {
                    position: absolute;
                    left: 50%;
                    top: 50%;
                    transform: translate(-50%, -50%);
                    z-index: 2;
                }

                .loading::after {
                    content: "";
                    position: absolute;
                    left: 50%;
                    top: 50%;
                    transform: translate(-50%, -50%);
                    width: 25px;
                    height: 25px;
                    border-radius: 50%;
                    border: 2px solid #ccc;
                    border-top-color: #333;
                    animation: spin 0.6s linear infinite;
                    z-index: 3;
                }

                @keyframes spin {
                    to {
                        transform: translate(-50%, -50%) rotate(360deg);
                    }
                }
            </style>
        @endpush

    </x-slot>

</x-layout.apps>
