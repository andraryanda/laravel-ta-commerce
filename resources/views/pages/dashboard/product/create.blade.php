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
            {!! __('Produk &raquo; Tambah') !!}
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
                    <form class="w-full" action="{{ route('dashboard.product.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="product-name">
                                    Nama Produk
                                </label>
                                <input value="{{ old('name') }}" name="name"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="product-name" type="text" placeholder="Product Name">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="product-tags">
                                    Tags
                                </label>
                                <input value="{{ old('tags') }}" name="tags"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="product-tags" type="text"
                                    placeholder="Product Tags. Comma Separated. Example: popular">
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="product-categories">
                                    Kategori Produk
                                </label>
                                <select name="categories_id"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="product-categories">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="product-description">
                                    Deskripsi
                                </label>
                                <textarea name="description"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="product-description" type="text" placeholder="Product Description">{{ old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="price">
                                    Harga Produk
                                </label>
                                <input value="{{ old('price') }}" name="price"
                                    class="input-harga appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="input-harga" type="text" placeholder="Masukkan Harga">
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
                                    @foreach ($status_product as $item)
                                        <option value="{{ $item['value'] }}"
                                            {{ $item['value'] == old('status_product', $item['value'] == $item['value']) ? '' : '' }}>
                                            {{ $item['label'] }}
                                        </option>
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
                                        <p id="buttonText">Simpan Produk</p>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @push('javascript')
        <script>
            $(document).ready(function() {
                $('#status_product option[value=""]').css('display', 'none');
            });
        </script>
        {{-- <script>
            function disableButton(button) {
                button.disabled = true;
                var buttonText = document.getElementById("buttonText");
                buttonText.innerText = "Tunggu...";
                button.form.submit();
            }
        </script> --}}

        <script>
            function disableButton(button) {
                button.disabled = true;
                var buttonText = document.getElementById("buttonText");
                buttonText.innerText = "Tunggu...";

                // Mengganti format angka sebelum submit
                var inputHarga = document.getElementById('input-harga');
                var nilaiInput = inputHarga.value.replace(/\D/g, '');
                inputHarga.value = nilaiInput;

                // Menjalankan submit form setelah 500ms
                setTimeout(function() {
                    button.form.submit();
                }, 500);
            }
        </script>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>


        <script>
            function formatRupiah(angka) {
                var rupiah = '';
                var angkarev = angka.toString().split('').reverse().join('');
                for (var i = 0; i < angkarev.length; i++)
                    if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
                return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
            }

            var inputHarga = document.getElementById('input-harga');
            inputHarga.addEventListener('input', function(e) {
                var nilaiInput = e.target.value.replace(/\D/g, '');
                var nilaiFormat = formatRupiah(nilaiInput);
                e.target.value = nilaiFormat;
            });

            var form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                var inputHarga = document.getElementById('input-harga');
                var nilaiInput = inputHarga.value.replace(/\D/g, '');
                inputHarga.value = nilaiInput;
            });
        </script>

        {{-- <script>
            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, "").toString(),
                    split = number_string.split(","),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
            }

            var inputHarga = document.getElementById("grid-last-name");

            inputHarga.addEventListener("keyup", function(e) {
                var nilaiInput = e.target.value;
                var nilaiRupiah = formatRupiah(nilaiInput, "Rp. ");
                e.target.value = nilaiRupiah;
            });
        </script> --}}
    @endpush

    </x-layout.ap>
