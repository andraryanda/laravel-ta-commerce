@extends('landing_page.layout_landing_page.app-landing-page')
@section('indexLandingPage')
    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hero__slider owl-carousel">
            @forelse ($landingPageHome as $item)
                <div class="hero__item set-bg d-flex justify-content-center align-items-center"
                    data-setbg="{{ Storage::url($item->image_carousel) }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hero__text text-center">
                                    <h5>{{ $item->header_title_carousel }}</h5>
                                    <h2>{{ $item->title_carousel }}</h2>
                                    <a href="{{ route('landingPage.pricing') }}" class="primary-btn">Get started now</a>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                            <div class="hero__img">
                                <img src="{{ asset('landing_page/img/hero/hero-right.png') }}" alt="{{ $item->id }}">
                            </div>
                        </div> --}}
                        </div>
                    </div>
                </div>

            @empty
                <div class="hero__item set-bg" data-setbg="{{ asset('landing_page/img/hero/hero-1.jpg') }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="hero__text">
                                    <h5>Starting At Only $ 2.8/month</h5>
                                    <h2>Welcome to the best<br /> Network WiFi</h2>
                                    <a href="#" class="primary-btn">Get started now</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero__img">
                                    <img src="{{ asset('landing_page/img/hero/hero-right.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero__item set-bg" data-setbg="{{ asset('landing_page/img/hero/hero-1.jpg') }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="hero__text">
                                    <h5>Starting At Only $ 2.8/month</h5>
                                    <h2>Welcome to the best<br /> AL-N3T Support Gesitnet Kami Networking</h2>
                                    <a href="#" class="primary-btn">Get started now</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="hero__img">
                                    <img src="{{ asset('landing_page/img/hero/hero-right.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Register Domain Section Begin -->
    <section class="register-domain spad">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="register__text">
                        <div class="section-title">
                            <h3>Bergabung dengan Jaringan WiFi!</h3>
                        </div>
                        <div class="register__result">
                            <ul>
                                <li>1 <span>Mbps</span></li>
                                <li>2 <span>Mbps</span></li>
                                <li>3 <span>Mbps</span></li>
                                <li>4 <span>Mbps</span></li>
                                <li>5 <span>Mbps</span></li>
                            </ul>
                        </div>
                        <p>Nikmati kebebasan terhubung dengan jaringan WiFi kami yang cepat dan handal. Dapatkan kecepatan
                            hingga 5 Mbps untuk menikmati pengalaman online yang lancar dan menyenangkan. Jadikan koneksi
                            internet sebagai bagian tak terpisahkan dari gaya hidup Anda dan nikmati segala manfaatnya.</p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Register Domain Section End -->

    <!-- Services Section Begin -->
    <section class="services-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h3>Kenapa Harus Membeli WiFi dari AL-N3T?</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="services__item">
                        <h5>Produk WiFi Berkualitas</h5>
                        {{-- <span>Mulai Dari $1.84</span> --}}
                        <p>Kami menyediakan produk WiFi berkualitas tinggi yang memberikan koneksi yang stabil dan cepat
                            untuk rumah Anda. Nikmati pengalaman online yang lancar dan tanpa gangguan.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="services__item">
                        <h5>Kecepatan Internet Unggul</h5>
                        {{-- <span>Mulai Dari $1.84</span> --}}
                        <p>Dapatkan kecepatan internet yang unggul dengan WiFi AL-N3T kami. Mempercepat kinerja bisnis Anda
                            dengan akses internet super cepat.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="services__item">
                        <h5>Layanan Profesional</h5>
                        {{-- <span>Mulai Dari $1.84</span> --}}
                        <p>Kami menyediakan layanan profesional untuk membantu Anda dalam instalasi, konfigurasi, dan
                            pemeliharaan WiFi rumah Anda. Tim ahli kami siap membantu Anda setiap saat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section End -->

    <!-- Pricing Section Begin -->
    <section class="pricing-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <div class="section-title normal-title">
                        <h3>Pilih Produk Wifi Kecepatan Anda!</h3>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                {{-- <div class="row justify-content-center">
                    @forelse ($products as $product)
                        <div class="col-12  col-md-4 col-sm-12 col-xs-12">
                            <div class="card " style="width: 300px; margin: 10px;">
                                <img src="{{ $product->productGallery->first()->url ?? 'Not Found!' }}"
                                    class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title font-weight-bold">{{ $product->name }}</h5>
                                </div>
                                <div class="card-footer"
                                    style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #ddd;">
                                    <h5 class="align-self-center font-weight-bold">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</h5>
                                    <button
                                        onclick="window.location.href='{{ route('landingPage.checkout.shipping', encrypt($product->id)) }}'"
                                        class="btn btn-primary rounded-pill font-weight-bold px-4 py-2">
                                        {{ __('Buy') }}
                                        <span class="fa fa-shopping-cart ml-2" style="font-size: 1.2em;"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p>No products available.</p>
                        </div>
                    @endforelse
                </div> --}}
                <div class="row">
                    @forelse ($products as $product)
                        <div class="col-md-4">
                            <figure class="card card-product-grid card-lg">
                                <a href="#" class="img-wrap" data-abc="true">
                                    <img src="{{ $product->productGallery->first()->url ?? 'Not Found!' }}"
                                        alt="{{ $product->name }}"></a>
                                <figcaption class="info-wrap">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <a href="#" class="title" data-abc="true">{{ $product->name }}</a>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="rating text-right">
                                                <i class="fa fa-star fa-star-color"></i>
                                                <i class="fa fa-star fa-star-color"></i>
                                                <i class="fa fa-star fa-star-color"></i>
                                            </div>
                                        </div>
                                    </div>
                                </figcaption>
                                <div class="bottom-wrap">
                                    <a href="{{ route('landingPage.checkout.shipping', encrypt($product->id)) }}"
                                        class="btn  btn-primary float-right" data-abc="true">
                                        <span class="fa fa-shopping-cart ml-2" style="font-size: 1.2em;"></span>
                                        Buy now </a>
                                    <div class="price-wrap">
                                        <span
                                            class="price h5">{{ 'Rp.' . number_format($product->price, 0, ',', '.') }}</span>
                                        <br> <small class="text-success">Gratis Ongkir</small>
                                    </div>
                                </div>
                            </figure>
                        </div>
                    @empty
                        <div class="d-flex justify-content-center">
                            <div class="alert alert-danger" role="alert">
                                <strong class="font-weight-bold">No products available.</strong>
                                <span>Please try a different search term.</span>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="row justify-content-center mt-4">
                    @if ($products->hasMorePages())
                        <div class="col-12 text-center">
                            <a class="btn btn-primary rounded-pill font-weight-bold px-4 py-2"
                                href="{{ route('landingPage.pricing') }}">
                                {{ __('More Products') }}
                            </a>
                            {{-- <a href="{{ $products->nextPageUrl() }}" class="btn btn-primary">{{ __('More Products') }}</a> --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Pricing Section End -->

    <!-- Achievement Section Begin -->
    <section class="achievement-section set-bg spad" data-setbg="{{ asset('landing_page/img/achievement-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="achievement__item">
                        <span class="fa fa-user-o"></span>
                        <h2 class="achieve-counter">{{ $users_customer_count ?? '0' }}</h2>
                        <p>Clients</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="achievement__item">
                        <span class="fa fa-wifi"></span>
                        <h2 class="achieve-counter">{{ $new_transaction ?? '0' }}</h2>
                        <p>Total Transaksi</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="achievement__item">
                        <span class="fa fa-check-circle"></span>
                        <h2 class="achieve-counter">{{ $total_amount_success ?? '0' }}</h2>
                        <p>Transaksi Sukses</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="achievement__item">
                        <span class="fa fa-dropbox"></span>
                        <h2 class="achieve-counter">{{ $total_product ?? '0' }}</h2>
                        <p>Total Produk</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Achievement Section End -->

    <!-- Work Section Begin -->
    <section class="work-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h3>TANAMKAN KEKUATAN KONEKSI WiFi YANG CEPAT DAN TERJAMIN</h3>
                    </div>
                    <div class="work__text">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="work__item">
                                    <i class="fa fa-wifi"></i>
                                    <span>NIKMATI KECEPATAN WiFi YANG MENGAGUMKAN</span>
                                    <h3>TANAMKAN KEKUATAN INTERNET SUPER CEPAT</h3>
                                    <p>Jelajahi, streaming, dan unduh dengan kecepatan tinggi menggunakan WiFi unggulan
                                        kami. Sampaikan selamat tinggal pada buffering dan lagging.</p>
                                    <a href="{{ route('landingPage.pricing') }}" class="primary-btn">Selengkapnya</a>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="work__item">
                                    <i class="fa fa-wifi"></i>
                                    <span>KENALI AL-N3T Support Getsitnet KAMI</span>
                                    <h3>TENTANG AL-N3T WiFi</h3>
                                    <p>AL-N3T Support Gesitnet adalah destinasi terbaik Anda untuk memenuhi kebutuhan
                                        jaringan nirkabel
                                        Anda. Kami menyediakan solusi WiFi yang handal dan berkualitas tinggi untuk rumah,
                                        bisnis, dan lingkungan publik. Dengan produk unggulan dan layanan profesional, kami
                                        membantu menghubungkan dunia digital Anda dengan koneksi yang stabil dan cepat.</p>
                                    <a href="{{ route('landingPage.about') }}" class="primary-btn">Selengkapnya</a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Work Section End -->


    @push('styles')
        <style>
            a {
                text-decoration: none !important;
            }

            .card-product-list,
            .card-product-grid {
                margin-bottom: 0;
            }

            .card {

                position: relative;
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 0.10rem;
                margin-top: 10px;



            }

            .card-product-grid:hover {
                -webkit-box-shadow: 0 4px 15px rgba(153, 153, 153, 0.3);
                box-shadow: 0 4px 15px rgba(153, 153, 153, 0.3);
                -webkit-transition: .3s;
                transition: .3s;
            }


            .card-product-grid .img-wrap {
                border-radius: 0.2rem 0.2rem 0 0;
                height: 220px;
            }


            .card .img-wrap {
                overflow: hidden;
            }

            .card-lg .img-wrap {
                height: 280px;
            }


            .card-product-grid .img-wrap {
                border-radius: 0.2rem 0.2rem 0 0;
                height: 228px;
                padding: 16px;
            }

            [class*='card-product'] .img-wrap img {
                height: 100%;
                max-width: 100%;
                width: auto;
                display: inline-block;
                -o-object-fit: cover;
                object-fit: cover;
            }

            .img-wrap {
                text-align: center;
                display: block;
            }

            .card-product-grid .info-wrap {
                overflow: hidden;
                padding: 18px 20px;
            }

            [class*='card-product'] a.title {
                color: #212529;
                display: block;
            }

            .rating-stars {
                display: inline-block;
                vertical-align: middle;
                list-style: none;
                margin: 0;
                padding: 0;
                position: relative;
                white-space: nowrap;
                clear: both;
            }


            .rating-stars li.stars-active {
                z-index: 2;
                position: absolute;
                top: 0;
                left: 0;
                overflow: hidden;
            }

            .rating-stars li {
                display: block;
                text-overflow: clip;
                white-space: nowrap;
                z-index: 1;
            }

            .card-product-grid .bottom-wrap {
                padding: 18px;
                border-top: 1px solid #e4e4e4;
            }

            .btn {
                display: inline-block;
                font-weight: 600;
                color: #343a40;
                text-align: center;
                vertical-align: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                background-color: transparent;
                border: 1px solid transparent;
                padding: 0.45rem 0.85rem;
                font-size: 1rem;
                line-height: 1.5;
                border-radius: 0.2rem;

            }

            .btn-primary {
                color: #fff;
                background-color: #3167eb;
                border-color: #3167eb;
            }

            .fa-star-color {
                color: #FF5722;
            }
        </style>
    @endpush

    @push('javascript')
        <script>
            $(document).ready(function() {
                $('#productSlider').slick({
                    slidesToShow: 4, // Jumlah kartu produk yang ditampilkan dalam satu baris
                    slidesToScroll: 1, // Jumlah kartu produk yang digeser saat tombol panah ditekan
                    autoplay: true, // Mengaktifkan autoplay untuk menggeser kartu produk secara otomatis
                    autoplaySpeed: 3000, // Kecepatan autoplay dalam milidetik
                    responsive: [{
                        breakpoint: 768, // Breakpoint untuk layar berlebar 768px
                        settings: {
                            slidesToShow: 1 // Jumlah kartu produk yang ditampilkan dalam satu baris pada breakpoint 768px
                        }
                    }]
                });
            });
        </script>
    @endpush
@endsection
