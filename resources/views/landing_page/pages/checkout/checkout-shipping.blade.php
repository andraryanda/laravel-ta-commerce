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
                        <div class="slick-slider">
                            @foreach ($product->galleries as $item)
                                <div>
                                    <img class="img-fluid my-3 rounded d-flex justify-content-center mx-auto"
                                        src="{{ $item->url }}" width="300" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <h5 class="font-weight-bold text-center">{{ $product->name }}</h5>
                    <p class="text-center font-italic text-secondary">{{ $product->category->name }}</p>
                    <h4 class="green mb-3 text-center">{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</h4>
                </div>

                <div class="bg-white my-3 p-2 d-flex flex-column" style="border-radius:14px">
                    {{-- Open Form --}}
                    <form action="{{ route('landingPage.checkout') }}" method="post">
                        @csrf
                        <div class="text-center mt-4">
                            <h5 class="font-weight-bold">Data Profile:</h5>
                        </div>
                        <div class="form-group mt-3">
                            <label for="name">Nama Pengguna</label>
                            <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}"
                                readonly required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="phone">Nomor Handphone</label>
                            <input type="text" class="form-control" id="phone" value="{{ Auth::user()->phone }}"
                                readonly required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" value="{{ Auth::user()->email }}"
                                readonly required>
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea name="address" id="address" class="form-control" cols="30"
                                rows="5"value="{{ Auth::user()->alamat }}">{{ Auth::user()->alamat }}</textarea>
                        </div>

                        <div class="d-none">
                            <div class="form-group">
                                <label for="total_price">Product ID</label>
                                <input type="text" class="form-control" name="products_id" id="products_id"
                                    value="{{ $product->id }}" readonly required>
                            </div>

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
                                <input type="number" class="form-control" name="quantity" id="quantity" value="1"
                                    readonly>
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
                    <div class="pt-2 mb-2">
                        <div class="border-top px-4 mx-8 pt-2"></div>
                        <h5 class="font-weight-bold my-2">Metode Pembayaran</h5>
                    </div>
                    <div class="d-flex flex-row">
                        <img src="{{ asset('icon/whatsapp.png') }}" alt="Bayar" width="30" class="mr-2">
                        <h5 class="font-weight-bold">Bagaimana Cara membayar Manual?</h5>
                    </div>
                    <div class="pl-2">
                        <div class="font-italic"><span class="text-danger mx-2">*</span>Pembayaran bisa dilakukan secara
                            Manual dengan menghubungi No.Kontak Admin atau bisa mengeklik Tombol <span
                                class="font-weight-bold text-success">Hubungi Admin Whatsapp</span>
                        </div>
                    </div>
                    <div class="pb-2 my-2">
                        <div class="d-flex">
                            <h5 class="mx-2 font-weight-bolder">No.Whatsapp:</h5>
                            <b>085314005779</b>
                        </div>
                    </div>
                    <div class="d-flex flex-row">
                        <img src="{{ asset('icon/credit-card.png') }}" alt="Bayar" width="30" class="mr-2">
                        <h5 class="font-weight-bold">Bagaimana Cara membayar Otomatis?</h5>
                    </div>
                    <div class="text-center">
                        <a href="#" class="text-link-primary text-primary font-weight-bold" data-toggle="modal"
                            data-target="#exampleModalLong">
                            <u>Bingung Cara Pembayaran Otomatis? Klik Disini</u>
                        </a>
                    </div>
                    {{-- Modal --}}
                    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-weight-bold" id="exampleModalLongTitle">Cara Pembayaran
                                        Otomatis -
                                        Transaksi Digital</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-left my-2">
                                        <h5 class="font-weight-bold">1. Pembayaran Otomatis</h5>
                                    </div>
                                    <div class="my-2 text-justify">
                                        <p> Pertama kalian akan ditampilkan Halaman Pembayaran dan memilih metode
                                            pembayaran.
                                            Adapun metode pembayaran hanya ada 2 metode yaitu, <b>Pembayaran Otomatis</b>
                                            dan
                                            <b>Pembayaran Manual</b> <i>(Jika mengalami permasalahan untuk pembayaran /
                                                Tidak
                                                mengerti)</i>
                                        </p>
                                        <img src="{{ asset('metode-pembayaran/Screenshot_0.png') }}"
                                            alt="metode-pembayaran-0">
                                    </div>
                                    <div class="text-left my-2">
                                        <h5 class="font-weight-bold">2. Pembayaran Pemilihan Metode Transfer</h5>
                                    </div>
                                    <div class="my-2 text-justify">
                                        <p>Setelah kalian memilih metode <b>Pembayaran Otomatis</b>, kalian akan diarahkan
                                            kehalaman Transaksi. Disini kalian bisa memilih metode pembayaran, untuk
                                            rekomendasi
                                            pembayaran kami menyarankan untuk memilih <b>Transfer Bank</b>.</p>
                                        <img src="{{ asset('metode-pembayaran/Screenshot_1.png') }}"
                                            alt="metode-pembayaran-1" height="100%">
                                    </div>
                                    <div class="text-left my-2">
                                        <h5 class="font-weight-bold">3. Pemilihan Pembayaran Transfer Bank</h5>
                                    </div>
                                    <div class="my-2 text-justify">
                                        <p>Disini kalian bebas untuk memilih metode Pembayaran <b>Bank</b> mana yang ingin
                                            digunakan.</p>
                                        <img src="{{ asset('metode-pembayaran/Screenshot_2.png') }}"
                                            alt="metode-pembayaran-2" height="100%">
                                    </div>
                                    <div class="text-left my-2">
                                        <h5 class="font-weight-bold">4. Pembayaran Transfer Bank</h5>
                                    </div>
                                    <div class="my-2 text-justify">
                                        <p>Selanjutnya, ketika sudah menentukan pemilihan pembayaran bank, kalian akan
                                            ditampilkan halaman seperti ini. Disini kalian tinggal mengeklik tulisan
                                            <b>Salin</b> maka otomatis meng-copy/menyimpan <b>Nomor Virtual Accout (NVA)</b>
                                            dan
                                            juga kalian bisa mengeklik untuk mengetahui cara membayar NVA tersebut.
                                        </p>
                                        <h5 class="my-2">
                                            <div class="text-center">
                                                <span class="text-danger font-weight-bold">!! Apabila kalian mengeklik
                                                    Tombol
                                                </span>
                                                <a class="btn btn-dark text-white my-2" disabled>Kembali To Merchant</a>
                                            </div>
                                            <p class="text-justify">
                                                Maka otomatis Pembayaran Transaksi kalian dibatalkan /
                                                Cancelled Transaksi.
                                                Apabila ingin membeli lagi, kalian bisa mengulang cara pertama.
                                            </p>
                                        </h5>
                                        <img src="{{ asset('metode-pembayaran/Screenshot_3.png') }}"
                                            alt="metode-pembayaran-3" height="100%">
                                    </div>
                                    <div class="text-left my-2">
                                        <h5 class="font-weight-bold">5. Pembayaran Success</h5>
                                    </div>
                                    <div class="my-2 text-justify">
                                        <p>Setelah sudah melakukan pembayaran Transfer Bank pada <b>Nomor Virtual Account
                                                (NVA)</b> kalian harus kembali ke halaman transaksi lagi dan tunggu beberapa
                                            menit, maka akan muncul tampilan <b>Transaksi Nomor Virtual Account(NVA)
                                                Pembayaran Success. Setelah itu kalian hanya perlu menunggu 5 Detik dan akan
                                                otomatis dipindahkan halaman detail transaksi success.</b> Berikut contoh
                                            gambar:</p>
                                        <img src="{{ asset('metode-pembayaran/Screenshot_4.png') }}"
                                            alt="metode-pembayaran-4" height="100%">
                                    </div>
                                    <div class="text-left my-2">
                                        <h5 class="font-weight-bold">6. Detail Transaksi Success</h5>
                                    </div>
                                    <div class="my-2 text-justify">
                                        <p>Berikut adalah Halaman Detail Transaksi Success, hal ini menandakan bahwa
                                            Transaksi kalian sudah berhasil. Disini kalian bisa mengeklik <b>Tombol Back</b>
                                            dan bisa <b>Download Bukti Transaksi/kwitansi</b> kalian.</p>
                                        <p class="font-italic">Apabila masih bingung untuk Download Bukti
                                            Transaksi/Kwitansi kalian juga bisa memintanya Ke Admin, dengan menghubungi
                                            @forelse ($landingPageContact as $item)
                                                <b>Nomor berikut: {{ $item->phone_contact }}</b>

                                            @empty

                                                <b>Nomor berikut: 085314005779</b>
                                            @endforelse
                                        </p>
                                        <img src="{{ asset('metode-pembayaran/Screenshot_5.png') }}"
                                            alt="metode-pembayaran-5" height="100%">
                                        <img src="{{ asset('metode-pembayaran/Screenshot_6.png') }}"
                                            alt="metode-pembayaran-6" height="100%">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger shadow-lg"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Tutup Modal --}}

                    <div class="pl-2 mt-3">
                        <div class="font-italic"><span class="text-danger mx-2">*</span>
                            Klik Disini Sekarang Metode pembayaran Otomatis
                        </div>
                    </div>

                    <button type="submit" name="bayar_sekarang" class="btn mt-4 btn-primary btn-block rounded-pill"
                        onclick="return disableButton(this, document.getElementsByName('bayar_manual')[0]);">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('icon/credit-card.png') }}" alt="Bayar" width="30"
                                class="mr-2">
                            <p class="text-white mb-0 font-weight-bold">Bayar sekarang!</p>
                        </div>
                    </button>

                    <button type="submit" name="bayar_manual" class="btn btn-success my-2 py-2 rounded-pill"
                        onclick="return disableButton(this, document.getElementsByName('bayar_sekarang')[0]);">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('icon/whatsapp.png') }}" alt="whatsapp" width="30" class="mr-2">
                            <p class="text-white mb-0 font-weight-bold">Bayar Manual & Hubungi Admin Whatsapp</p>
                        </div>
                    </button>
                    </form>

                </div>
                <div class="bg-white mt-4 p-3 d-flex flex-column" style="border-radius:14px">
                    <div class="pt-2">
                        <h5 class="font-weight-bold my-2">Informasi penting</h5>
                    </div>
                    <div class="pl-2">
                        <div style="text-align: justify;">Proses konfirmasi pembayaran akan membutuhkan waktu sekitar <b>20
                                menit</b> (dari pesan
                            WhatsApp
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
                        @forelse ($landingPageContact as $item)
                            <div class="ml-auto"><b>{{ $item->phone_contact }}</b></div>

                        @empty
                            <div class="ml-auto"><b>+6285314005779</b></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('slick/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('slick/slick-theme.css') }}">
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
        <style>
            .slick-dots li button:before {
                font-size: 12px;
                color: #2b67ff;
            }
        </style>
    @endpush

    @push('javascript')
        <script src="{{ asset('slick/slick.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('.slick-slider').slick({
                    dots: true,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 1,
                    adaptiveHeight: true,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                });
            });
        </script>

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
        <script>
            function disableButton(button, otherButton) {
                if (button.getAttribute('data-disabled') === 'true') {
                    showAlert('Tunggu hingga proses selesai!');
                    return false;
                }

                button.setAttribute('data-disabled', 'true');
                button.querySelector('p').innerText = 'Tunggu...';
                otherButton.setAttribute('disabled', 'true');

                // Mengembalikan status tombol setelah simulasi waktu proses
                setTimeout(function() {
                    button.setAttribute('data-disabled', 'false');
                    button.querySelector('p').innerText = 'Bayar sekarang!';
                    otherButton.removeAttribute('disabled');
                }, 5000); // Contoh: 5 detik

                return true;
            }

            function showAlert(message) {
                var alertElement = document.createElement('div');
                alertElement.classList.add('alert');
                alertElement.innerText = message;

                document.body.appendChild(alertElement);

                setTimeout(function() {
                    alertElement.style.display = 'none';
                }, 5000); // Contoh: 5 detik
            }
        </script>
    @endpush
@endsection
