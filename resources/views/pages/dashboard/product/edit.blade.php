<x-layout.apps>
    <x-slot name="header">
        <button onclick="goBack()"
            class="w-24 my-6 text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-3 py-2.5 text-center mr-2 mb-2">
            <div class="flex items-center">
                <img src="{{ asset('icon/left.png') }}" class="mr-2 bg-white rounded-full" alt="Back" width="25">
                <p class="inline-block">Back</p>
            </div>
        </button>

        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Produk &raquo; {{ $item->name }} &raquo; Edit
        </h2>
    </x-slot>

    {{-- <x-slot name="slot">
    </x-slot> --}}

    @section('product')

        <div class="py-3">
            <div
                class="w-full p-6 mx-auto sm:px-6 lg:px-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
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
                    <form class="w-full" action="{{ route('dashboard.product.update', $item->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Nama produk
                                </label>
                                <input value="{{ old('name') ?? $item->name }}" name="name"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text" placeholder="Product Name">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Tags
                                </label>
                                <input value="{{ old('tags') ?? $item->tags }}" name="tags"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text"
                                    placeholder="Product Tags. Comma Separated. Example: popular">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Kategori Produk
                                </label>
                                <select name="categories_id"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name">
                                    <option value="{{ $item->categories_id }}">
                                        {{ \App\Models\ProductCategory::find($item->categories_id)->name }}</option>
                                    <option disabled>----</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Deskripsi
                                </label>
                                <textarea name="description"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-last-name" type="text" placeholder="Product Description">{{ old('description') ?? $item->description }}</textarea>
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-last-name">
                                    Harga Produk
                                </label>
                                <input value="{{ old('price') ?? $item->price }}" name="price"
                                    class="input-harga appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="input-harga" type="text" placeholder="Masukkan Harga" />
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="grid-status-product">
                                    Status Produk
                                </label>
                                <select name="status_product"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="status_product" required>
                                    <option value="" selected disabled>-- Pilih Status --</option>
                                    @foreach ($status_product as $status)
                                        @if ($status['value'])
                                            <option value="{{ $status['value'] }}"
                                                {{ $item->status_product == $status['value'] ? 'selected' : '' }}>
                                                {{ $status['label'] }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3 text-right">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-right"
                                    onclick="disableButton(this);">
                                    <div class="flex items-center">
                                        <img src="{{ asset('icon/save.png') }}" alt="save" class="mr-2"
                                            width="20" height="20">
                                        <p id="buttonText">Simpan Update Produk</p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('javascript')
            <script>
                $(document).ready(function() {
                    $('#status_product option[value=""]').css('display', 'none');
                });
            </script>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>

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

            {{-- <script>
                //mendapatkan nilai dari input price
                let priceInput = document.getElementById("input-harga").value;

                //mengubah nilai menjadi float dan kemudian menggunakan toFixed() untuk menghilangkan .00 di belakang angka
                let formattedPrice = parseFloat(priceInput).toFixed(0);

                //memasukkan nilai yang telah diformat ke dalam input price
                document.getElementById("input-harga").value = formattedPrice;
            </script> --}}
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
        @endpush

    @endsection

</x-layout.apps>
