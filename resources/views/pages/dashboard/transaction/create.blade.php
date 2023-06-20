<x-layout.apps>
    <x-slot name="header">
        <x-slot name="header">
            <button onclick="goBack()"
                class="w-24 my-6 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
                <div class="flex items-center">
                    <img src="{{ asset('icon/left.png') }}" class="mr-2 bg-white rounded-full" alt="Back"
                        width="25">
                    <p class="inline-block">Back</p>
                </div>
            </button>

            <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ __('Create Transaction') }}
            </h2>
        </x-slot>

        @section('transaction')

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
                        <form action="{{ route('dashboard.transaction.store') }}" method="post"
                            enctype="multipart/form-data" class="w-full">
                            @csrf
                            <div class="mb-4">
                                <label for="users_id"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Pilih
                                    Pengguna</label>
                                {{-- <div class="relative">
                                    <div class="flex">
                                        <div class="flex-grow">
                                            <div class="relative">
                                                <div id="selectedOption"
                                                    class="w-full p-2 border border-gray-300 rounded-md bg-white cursor-pointer dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    Pilih pengguna...
                                                </div>
                                                <input type="hidden" name="users_id" id="users_id" value="">
                                                <div id="dropdownOptions"
                                                    class="absolute z-10 hidden w-full py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                    <input type="text" id="searchInput"
                                                        class="w-full p-2 border-b border-gray-300 rounded-t-md focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        placeholder="Cari pengguna..." required>
                                                    <ul id="optionsList" class="max-h-32 overflow-y-auto">
                                                        @foreach ($users as $user)
                                                            <li data-value="{{ $user->id }}"
                                                                class="px-4 py-2 cursor-pointer hover:bg-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                {{ $user->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <select name="users_id" id="users_id"
                                    class="select-users w-full p-2 border border-gray-300 rounded-md @error('users_id') border-red-500 @enderror">
                                    @foreach ($users as $user)
                                        <option></option>
                                        <option value="{{ $user->id }}"
                                            {{ old('users_id') == $user->id ? 'selected' : '' }}
                                            data-address="{{ $user->alamat }}">{{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-4">
                                <label for="products_id"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Pilih
                                    Produk</label>
                                <select name="products_id" id="products_id"
                                    class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled selected>-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old('products_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="quantity"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Jumlah</label>
                                <input type="number" name="quantity" id="quantity" value="1"
                                    class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label for="address"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Alamat</label>
                                <textarea id="address" name="address" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Tuliskan Alamat..." required></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="total_price"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Total
                                    Harga</label>
                                <input type="text" name="total_price" id="total_price"
                                    class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{ $products->first()->price }}" readonly>
                            </div>


                            <div class="mb-4">
                                <label for="shipping_price"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Harga
                                    Pengiriman</label>
                                <input type="number" name="shipping_price" id="shipping_price"
                                    class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="0" readonly>
                            </div>
                            <div class="mb-4">
                                <label for="status"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Status</label>
                                <select name="status" id="status"
                                    class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" selected disabled>-- Pilih Status --</option>
                                    @foreach ($status_transaction as $item)
                                        <option value="{{ $item['value'] }}"
                                            {{ $item['value'] == old('status', $item['value'] == $item['value']) ? '' : '' }}>
                                            {{ $item['label'] }}
                                        </option>
                                    @endforeach
                                </select>
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

            @push('style')
                <link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css') }}">
            @endpush

            @push('javascript')
                <script src="{{ asset('select2/dist/js/select2.min.js') }}"></script>

                <script>
                    $(document).ready(function() {
                        $('.select-users').select2({
                            placeholder: "Pilih Pengguna",
                            allowClear: true
                        });
                        $('#users_id').on('change', function() {
                            var selectedOption = $(this).find('option:selected');
                            var address = selectedOption.data('address');
                            $('#address').val(address);
                        });
                    });
                </script>

                <script>
                    $(document).ready(function() {
                        $('#status option[value=""]').css('display', 'none');
                    });

                    $(document).ready(function() {
                        $('#products_id option[value=""]').css('display', 'none');
                    });
                </script>
                <script>
                    function goBack() {
                        window.history.back();
                    }
                </script>

                <script>
                    $(document).ready(function() {
                        const selectUser = $('#users_id');
                        const addressInput = $('#address');

                        selectUser.on('change', function() {
                            const userId = $(this).val();

                            // Kirim permintaan AJAX ke endpoint untuk mengambil data alamat pengguna
                            // Gantikan URL_API dengan URL endpoint Anda
                            $.ajax({
                                url: `/users/${userId}/address`,
                                type: 'GET',
                                success: function(response) {
                                    // Mengisikan data alamat ke input alamat
                                    addressInput.val(response.address);
                                },
                                error: function(error) {
                                    console.error(error);
                                }
                            });
                        });
                    });
                </script>



                <script>
                    function disableButton(button) {
                        button.disabled = true;
                        var buttonText = document.getElementById("buttonText");
                        buttonText.innerText = "Tunggu...";
                        button.form.submit();
                    }
                </script>

                <script>
                    // Mengambil elemen input field quantity
                    var quantityInput = document.getElementById('quantity');

                    // Menambahkan event listener pada input field quantity
                    quantityInput.addEventListener('change', function(event) {
                        // Mengambil nilai yang diinputkan pengguna
                        var newQuantity = event.target.value;

                        // Mengubah nilai input field quantity menjadi nilai baru yang diinputkan
                        quantityInput.value = newQuantity;
                    });
                </script>

                <script>
                    // Mendapatkan elemen select dan input
                    var productSelect = document.getElementById('products_id');
                    var totalPriceInput = document.getElementById('total_price');

                    // Menambahkan event listener ketika pilihan produk berubah
                    productSelect.addEventListener('change', function() {
                        // Mendapatkan harga produk terpilih
                        var selectedProductId = this.value;
                        var selectedProduct = {!! $products->toJson() !!}.find(function(product) {
                            return product.id == selectedProductId;
                        });

                        // Mengupdate nilai total harga pada input
                        if (selectedProduct) {
                            totalPriceInput.value = selectedProduct.price;
                        } else {
                            totalPriceInput.value = '';
                        }
                    });
                </script>

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
                                for (var i = 0; i < options.length; i++) {
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

        @endsection
</x-layout.apps>
