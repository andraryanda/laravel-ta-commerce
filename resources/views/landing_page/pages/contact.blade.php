@extends('landing_page.layout_landing_page.app-landing-page')
@section('contactLandingPage')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__option">
                        <a href="{{ route('landingPage.index') }}"><span class="fa fa-home"></span> Home</a>
                        <span>Contact</span>
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
                @forelse ($landingPageContact as $item)
                    <div class="col-lg-4">
                        <div class="contact__text">
                            <h3>{{ $item->title_contact }}</h3>
                            <p>{{ $item->description_contact }}</p>
                            <ul>
                                <li>
                                    <span class="fa fa-map-marker"></span>
                                    <h5>Alamat</h5>
                                    <p>{{ $item->address_contact }}</p>
                                </li>
                                <li>
                                    <span class="fa fa-mobile"></span>
                                    <h5>Nomor Handphone</h5>
                                    <p>{{ $item->phone_contact }}</p>
                                </li>
                                <li>
                                    <span class="fa fa-headphones"></span>
                                    <h5>Email</h5>
                                    <p>{{ $item->email_contact }}</p>
                                </li>
                            </ul>
                            <div class="contact__social">
                                <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                                <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                                <a href="#" class="youtube"><i class="fa fa-youtube-play"></i></a>
                                <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-4">
                        <div class="contact__text">
                            <h3>Contact info</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                labore et dolore magna aliqua.</p>
                            <ul>
                                <li>
                                    <span class="fa fa-map-marker"></span>
                                    <h5>Address</h5>
                                    <p>160 Pennsylvania Ave NW, Washington Castle, PA 16101-5161</p>
                                </li>
                                <li>
                                    <span class="fa fa-mobile"></span>
                                    <h5>Address</h5>
                                    <p>125-711-811 | 125-668-886</p>
                                </li>
                                <li>
                                    <span class="fa fa-headphones"></span>
                                    <h5>Address</h5>
                                    <p>Support.photography@gmail.com</p>
                                </li>
                            </ul>
                            <div class="contact__social">
                                <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                                <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                                <a href="#" class="youtube"><i class="fa fa-youtube-play"></i></a>
                                <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                @endforelse

                <div class="col-lg-8">
                    <div class="map">
                        {{-- <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15838.158586401088!2d108.446899!3d-6.463941!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e688b8cc3d2f7eb%3A0x9c1c6f54323fe902!2sKarangampel%2C%20Indramayu%20Regency%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1624051560154!5m2!1sen!2sid"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe> --}}
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!4v1689772876118!6m8!1m7!1sB3aIg6L7QMfRGCP6_k-nhw!2m2!1d-6.456124483221121!2d108.3988146178506!3f263.8128239747266!4f28.25372490156701!5f0.7820865974627469"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                        {{-- <iframe
                            src="{{ url('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d20151.047591375514!2d-0.5735782106784704!3d50.85188881113048!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4875a4d10c96d8bf%3A0xe9a76e70e6b7cc5a!2sArundel%2C%20UK!5e0!3m2!1sen!2sbd!4v1584862449435!5m2!1sen!2sbd') }}"
                            height="515" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->
@endsection
