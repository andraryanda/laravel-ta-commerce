@extends('landing_page.layout_landing_page.app-landing-page')
@section('indexLandingPage')
    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hero__slider owl-carousel">
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
                                <h2>Welcome to the best<br /> Toko Kami Networking</h2>
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
                            <h3>Join To Networking WiFi!</h3>
                        </div>
                        {{-- <div class="register__form">
                            <form action="#">
                                <input type="text" placeholder="ex: cloudhost">
                                <div class="change__extension">
                                    .com
                                    <ul>
                                        <li>.net</li>
                                        <li>.org</li>
                                        <li>.me</li>
                                    </ul>
                                </div>
                                <button type="submit" class="site-btn">Search</button>
                            </form>
                        </div> --}}
                        <div class="register__result">
                            <ul>
                                <li>1 <span>Mbps</span></li>
                                <li>2 <span>Mbps</span></li>
                                <li>3 <span>Mbps</span></li>
                                <li>4 <span>Mbps</span></li>
                                <li>5 <span>Mbps</span></li>
                            </ul>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</p>
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
                        <h3>Choose the right hosting solution</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="services__item">
                        <h5>Shared Hosting</h5>
                        <span>Starts At $1.84</span>
                        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="services__item">
                        <h5>IndiHome</h5>
                        <span>Starts At $1.84</span>
                        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="services__item">
                        <h5>Dedicated Hosting</h5>
                        <span>Starts At $1.84</span>
                        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                {{-- <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="services__item">
                        <h5>SSL certificate</h5>
                        <span>Starts At $1.84</span>
                        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="services__item">
                        <h5>Web Hosting</h5>
                        <span>Starts At $1.84</span>
                        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="services__item">
                        <h5>Cloud server</h5>
                        <span>Starts At $1.84</span>
                        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div> --}}
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
                        <h3>Choose your plan</h3>
                    </div>
                </div>
                {{-- <div class="col-lg-5 col-md-5">
                    <div class="pricing__swipe-btn">
                        <label for="month" class="active">Monthly
                            <input type="radio" id="month">
                        </label>
                        <label for="yearly">Yearly
                            <input type="radio" id="yearly">
                        </label>
                    </div>
                </div> --}}
            </div>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    @forelse ($products as $product)
                        <div class="col-12  col-md-4 col-sm-12 col-xs-12">
                            <div class="card " style="width: 300px; margin: 10px;">
                                <img src="{{ $product->productGallery->first()->url ?? 'Not Found!' }}" class="card-img-top"
                                    alt="{{ $product->name }}">
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
                        <span class="fa fa-edit"></span>
                        <h2 class="achieve-counter">{{ $new_transaction ?? '0' }}</h2>
                        <p>Total Transaksi</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="achievement__item">
                        <span class="fa fa-clone"></span>
                        <h2 class="achieve-counter">{{ $total_amount_success ?? '0' }}</h2>
                        <p>Transaksi Sukses</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="achievement__item">
                        <span class="fa fa-cog"></span>
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
                        <h3>HOW TO BUILD YOUR WEBSITE ONLINE TODAY?</h3>
                    </div>
                    <div class="work__text">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="work__item">
                                    <i class="fa fa-desktop"></i>
                                    <span>CREATE YOUR OWN WEBSITE WITH OUR</span>
                                    <h3>WEB SITE BUILDER</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices
                                        gravida facilisis. </p>
                                    <a href="#" class="primary-btn">Read More</a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="work__item">
                                    <i class="fa fa-shopping-bag"></i>
                                    <span>EASY CREATE, MANAGE & SELL</span>
                                    <h3>ONLINE STORE</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices
                                        gravida facilisis. </p>
                                    <a href="#" class="primary-btn">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Work Section End -->

    <!-- Choose Plan Section Begin -->
    <section class="choose-plan-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <img src="{{ asset('landing_page/img/choose-plan.png') }}" alt="">
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="plan__text">
                        <h3>up to 70% discount with free domain name registration included!</h3>
                        <ul>
                            <li><span class="fa fa-check"></span> FREE Domain Name</li>
                            <li><span class="fa fa-check"></span> FREE Email Address</li>
                            <li><span class="fa fa-check"></span> Plently of disk space</li>
                            <li><span class="fa fa-check"></span> FREE Website Bullder</li>
                            <li><span class="fa fa-check"></span> FREE Marketing Tools</li>
                            <li><span class="fa fa-check"></span> 1-Click WordPress Install</li>
                        </ul>
                        <a href="#" class="primary-btn">Get start now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Choose Plan Section End -->

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
