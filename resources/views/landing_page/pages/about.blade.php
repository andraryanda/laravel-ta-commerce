@extends('landing_page.layout_landing_page.app-landing-page')
@section('aboutLandingPage')
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

    <!-- About Section Begin -->
    <section class="about-section spad">
        <div class="container">
            {{-- @forelse ($landingPageAbout as $item)
            @empty
            @endforelse --}}

            <div class="row">
                @forelse ($landingPageAbout as $item)
                    <div class="col-lg-6">
                        <div class="about__img">
                            <img src="{{ Storage::url($item->image_about) }}" class="shadow rounded"
                                alt="{{ $item->id }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about__text">
                            <h2>{{ $item->title_about }}</h2>
                            <p>{{ $item->description_about }}</p>
                        @empty
                            <div class="col-lg-6">
                                <div class="about__img">
                                    <img src="{{ asset('landing_page/img/about-us.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="about__text">
                                    <h2>Welcom to Deerhost</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut
                                        labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus
                                        commodo
                                        viverra maecenas accumsan lacus vel facilisis.</p>
                @endforelse

                <div class="about__achievement">
                    <div class="about__achieve__item">
                        <span class="fa fa-user-o"></span>
                        <h4 class="achieve-counter">{{ $users_customer_count }}</h4>
                        <p>Clients</p>
                    </div>
                    <div class="about__achieve__item">
                        <span class="fa fa-wifi"></span>
                        <h4 class="achieve-counter">{{ $new_transaction }}</h4>
                        <p>Total Transaksi</p>
                    </div>
                    <div class="about__achieve__item">
                        <span class="fa fa-check-circle"></span>
                        <h4 class="achieve-counter">{{ $total_amount_success }}</h4>
                        <p>Transaksi Sukses</p>
                    </div>

                </div>
                <div class="about__achievement">

                    <div class="about__achieve__item">
                        <span class="fa fa-dropbox"></span>
                        <h4 class="achieve-counter">{{ $total_product }}</h4>
                        <p>Installs</p>
                    </div>
                </div>

                <a href="{{ route('landingPage.pricing') }}" class="primary-btn">Get started now</a>
            </div>
        </div>
        </div>

        {{-- <div class="row">
                <div class="col-lg-6">
                    <div class="about__img">
                        <img src="{{ asset('landing_page/img/about-us.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__text">
                        <h2>Welcom to Deerhost</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo
                            viverra maecenas accumsan lacus vel facilisis.</p>
                        <div class="about__achievement">
                            <div class="about__achieve__item">
                                <span class="fa fa-user-o"></span>
                                <h4 class="achieve-counter">2468</h4>
                                <p>Clients</p>
                            </div>
                            <div class="about__achieve__item">
                                <span class="fa fa-edit"></span>
                                <h4 class="achieve-counter">2468</h4>
                                <p>Domains</p>
                            </div>
                            <div class="about__achieve__item">
                                <span class="fa fa-clone"></span>
                                <h4 class="achieve-counter">2468</h4>
                                <p>Server</p>
                            </div>
                            <div class="about__achieve__item">
                                <span class="fa fa-cog"></span>
                                <h4 class="achieve-counter">2468</h4>
                                <p>Installs</p>
                            </div>
                        </div>
                        <a href="#" class="primary-btn">Get started now</a>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
    <!-- About Section End -->

    <!-- Feature Section Begin -->
    <section class="feature-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h3>Fitur AL-N3T WiFi</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($landingPageAboutFeature as $item)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="feature__item">
                            {{-- <span class="fa fa-wifi"></span> --}}
                            <img src="{{ Storage::url($item->image_about_feature) }}" alt="{{ $item->id }}"
                                class="rounded-circle" width="150">
                            <h5>{{ $item->title_about_feature }}</h5>
                            <p>{{ $item->description_about_feature }}</p>
                        </div>
                    </div>
                @empty

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="feature__item">
                            <span class="fa fa-wifi"></span>
                            <h5>Kecepatan Internet Tinggi</h5>
                            <p>Nikmati kecepatan internet tinggi dengan AL-N3T WiFi. Dapatkan pengalaman menjelajah
                                internet
                                yang lancar dan streaming video HD tanpa buffering.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="feature__item">
                            <span class="fa fa-wrench"></span>
                            <h5>Pemasangan Mudah</h5>
                            <p>AL-N3T WiFi dapat dipasang dengan mudah di perumahan Anda. Tim kami akan memastikan
                                pemasangan
                                yang cepat dan efisien, sehingga Anda dapat segera menikmati koneksi internet yang handal.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="feature__item">
                            <span class="fa fa-lock"></span>
                            <h5>Keamanan Terjamin</h5>
                            <p>Keamanan adalah prioritas kami. AL-N3T WiFi dilengkapi dengan fitur keamanan tingkat lanjut,
                                termasuk enkripsi data, proteksi terhadap serangan siber, dan pengamanan jaringan yang
                                ketat.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="feature__item">
                            <span class="fa fa-users"></span>
                            <h5>Koneksi Stabil untuk Banyak Pengguna</h5>
                            <p>AL-N3T WiFi dirancang untuk memberikan koneksi yang stabil dan konsisten, bahkan saat
                                digunakan
                                oleh banyak pengguna sekaligus. Nikmati konektivitas yang lancar tanpa terganggu oleh beban
                                penggunaan yang tinggi.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="feature__item">
                            <span class="fa fa-globe"></span>
                            <h5>Cakupan Luas</h5>
                            <p>Dengan AL-N3T WiFi, Anda dapat menikmati cakupan jaringan yang luas di seluruh perumahan
                                Anda.
                                Tidak perlu khawatir tentang sinyal lemah atau kehilangan koneksi di beberapa area.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="feature__item">
                            <span class="fa fa-life-ring"></span>
                            <h5>Dukungan Pelanggan 24/7</h5>
                            <p>Kami menyediakan dukungan pelanggan yang siap membantu Anda 24 jam sehari, 7 hari seminggu.
                                Tim
                                kami akan dengan senang hati menjawab pertanyaan dan menyelesaikan masalah terkait layanan
                                AL-N3T WiFi.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Team Section Begin -->
    <section class="team-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="section-title normal-title">
                        <h3>Tim AL-N3T Support Gesitnet</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($landingPageAboutTeam as $item)
                    <div class="col-lg-6 col-md-6">
                        <div class="team__item">
                            <div class="team__pic">
                                <img src="{{ Storage::url($item->image_people_team) }}" alt="{{ $item->id }}"
                                    width="100">
                            </div>
                            <div class="team__text">
                                <h5>{{ $item->name_people_team }}</h5>
                                <span>{{ $item->job_people_team }}</span>
                                <p>{{ $item->description_people_team }}</p>
                            </div>
                        </div>
                    </div>
                @empty

                    <div class="col-lg-6 col-md-6">
                        <div class="team__item">
                            <div class="team__pic">
                                <img src="{{ asset('landing_page/img/team/team-1.jpg') }}" alt="">
                            </div>
                            <div class="team__text">
                                <h5>Andi Susanto</h5>
                                <span>Pemilik</span>
                                <p>Merupakan pemilik dari AL-N3T Support Gesitnet. Bertanggung jawab dalam pengelolaan
                                    bisnis dan
                                    pengambilan
                                    keputusan strategis.</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="team__item">
                            <div class="team__pic">
                                <img src="{{ asset('landing_page/img/team/team-4.jpg') }}" alt="">
                            </div>
                            <div class="team__text">
                                <h5>Putri Purnama</h5>
                                <span>Admin</span>
                                <p>Bertugas dalam administrasi dan pengelolaan harian AL-N3T Support Gesitnet. Menangani
                                    tugas-tugas
                                    administratif dan koordinasi dengan tim lainnya.</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="team__item">
                            <div class="team__pic">
                                <img src="{{ asset('landing_page/img/team/team-3.jpg') }}" alt="">
                            </div>
                            <div class="team__text">
                                <h5>Dani Setiawan</h5>
                                <span>Teknisi</span>
                                <p>Bertanggung jawab dalam perawatan dan pemeliharaan infrastruktur jaringan AL-N3T Support
                                    Gesitnet.
                                    Menangani instalasi dan troubleshooting teknis.</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="team__item">
                            <div class="team__pic">
                                <img src="{{ asset('landing_page/img/team/team-2.jpg') }}" alt="">
                            </div>
                            <div class="team__text">
                                <h5>Aulia Rahman</h5>
                                <span>Teknisi</span>
                                <p>Bertugas dalam merancang dan mengembangkan desain visual untuk AL-N3T Support Gesitnet.
                                    Menangani
                                    tampilan
                                    dan pengalaman pengguna.</p>

                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Team Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h3>Ulasan Pelanggan Kami</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="testimonial__slider owl-carousel">
                    <div class="col-lg-4">
                        <div class="testimonial__item">
                            <img src="{{ asset('landing_page/img/testimonial/testimonial-1.jpg') }}" alt="">
                            <h5>Andi Susanto</h5>
                            <span>Pelanggan</span>
                            <p>Saya sangat senang menggunakan layanan AL-N3T WiFi. Koneksi yang stabil dan cepat membuat
                                pengalaman internet di rumah saya menjadi lebih baik. Tim dukungan pelanggan juga sangat
                                responsif dan membantu dengan setiap pertanyaan yang saya miliki. Sangat merekomendasikan
                                AL-N3T WiFi kepada semua orang!</p>
                            <div class="testimonial__rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial__item">
                            <img src="{{ asset('landing_page/img/testimonial/testimonial-2.jpg') }}" alt="">
                            <h5>Siti Rahayu</h5>
                            <span>Pelanggan</span>
                            <p>AL-N3T WiFi adalah pilihan terbaik untuk koneksi internet di perumahan. Kualitas layanan
                                yang luar biasa dan harga yang terjangkau. Saya sangat puas dengan kecepatan internet yang
                                stabil dan customer service yang ramah. Tidak ada lagi masalah buffering saat streaming film
                                favorit saya!</p>
                            <div class="testimonial__rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial__item">
                            <img src="{{ asset('landing_page/img/testimonial/testimonial-3.jpg') }}" alt="">
                            <h5>Budi Santoso</h5>
                            <span>Pelanggan</span>
                            <p>Saya sangat terkesan dengan kehandalan dan kecepatan koneksi AL-N3T WiFi. Tidak ada lagi
                                gangguan atau lambatnya internet di perumahan kami. Tim teknis juga sangat profesional dan
                                memberikan layanan yang memuaskan. Terima kasih AL-N3T WiFi!</p>
                            <div class="testimonial__rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Testimonial Section End -->
@endsection
