<footer class="footer-section">
    <div class="footer__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="footer__top-call">
                        <h5>Butuh Bantuan? Hubungi kami segera!</h5>
                        <h2>+1 175 946 2316 096</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="footer__top-auth">
                        <h5>Mari bergabung dengan kami</h5>
                        <a href="{{ route('login') }}" class="primary-btn">Log in</a>
                        <a href="{{ route('register') }}" class="primary-btn sign-up">Sign Up</a>
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
                            <a href="./index.html"><img src="{{ asset('landing_page/img/logo.png') }}"
                                    alt=""></a>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida viverra maecen
                            lacus vel facilisis. </p>
                        <div class="footer__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-youtube-play"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </div>
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
                            <li><a href="#">Web Hosting</a></li>
                            <li><a href="#">Reseller Hosting</a></li>
                            <li><a href="#">VPS Hosting</a></li>
                            <li><a href="#">Dedicated Servers</a></li>
                            <li><a href="#">Cloud Hosting</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="footer__text-widget">
                        <h5>cONTACT US</h5>
                        <ul class="footer__widget-info">
                            <li><span class="fa fa-map-marker"></span> 500 South Main Street Los Angeles,<br />
                                ZZ-96110 USA</li>
                            <li><span class="fa fa-mobile"></span> 125-711-811 | 125-668-886</li>
                            <li><span class="fa fa-headphones"></span> Support.hosting@gmail.com</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer__text-copyright">
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
            </div>
        </div>
    </div>
</footer>
