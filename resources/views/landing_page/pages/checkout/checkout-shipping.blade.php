@extends('landing_page.layout_landing_page.app-landing-page')
@section('indexLandingPage')
    <div class="container rounded bg-white">
        <div class="bg row d-flex justify-content-center pb-5">
            <div class="col-sm-4 col-md-4 ml-1">
                <div class="py-4 pl-6 d-flex flex-row">
                    <h5><span class="fa fa-check-square-o mr-2"></span><b>Checkout</b> | </h5><span
                        class="px-2 text-white font-weight-bold bg-warning rounded-pill">Pay</span>
                </div>
                <div class="bg-white p-2 d-flex flex-column" style="border-radius:14px">
                    <div class="text-center mt-4">
                        <h5 class="font-weight-bold">Harga Produk:</h5>
                        @foreach ($product->galleries as $item)
                            <img class="img-fluid my-3 rounded" src="{{ $item->url }}" width="300" />
                        @endforeach
                    </div>
                    <h5 class="font-weight-bold text-center">{{ $product->name }}</h5>
                    <p class="text-center font-italic text-secondary">{{ $product->category->name }}</p>
                    <h4 class="green mb-3 text-center">{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</h4>
                </div>


                <div class="bg-white my-3 p-2 d-flex flex-column" style="border-radius:14px">
                    <form action="{{ route('landingPage.checkout') }}" method="post">
                        @csrf
                        <!-- Form input untuk product_id -->
                        <input type="hidden" name="products_id" value="{{ $product->id }}">

                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" class="form-control" name="address" id="address" value="Karangampel"
                                required>
                        </div>

                        <div class="d-none">
                            <div class="form-group">
                                <label for="total_price">Total Harga</label>
                                <input type="number" class="form-control" name="total_price" id="total_price"
                                    value="{{ $product->price }}" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="shipping_price">Biaya Pengiriman</label>
                                <input type="number" class="form-control" name="shipping_price" id="shipping_price"
                                    value="0" readonly required>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status" readonly required>
                                    <option value="PENDING">PENDING</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="items">Item</label>
                                <input type="hidden" name="items[]" id="items" value="">
                                <input type="number" class="form-control" name="quantity" id="quantity" max="1"
                                    value="1" readonly>
                            </div>
                        </div>
                </div>

            </div>

            <div class="col-sm-5 col-md-6 mobile">
                <div class="py-4 d-flex justify-content-end">
                    <a href="{{ route('landingPage.index') }}"
                        class="btn-action btn-warning text-black py-2 px-2 font-weight-bold rounded-pill">
                        Cancel and return to website
                    </a>
                </div>
                <div class="bg-white p-3 d-flex flex-column" style="border-radius:14px">
                    <div class="pt-2">
                        <h5 class="font-weight-bold my-2">Payment details</h5>
                    </div>
                    <div class="my-2">
                        <div class="d-flex">
                            <div class="col-8">Harga normal</div>
                            <div class="ml-auto green">{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="d-flex">
                            <div class="col-8">Ongkir</div>
                            <div class="ml-auto green">Free</div>
                        </div>

                        <div class="d-flex my-3">
                            <div class="col-8">Total Pembayaran</div>
                            <div class="ml-auto "><b>{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</b></div>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="border-top px-4 mx-8 pt-2"></div>
                        <h5 class="font-weight-bold my-2">Metode Pembayaran</h5>
                    </div>
                    <div class="d-flex flex-row">
                        <h5 class="pl-2"><span class="fa fa-check-square-o"></span><b> Checkout</b> | </h5><span
                            class="ml-2 bg-warning px-2 text-white font-weight-bold rounded-pill">Pay</span>
                    </div>
                    <div class="pl-2">
                        <div class="font-italic"><span class="text-danger mx-2">*</span>Pembayaran bisa dilakukan secara
                            Manual dengan menghubungi No.Kontak Admin
                        </div>
                        <div class="pb-2 my-2"><b>085314005779</b></div>
                    </div>

                    <button type="submit" class=" btn mt-4 btn-primary btn-block rounded-pill">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('icon/credit-card.png') }}" alt="Bayar" width="30" class="mr-2">
                            <p class="text-white mb-0 font-weight-bold">Bayar sekarang!</p>
                        </div>
                    </button>
                    {{-- <input type="button" value="Konfirmasi pembayaran" class=" btn mt-4 btn-primary btn-block"
                        style="border-radius:100px; background-color:#2447f9;"> --}}


                    </form>

                    <button type="button" class="btn btn-success my-2 py-2 rounded-pill">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('icon/whatsapp.png') }}" alt="whatsapp" width="30" class="mr-2">
                            <p class="text-white mb-0 font-weight-bold">Hubungi Admin Whatsapp</p>
                        </div>
                    </button>



                </div>
                <div class="bg-white mt-4 p-3 d-flex flex-column" style="border-radius:14px">
                    <div class="pt-2">
                        <h5 class="font-weight-bold my-2">Informasi penting</h5>
                    </div>
                    <div class="pl-2">
                        <div>Proses konfirmasi pembayaran akan membutuhkan waktu sekitar 20 menit (dari pesan WhatsApp
                            dikirim). Mohon menunggu dengan sabar dan terima kasih.</div>
                    </div>
                    <div class="pt-2">
                        <h5 class="font-weight-bold my-2">Butuh bantuan? hubungi kami</h5>
                    </div>
                    <div class="d-flex">
                        <div class="col-8">Admin</div>
                        <div class="ml-auto">Gus</div>
                    </div>
                    <div class="d-flex">
                        <div class="col-8">No. WhatsApp</div>
                        <div class="ml-auto"><b>+6285314005779</b></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            body {
                background-color: #F6F8FD
            }

            .bg {
                background-color: #F6F8FD
            }

            .green {
                color: rgb(15, 207, 143);
                font-weight: 680
            }

            @media(max-width:567px) {
                .mobile {
                    padding-top: 40px
                }
            }
        </style>
    @endpush

    @push('javascript')
        <script>
            var products = [];

            function addProduct() {
                var productId = prompt("Masukkan ID Produk:");
                var quantity = prompt("Masukkan Jumlah:");

                if (productId && quantity) {
                    var product = {
                        id: productId,
                        quantity: quantity
                    };

                    products.push(product);

                    // Menyimpan data produk pada input hidden
                    document.getElementById('items').value = JSON.stringify(products);
                }
            }
        </script>
    @endpush
@endsection
