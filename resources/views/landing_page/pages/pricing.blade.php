@extends('landing_page.layout_landing_page.app-landing-page')
@section('pricingLandingPage')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__option">
                        <a href="{{ route('landingPage.index') }}"><span class="fa fa-home"></span> Home</a>
                        @php
                            $segments = Request::segments();
                            $url = '';
                        @endphp
                        @foreach ($segments as $segment)
                            @php
                                $url .= '/' . $segment;
                                $name = str_replace('-', ' ', $segment);
                                $name = ucwords($name);
                            @endphp
                            @if ($loop->last)
                                <span>{{ $name }}</span>
                            @else
                                <a href="">{{ $name }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Breadcrumb End -->
    <!-- Pricing Section Begin -->
    {{-- <section class="pricing-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <div class="section-title normal-title">
                        @if (request()->has('q'))
                            <h3>Hasil pencarian untuk "{{ request('q') }}"</h3>
                        @else
                            <h3>Choose your product</h3>
                        @endif
                    </div>
                </div>
            </div>
            @if (request()->has('q'))
                <div class="my-3">
                    <a href="{{ route('landingPage.pricing') }}" class="btn btn-purple my-1.5 mr-2 text-white rounded-pill">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('icon/left.png') }}" class="mr-2 bg-white rounded-circle" alt="Back"
                                width="25">
                            <p class="m-0">Back</p>
                        </div>
                    </a>
                </div>
            @endif

            <div class="d-flex justify-content-center mb-5 shadow">
                <form action="{{ route('landingPage.pricingCustomer.searchProductLandingPageCustomer') }}" method="GET"
                    class="w-100 max-w-lg">
                    <div class="input-group">
                        <input type="search" name="q"
                            class="form-control py-2 px-3 text-sm text-gray-900 bg-white rounded-md focus:outline-none focus:bg-white focus:text-gray-900"
                            placeholder="Search..." autocomplete="off">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary px-4 py-2.5">
                                <span class="fa fa-search"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>


            <div class="container-fluid">
                <div class="row justify-content-center d-flex">
                    @forelse ($products as $product)
                        <div class="col-lg-3 col-md-6 col-sm-12 d-flex justify-content-center">
                            <div class="card mb-3" width="300">
                                <img src="{{ $product->productGallery->first()->url ?? 'Not Found!' }}" class="card-img-top"
                                    alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title font-weight-bold">{{ $product->name }}</h5>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center border-top">
                                    <div class="price align-self-center">
                                        <p class="font-weight-bold m-0" style="font-size: 16px;">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <button
                                        onclick="window.location.href='{{ route('landingPage.checkout.shipping', encrypt($product->id)) }}'"
                                        class="btn btn-primary rounded-pill font-weight-bold px-3 py-2"
                                        style="font-size: 13px;">
                                        {{ __('Buy') }}
                                        <span class="fa fa-shopping-cart ml-2" style="font-size: 1.2em;"></span>
                                    </button>
                                </div>
                            </div>
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

                <div class="d-flex justify-content-between my-3">
                    <div class="text-muted">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                        {{ $products->total() }} results
                    </div>
                    @if ($products->lastPage() > 1)
                        <ul class="pagination ml-3 mb-0 justify-content-center">
                            <li class="page-item mx-2 {{ $products->currentPage() == 1 ? ' disabled' : '' }}">
                                <a class="page-link rounded-pill" href="{{ $products->url(1) }}">First</a>
                            </li>
                            @for ($i = 1; $i <= $products->lastPage(); $i++)
                                <li class="page-item mx-2 {{ $products->currentPage() == $i ? ' active' : '' }}">
                                    <a class="page-link rounded-pill"
                                        href="{{ $products->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                            <li
                                class="page-item mx-2 {{ $products->currentPage() == $products->lastPage() ? ' disabled' : '' }}">
                                <a class="page-link rounded-pill"
                                    href="{{ $products->url($products->lastPage()) }}">Last</a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section> --}}
    <!-- Pricing Section End -->





    <div class="container mb-5 mt-5">
        <div class="row">
            <div class="col-lg-7 col-md-7">
                <div class="section-title normal-title">
                    @if (request()->has('q'))
                        <h3>Hasil pencarian untuk "{{ request('q') }}"</h3>
                    @else
                        <h3>Choose your product</h3>
                    @endif
                </div>
            </div>
        </div>
        @if (request()->has('q'))
            <div class="my-3">
                <a href="{{ route('landingPage.pricing') }}" class="btn btn-purple my-1.5 mr-2 text-white rounded-pill">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('icon/left.png') }}" class="mr-2 bg-white rounded-circle" alt="Back"
                            width="25">
                        <p class="m-0">Back</p>
                    </div>
                </a>
            </div>
        @endif

        <div class="d-flex justify-content-center mb-5 shadow">
            <form action="{{ route('landingPage.pricingCustomer.searchProductLandingPageCustomer') }}" method="GET"
                class="w-100 max-w-lg">
                <div class="input-group">
                    <input type="search" name="q"
                        class="form-control py-2 px-3 text-sm text-gray-900 bg-white rounded-md focus:outline-none focus:bg-white focus:text-gray-900"
                        placeholder="Search..." autocomplete="off">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary px-4 py-2.5">
                            <span class="fa fa-search"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

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
                                <span class="price h5">{{ 'Rp.' . number_format($product->price, 0, ',', '.') }}</span>
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
        <div class="d-flex justify-content-between my-3">
            <div class="text-muted">
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                {{ $products->total() }} results
            </div>
            @if ($products->lastPage() > 1)
                <ul class="pagination ml-3 mb-0 justify-content-center">
                    <li class="page-item mx-2 {{ $products->currentPage() == 1 ? ' disabled' : '' }}">
                        <a class="page-link rounded-pill" href="{{ $products->url(1) }}">First</a>
                    </li>
                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                        <li class="page-item mx-2 {{ $products->currentPage() == $i ? ' active' : '' }}">
                            <a class="page-link rounded-pill" href="{{ $products->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item mx-2 {{ $products->currentPage() == $products->lastPage() ? ' disabled' : '' }}">
                        <a class="page-link rounded-pill" href="{{ $products->url($products->lastPage()) }}">Last</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('owlcarousel/dist/assets/owl.carousel.min.css') }}">
        <style>
            .product-card {
                opacity: 0;
                transform: scale(0.9);
                transition: opacity 0.3s ease, transform 0.3s ease;
            }

            .owl-carousel .owl-item.active .product-card {
                opacity: 1;
                transform: scale(1);
            }
        </style>

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

        <style>
            .btn-purple {
                background-color: #7f00ff;
                color: #fff;
                border-color: #7f00ff;
            }

            .btn-purple:hover {
                background-color: #6400e4;
                color: #fff;
                border-color: #6400e4;
            }

            .btn-purple:focus,
            .btn-purple.focus {
                box-shadow: 0 0 0 0.2rem rgba(127, 0, 255, 0.5);
            }

            .btn-purple.disabled,
            .btn-purple:disabled {
                background-color: #7f00ff;
                color: #fff;
                border-color: #7f00ff;
            }
        </style>
    @endpush

    @push('javascript')
        <script src="{{ asset('owlcarousel/dist/owl.carousel.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('.owl-carousel').owlCarousel();
            });
        </script>
    @endpush
@endsection
