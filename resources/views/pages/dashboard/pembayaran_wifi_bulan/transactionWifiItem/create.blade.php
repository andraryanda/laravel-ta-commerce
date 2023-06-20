<x-layout.apps>
    <x-slot name="header">
        <x-slot name="header">
            <button onclick="window.location.href='{{ route('dashboard.bulan.show', encrypt($transaction->id)) }}'"
                class="w-24 my-6 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
                <div class="flex items-center">
                    <img src="{{ asset('icon/left.png') }}" class="mr-2 bg-white rounded-full" alt="Back"
                        width="25">
                    <p class="inline-block">Back</p>
                </div>
            </button>

        </x-slot>

        @section('pembayaran_bulan_wifi')
            <div class="py-3">
                <div
                    class="w-full p-6 mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div>
                        @if ($errors->any())
                            <div class="mb-5" role="alert">
                                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                                    There's something wrong!
                                </div>
                                <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                    <p>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    </p>
                                </div>
                            </div>
                        @endif
                        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                            {{ __('Create Transaction Wifi Item') }} -- {{ $transaction->id }}
                        </h2>
                        <hr class="my-2">
                        <form action="{{ route('dashboard.item.store') }}" method="post" enctype="multipart/form-data"
                            class="w-full">
                            @csrf

                            <div class="" hidden>

                                <div class="mb-4">
                                    <label for="users_id" class="block mb-2 text-sm font-medium text-gray-700">Pilih
                                        Pengguna
                                    </label>
                                    <input type="text" name="users_id"
                                        class=" w-full p-2 border border-gray-300 rounded-md @error('users_id') border-red-500 @enderror"
                                        value="{{ $transaction->users_id }}" placeholder="Users Id ...">
                                    {{-- <select name="users_id" id="users_id"
                                        class="select-users w-full p-2 border border-gray-300 rounded-md @error('users_id') border-red-500 @enderror"
                                        disabled>
                                        <option value="" selected disabled>-- Pilih Pengguna --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('users_id', $user->id) == $transaction->users_id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select> --}}
                                    @error('users_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="transaction_wifi_id"
                                        class="block mb-2 text-sm font-medium text-gray-700">Pilih
                                        Transaction Wifi ID
                                    </label>
                                    <input type="text" name="transaction_wifi_id"
                                        class=" w-full p-2 border border-gray-300 rounded-md @error('transaction_wifi_id') border-red-500 @enderror"
                                        value="{{ $transaction->id }}" placeholder="Transaction Wifi ID ...">
                                    {{-- <select name="transaction_wifi_id" id="transaction_wifi_id"
                                        class="select-id-transaksi w-full" disabled>
                                        <option value="" selected disabled>-- Pilih Status --</option>
                                        @foreach ($transactions as $tf)
                                            @if ($tf->status == 'SUCCESS')
                                                <option value="{{ $tf->id }}"
                                                    {{ old('transaction_wifi_id', $tf->id) == $transaction->transactions_id ? 'selected' : '' }}>
                                                    @if ($tf->id == $transaction->transactions_id)
                                                        {{ $tf->user->name }} ||
                                                        @foreach ($tf->items as $tff)
                                                            {{ $tff->product->name }} ||
                                                            {{ 'Rp ' . number_format($tff->product->price, 0, ',', '.') }}
                                                            ||
                                                            {{ $tff->id }} {{ __('- (Transaction Utama ID)') }} ||
                                                        @endforeach
                                                        @foreach ($tf->wifi_items as $item2)
                                                            {{ $item2->id }} {{ __('- (Transaction Wifi ID)') }}
                                                        @endforeach
                                                    @endif
                                                </option>
                                            @endif
                                        @endforeach
                                    </select> --}}
                                    @error('transaction_wifi_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="products_id" class="block mb-2 text-sm font-medium text-gray-700">Pilih
                                        Product ID
                                    </label>
                                    <input type="text" name="products_id"
                                        class=" w-full p-2 border border-gray-300 rounded-md @error('products_id') border-red-500 @enderror"
                                        value="{{ $transactionWifiItem->products_id }}" placeholder="Users Id ...">
                                    {{-- <select name="products_id" id="products_id"
                                        class="select-produk w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('products_id') border-red-500 @enderror">
                                        <option value="" selected disabled>-- Pilih Produk --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('products_id', $product->id) ? 'selected' : '' }}>
                                                {{ $product->name }}</option>
                                        @endforeach
                                    </select> --}}
                                    @error('products_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <hr class="my-2">
                            <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                                {{ __('Pembayaran Customer') }}
                            </h2>

                            <hr class="my-2">
                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <div class="mb-4">
                                <label for="payment_method" class="block mb-2 text-sm font-medium text-gray-700">Metode
                                    Pembayaran</label>
                                <div>
                                    <input id="payment-manual" type="radio" name="payment_method" value="MANUAL"
                                        {{ $transactionWifiItem->payment_method == 'MANUAL' ? 'checked' : '' }}
                                        class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600 ml-4">
                                    <label for="payment-manual"
                                        class="inline-block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Manual
                                        Cash</label>
                                    <input id="payment-transfer" type="radio" name="payment_method" value="BANK TRANSFER"
                                        {{ $transactionWifiItem->payment_method == 'BANK TRANSFER' ? 'checked' : '' }}
                                        class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600 ml-4">
                                    <label for="payment-transfer"
                                        class="inline-block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Transfer
                                        Bank</label>
                                </div>
                            </div>

                            <div class="mb-4" id="nama-bank-input" style="display: none;">
                                <label for="payment_bank" class="block mb-2 text-sm font-medium text-gray-700">Nama
                                    Bank</label>
                                <div>
                                    <select name="payment_bank" id="payment_bank"
                                        class="w-full p-2 border border-gray-300 rounded-md select2 @error('payment_bank') border-red-500 @enderror"
                                        required>
                                        <option value="" selected>-- Pilih Nama Bank --</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->nama_bank }}"
                                                {{ $bank->nama_bank == old('payment_bank', $transactionWifiItem->payment_bank) ? 'selected' : '' }}>
                                                {{ $bank->nama_bank }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_bank')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                    @if ($transactionWifiItem->payment_method == 'BANK TRANSFER')
                                        <button type="button" onclick="resetPaymentBank()"
                                            class="ml-2 text-sm text-gray-500">Reset</button>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4" id="total-pembayaran-input">
                                <label for="payment_transaction" class="block mb-2 text-sm font-medium text-gray-700">Total
                                    Pembayaran
                                    Transaksi</label>
                                <input type="text" name="payment_transaction"
                                    class="input-harga w-full p-2 border border-gray-300 rounded-md @error('payment_transaction') border-red-500 @enderror"
                                    value="{{ $transactionWifiItem->payment_transaction }}"
                                    placeholder="Masukan Total Pembayaran Transaksi ...">
                                @error('payment_transaction')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4" id="description">
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Catatan:</label>
                                <textarea name="description" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Tuliskan catatan..."></textarea>
                            </div>

                            <div class="mb-4" id="payment_status">
                                <label for="payment_status" class="block mb-2 text-sm font-medium text-gray-700">Status
                                    Pembayaran</label>
                                <select name="payment_status"
                                    class="w-full p-2 border border-gray-300 rounded-md @error('payment_status') border-red-500 @enderror"
                                    required>
                                    <option value="" selected disabled>-- Pilih Status Pembayaran --</option>
                                    @foreach ($status_payment as $item)
                                        <option value="{{ $item['value'] }}" {{ $item['value'] }}>
                                            {{ $item['label'] }}</option>
                                    @endforeach
                                </select>
                                @error('payment_status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-wrap -mx-3 mb-6">
                                <div class="w-full px-3 text-right">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-right"
                                        onclick="disableButton(this);">
                                        <div class="flex items-center">
                                            <img src="{{ asset('icon/save.png') }}" alt="save" class="mr-2"
                                                width="20" height="20">
                                            <p id="buttonText">Simpan Transaction</p>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endsection


        @push('style')
            <link href="{{ url('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css') }}"
                rel="stylesheet" />
        @endpush

        @push('javascript')
            <script src="{{ url('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
            <script>
                $(document).ready(function() {
                    $('.select-users').select2({
                        placeholder: "Pilih Pengguna",
                        allowClear: true
                    });
                });

                $(document).ready(function() {
                    $('.select-id-transaksi').select2({
                        placeholder: "Pilih ID Transaksi",
                        allowClear: true
                    });
                });
            </script>

            <script>
                $(document).ready(function() {
                    $('#transactions_id option[value=""]').css('display', 'none');
                });
                $(document).ready(function() {
                    $('#status option[value=""]').css('display', 'none');
                });
                // $(document).ready(function() {
                //     $('option[value=""]').css('display', 'none');
                // });
            </script>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>

            <script>
                function resetPaymentBank() {
                    var selectedBank = document.getElementById('selected_bank').innerText;
                    document.getElementById('payment_bank').value = selectedBank;
                }
            </script>

            <script>
                const paymentTransfer = document.getElementById('payment-transfer');
                const paymentManual = document.getElementById('payment-manual');
                const namaBankInput = document.getElementById('nama-bank-input');
                const totalPembayaranInput = document.getElementById('total-pembayaran-input');
                const descriptionInput = document.getElementById('description');
                const statusPembayaranInput = document.getElementById('payment_status');
                const paymentBankInput = document.getElementById('payment_bank');

                function toggleFormInputs() {
                    if (paymentTransfer.checked) {
                        namaBankInput.style.display = 'block';
                        paymentBankInput.required = true;
                        resetPaymentBank();
                    } else if (paymentManual.checked) {
                        namaBankInput.style.display = 'none';
                        paymentBankInput.value = '';
                        paymentBankInput.required = false;
                    } else {
                        namaBankInput.style.display = 'none';
                        paymentBankInput.value = '';
                        paymentBankInput.required = false;
                    }
                }

                function resetPaymentBank() {
                    paymentBankInput.value = '{{ $transactionWifiItem->payment_bank }}';
                }

                function handlePaymentMethodChange() {
                    toggleFormInputs();
                }

                // Initial state
                toggleFormInputs();

                // Check the initial selected option on page load
                window.addEventListener('DOMContentLoaded', function() {
                    if (!paymentTransfer.checked && !paymentManual.checked) {
                        // Tidak ada opsi yang terpilih, sembunyikan form input terkait
                        toggleFormInputs();
                    }
                });

                // Event listeners
                paymentTransfer.addEventListener('change', handlePaymentMethodChange);
                paymentManual.addEventListener('change', handlePaymentMethodChange);
            </script>


            {{-- <script>
                const paymentTransfer = document.getElementById('payment-transfer');
                const paymentManual = document.getElementById('payment-manual');
                const namaBankInput = document.getElementById('nama-bank-input');
                const totalPembayaranInput = document.getElementById('total-pembayaran-input');
                const descriptionInput = document.getElementById('description');
                const statusPembayaranInput = document.getElementById('payment_status');
                const paymentBankInput = document.getElementById('payment_bank');



                function toggleFormInputs() {
                    if (paymentTransfer.checked) {
                        namaBankInput.style.display = 'block';
                        totalPembayaranInput.style.display = 'block';
                        descriptionInput.style.display = 'block';
                        statusPembayaranInput.style.display = 'block';
                        paymentBankInput.required = true;
                    } else if (paymentManual.checked) {
                        namaBankInput.style.display = 'none';
                        totalPembayaranInput.style.display = 'block';
                        descriptionInput.style.display = 'block';
                        statusPembayaranInput.style.display = 'block';
                        paymentBankInput.value = '';
                        paymentBankInput.required = false;
                    } else {
                        namaBankInput.style.display = 'none';
                        totalPembayaranInput.style.display = 'none';
                        descriptionInput.style.display = 'none';
                        statusPembayaranInput.style.display = 'none';
                        paymentBankInput.value = '';
                        paymentBankInput.required = false;
                    }
                }

                function handlePaymentMethodChange() {
                    toggleFormInputs();
                }

                // Initial state
                toggleFormInputs();

                // Check the initial selected option on page load
                window.addEventListener('DOMContentLoaded', function() {
                    if (!paymentTransfer.checked && !paymentManual.checked) {
                        // Tidak ada opsi yang terpilih, sembunyikan form input terkait
                        toggleFormInputs();
                    }
                });

                // Event listeners
                paymentTransfer.addEventListener('change', handlePaymentMethodChange);
                paymentManual.addEventListener('change', handlePaymentMethodChange);
            </script> --}}

            <script>
                function disableButton(button) {
                    button.disabled = true;
                    var buttonText = document.getElementById("buttonText");
                    buttonText.innerText = "Tunggu...";

                    // Mengganti format angka sebelum submit
                    var inputHarga = document.querySelectorAll('.input-harga');
                    inputHarga.forEach(function(input) {
                        var nilaiInput = input.value.replace(/\D/g, '');
                        input.value = nilaiInput;
                    });

                    // Menjalankan submit form setelah 500ms
                    setTimeout(function() {
                        button.form.submit();
                    }, 500);
                }
            </script>

            <script>
                function formatRupiah(angka) {
                    var bilangan = Math.floor(angka);
                    var rupiah = 'Rp. ' + bilangan.toLocaleString('id-ID');
                    return rupiah;
                }

                function formatInputValue(input) {
                    var nilaiInput = parseFloat(input.value);

                    // Cek apakah nilai input adalah angka valid
                    if (!isNaN(nilaiInput)) {
                        var nilaiFormat = formatRupiah(nilaiInput);
                        input.value = nilaiFormat;
                    } else if (input.value !== '') {
                        var formattedValue = input.value.replace(/\D/g, '');
                        var nilaiFormat = formatRupiah(formattedValue);
                        input.value = nilaiFormat;
                    }
                }

                window.addEventListener('DOMContentLoaded', function() {
                    var inputHarga = document.querySelectorAll('.input-harga');
                    inputHarga.forEach(function(input) {
                        formatInputValue(input);

                        input.addEventListener('input', function(e) {
                            formatInputValue(e.target);
                        });

                        input.addEventListener('keydown', function(e) {
                            if (e.key === 'Backspace') {
                                setTimeout(function() {
                                    formatInputValue(input);
                                }, 0);
                            }
                        });
                    });
                });
            </script>




            {{-- <script>
            //mendapatkan nilai dari input price
            let priceInput = document.getElementById("input-harga").value;

            //mengubah nilai menjadi float dan kemudian menggunakan toFixed() untuk menghilangkan .00 di belakang angka
            let formattedPrice = parseFloat(priceInput).toFixed(0);

            //memasukkan nilai yang telah diformat ke dalam input price
            document.getElementById("input-harga").value = formattedPrice;
        </script> --}}












            {{-- <script>
            // Mendapatkan elemen input tanggal
            var expiredWifiInput = document.getElementById('expired_wifi');

            // Mendapatkan tanggal hari ini
            var today = new Date();

            // Menambahkan satu bulan pada tanggal
            today.setMonth(today.getMonth() + 1);

            // Mendapatkan bulan dan tahun setelah penambahan
            var nextMonth = ('0' + (today.getMonth() + 1)).slice(-2);
            var currentYear = today.getFullYear();
            var currentDate = ('0' + today.getDate()).slice(-2);

            // Menyusun format tanggal
            var formattedDate = currentYear + '-' + nextMonth + '-' + currentDate;

            // Mengatur nilai input tanggal kedaluwarsa
            expiredWifiInput.value = formattedDate;
        </script> --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var selectedOption = document.getElementById('selectedOption');
                    var usersIdInput = document.getElementById('users_id');
                    var searchInput = document.getElementById('searchInput');
                    var optionsList = document.getElementById('optionsList');
                    var dropdownOptions = document.getElementById('dropdownOptions');
                    var toggleSearchBtn = document.getElementById('toggleSearchBtn');

                    selectedOption.addEventListener('click', function() {
                        dropdownOptions.classList.toggle('hidden');
                        searchInput.focus();
                    });

                    searchInput.addEventListener('input', function() {
                        var filter = searchInput.value.toLowerCase();
                        var options = optionsList.getElementsByTagName('li');
                        for (var i = 0; i < options.length; i++) {
                            var option = options[i];
                            var optionText = option.textContent.toLowerCase();
                            if (optionText.indexOf(filter) > -1) {
                                option.style.display = '';
                            } else {
                                option.style.display = 'none';
                            }
                        }
                    });

                    optionsList.addEventListener('click', function(e) {
                        var target = e.target;
                        if (target.tagName === 'LI') {
                            var value = target.getAttribute('data-value');
                            var text = target.textContent;
                            usersIdInput.value = value;
                            selectedOption.textContent = text;
                            dropdownOptions.classList.add('hidden');
                            searchInput.value = '';
                            var options = optionsList.getElementsByTagName('li');
                            for (var i = 0; i < script options.length; i++) {
                                options[i].style.display = '';
                            }
                        }
                    });

                    document.addEventListener('click', function(e) {
                        if (!dropdownOptions.contains(e.target) && !selectedOption.contains(e.target)) {
                            dropdownOptions.classList.add('hidden');
                        }
                    });

                    toggleSearchBtn.addEventListener('click', function() {
                        searchInput.value = '';
                        searchInput.focus();
                    });
                });
            </script>
        @endpush
</x-layout.apps>
