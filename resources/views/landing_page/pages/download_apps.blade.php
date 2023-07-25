@extends('landing_page.layout_landing_page.app-landing-page')
@section('contactLandingPage')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__option">
                        <a href="{{ route('landingPage.index') }}"><span class="fa fa-home"></span> Home</a>
                        <span>Download Aplikasi Al-N3T</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">

                <div class="container">
                    <div class="jumbotron text-center">
                        <img src="nama-file-gambar.jpg" alt="Deskripsi Gambar" class="img-fluid">
                        <h1 class="display-4 mt-4">Selamat datang di Al-N3T!</h1>
                        <p class="lead">Platform inovatif untuk mempercepat pertumbuhan bisnis Anda.</p>
                        <a href="{{ asset('aplikasi-commerce-mobile/alnet.apk') }}" download="alnet.apk"
                            class="btn btn-primary btn-lg">Download Aplikasi</a>

                    </div>
                </div>


            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    @push('styles')
        <style>
            .jumbotron {
                background-color: transparent;
            }
        </style>
    @endpush
@endsection
