<footer class="footer-section">
    <div class="footer__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="footer__top-call">
                        <h5>Butuh Bantuan? Hubungi kami segera!</h5>
                        @forelse ($landingPageContact as $item)
                            <h2>{{ $item->phone_contact }}</h2>

                        @empty
                            +1 175 946 2316 096
                        @endforelse
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="footer__top-auth">
                        <h5>Mari bergabung dengan kami</h5>
                        @if (Route::has('login'))
                            @auth
                                {{-- <li> --}}
                                @if (Auth::user()->roles == 'ADMIN' || Auth::user()->roles == 'OWNER')
                                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-action rounded-pill"
                                        class="primary-btn"><span class="fa fa-home"></span>
                                        {{ __('Dashboard') }}
                                    </a>
                                @elseif (Auth::user()->roles == 'USER')
                                    <a href="{{ url('/dashboardCustomer') }}"
                                        class="btn btn-primary btn-action rounded-pill" class="primary-btn"><span
                                            class="fa fa-home"></span>
                                        {{ __('Dashboard') }}
                                    </a>
                                @else
                                    <span class="btn btn-danger btn-action rounded-pill">Not Found</span>
                                @endif
                                {{-- </li> --}}
                            @else
                                {{-- <li> --}}
                                <a href="{{ route('login') }}" class="primary-btn"><span class="fa fa-key"></span>
                                    {{ __('Login') }}
                                </a>
                                {{-- </li> --}}
                                @if (Route::has('register'))
                                    {{-- <li> --}}
                                    <a href="{{ route('register') }}" class="primary-btn sign-up"><span
                                            class="fa fa-user"></span>
                                        {{ __('Register') }}
                                    </a>
                                    {{-- </li> --}}
                                @endif
                            @endauth
                        @endif
                        {{-- <a href="{{ route('login') }}" class="primary-btn">Log in</a>
                        <a href="{{ route('register') }}" class="primary-btn sign-up">Sign Up</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__text set-bg" data-setbg="{{ asset('landing_page/img/footer-bg.png') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="footer__text-about">
                        <div class="footer__logo">
                            <a href="/">
                                {{-- <img src="{{ asset('landing_page/img/logo.png') }}" alt=""> --}}
                                <h4 class="text-light" style="font-weight: bold;">
                                    {{ __('AL-N3T Support Gesitnet') }}
                                </h4>
                            </a>
                        </div>
                        <p style="text-align: justify;">AL-N3T Support Gesitnet adalah destinasi terbaik Anda untuk
                            memenuhi kebutuhan jaringan
                            nirkabel Anda. Kami menyediakan solusi WiFi yang handal dan berkualitas tinggi untuk rumah,
                            bisnis, dan lingkungan publik. Dengan produk unggulan dan layanan profesional, kami membantu
                            menghubungkan dunia digital Anda dengan koneksi yang stabil dan cepat. </p>
                        {{-- <div class="footer__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="footer__text-widget">
                        <h5>Company</h5>
                        <ul>
                            <li><a href="{{ route('landingPage.index') }}">Home</a></li>
                            <li><a href="{{ route('landingPage.about') }}">About Us</a></li>
                            <li><a href="{{ route('landingPage.pricing') }}">Produk</a></li>
                            <li><a href="{{ route('landingPage.contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="footer__text-widget">
                        <h5>Produk List 5</h5>
                        <ul>
                            @forelse ($products->take(5) as $product)
                                <li><a
                                        href="{{ route('landingPage.checkout.shipping', encrypt($product->id)) }}">{{ $product->name }}</a>
                                </li>
                            @empty
                                <p>No products found.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="footer__text-widget">
                        <h5>CONTACT US</h5>
                        <ul class="footer__widget-info">
                            @forelse ($landingPageContact as $item)
                                <li><span class="fa fa-map-marker"></span> {!! $item->address_contact !!}</li>
                                <li><span class="fa fa-mobile"></span> {{ $item->phone_contact }}</li>
                                <li><span class="fa fa-headphones"></span> {{ $item->email_contact }}</li>

                            @empty
                                <li><span class="fa fa-map-marker"></span> 500 South Main Street Los Angeles,<br />
                                    ZZ-96110 USA</li>
                                <li><span class="fa fa-mobile"></span> 125-711-811 | 125-668-886</li>
                                <li><span class="fa fa-headphones"></span> Support.hosting@gmail.com</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            {{-- <div class="footer__text-copyright">
                <p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | This template is made with <i class="fa fa-heart"
                        aria-hidden="true"></i> by <a href="{{ url('https://colorlib.com') }}"
                        target="_blank">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
            </div> --}}
        </div>
    </div>
</footer>
