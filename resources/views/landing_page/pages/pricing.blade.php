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
    <section class="pricing-section spad">
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

            {{-- Back Begin --}}
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

            {{-- Back end --}}
            {{-- Search Begin --}}
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

            {{-- Search End --}}

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
                    {{-- {{ $products->links('pagination::bootstrap-4') }} --}}
                    @if ($products->lastPage() > 1)
                        <ul class="pagination ml-3 mb-0 justify-content-center">
                            <!-- tambahkan class justify-content-center -->
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
    </section>
    <!-- Pricing Section End -->



    @push('styles')
        <style>
            .card {
                transition: transform 0.3s ease-in-out;
            }

            .card:hover {
                transform: scale(1.05);
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
@endsection
