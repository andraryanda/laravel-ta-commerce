 {{-- <!-- Offcanvas Menu Begin -->
 <div class="offcanvas__menu__overlay"></div>
 <div class="offcanvas__menu__wrapper">
     <div class="canvas__close">
         <span class="fa fa-times-circle-o"></span>
     </div>
     <div class="offcanvas__logo">
         <a href="#"><img src="{{ asset('landing_page/img/logo.png') }}" alt=""></a>
     </div>
     <nav class="offcanvas__menu mobile-menu">
         <ul>
             <li class="active"><a href="./index.html">Home</a></li>
             <li><a href="./about.html">About</a></li>
             <li><a href="./hosting.html">Hosting</a></li>
             <li><a href="#">Pages</a>
                 <ul class="dropdown">
                     <li><a href="./pricing.html">Pricing</a></li>
                     <li><a href="./blog-details.html">Blog Details</a></li>
                     <li><a href="./404.html">404</a></li>
                 </ul>
             </li>
             <li><a href="./blog.html">News</a></li>
             <li><a href="./contact.html">Contact</a></li>
         </ul>
     </nav>
     <div id="mobile-menu-wrap"></div>
     <div class="offcanvas__auth">
         <ul>
             <li><a href="#"><span class="icon_chat_alt"></span> Live chat</a></li>
             <li><a href="#"><span class="fa fa-user"></span> Login / Register</a></li>
         </ul>
     </div>
     <div class="offcanvas__info">
         <ul>
             <li><span class="icon_phone"></span> +1 123-456-7890</li>
             <li><span class="fa fa-envelope"></span> Support@gmail.com</li>
         </ul>
     </div>
 </div>
 <!-- Offcanvas Menu End -->

 <!-- Header Section Begin -->
 <header class="header-section">
     <div class="header__info">
         <div class="container">
             <div class="row">
                 <div class="col-lg-6 col-md-6">
                     <div class="header__info-left">
                         <ul>
                             <li><span class="icon_phone"></span> +1 123-456-7890</li>
                             <li><span class="fa fa-envelope"></span> Support@gmail.com</li>
                         </ul>
                     </div>
                 </div>
                 <div class="col-lg-6 col-md-6">
                     <div class="header__info-right">
                         <ul>
                             <li><a href="#"><span class="icon_chat_alt"></span> Live chat</a></li>
                             <li><a href="#"><span class="fa fa-user"></span> Login / Register</a></li>
                         </ul>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="container">
         <div class="row">
             <div class="col-lg-3 col-md-3">
                 <div class="header__logo">
                     <a href="./index.html"><img src="{{ asset('landing_page/img/logo.png') }}" alt=""></a>
                 </div>
             </div>
             <div class="col-lg-9 col-md-9">
                 <nav class="header__menu">
                     <ul>
                         <li class="{{ Request::routeIs('landingPage.index') ? 'active' : '' }}"><a
                                 href="{{ route('landingPage.index') }}">Home</a></li>
                         <li class="{{ Request::routeIs('landingPage.about') ? 'active' : '' }}"><a
                                 href="{{ route('landingPage.about') }}">About</a></li>
                         <li><a href="./hosting.html">Hosting</a></li>
                         <li><a href="#">Pages</a>
                             <ul class="dropdown">
                                 <li><a href="./pricing.html">Pricing</a></li>
                                 <li><a href="./blog-details.html">Blog Details</a></li>
                                 <li><a href="./404.html">404</a></li>
                             </ul>
                         </li>
                         <li><a href="./blog.html">News</a></li>
                         <li><a href="./contact.html">Contact</a></li>
                     </ul>
                 </nav>
             </div>
         </div>
         <div class="canvas__open">
             <span class="fa fa-bars"></span>
         </div>
     </div>
 </header>
 <!-- Header End --> --}}

 <!-- Offcanvas Menu Begin -->
 <div class="offcanvas__menu__overlay"></div>
 <div class="offcanvas__menu__wrapper">
     <div class="canvas__close">
         <span class="fa fa-times-circle-o"></span>
     </div>
     <div class="offcanvas__logo">
         <a href="{{ route('landingPage.index') }}"><img src="{{ asset('landing_page/img/logo.png') }}" alt=""></a>
     </div>
     <nav class="offcanvas__menu mobile-menu">
         <ul>
             <li class="{{ Request::routeIs('landingPage.index') ? 'active' : '' }}"><a
                     href="{{ route('landingPage.index') }}">Home</a></li>
             <li class="{{ Request::routeIs('landingPage.about') ? 'active' : '' }}"><a
                     href="{{ route('landingPage.about') }}">About</a></li>
             <li class="{{ Request::routeIs('landingPage.hosting') ? 'active' : '' }}"><a
                     href="{{ route('landingPage.hosting') }}">Hosting</a></li>
             <li><a href="#">Pages</a>
                 <ul class="dropdown">
                     <li class="{{ Request::routeIs('landingPage.pricing') ? 'bg-primary col-md-12' : '' }}">
                         <a href="{{ route('landingPage.pricing') }}"
                             class="{{ Request::routeIs('landingPage.pricing') ? 'text-white' : '' }}">Pricing</a>
                     </li>
                     <li><a href="./blog-details.html">Blog Details</a></li>
                 </ul>
             </li>
             <li><a href="./blog.html">News</a></li>
             <li class="{{ Request::routeIs('landingPage.contact') ? 'active' : '' }}"><a
                     href="{{ route('landingPage.contact') }}">Contact</a></li>
         </ul>
     </nav>
     <div id="mobile-menu-wrap"></div>
     <div class="offcanvas__auth">
         <ul>
             <li><a href="#"><span class="fa fa-money"></span> Keranjang Shopping</a></li>
             @if (Route::has('login'))
                 @auth
                     <li>
                         <a href="{{ url('/dashboard') }}"><span class="fa fa-home"></span>
                             {{ __('Dashboard') }}
                         </a>
                     </li>
                 @else
                     <li>
                         <a href="{{ route('login') }}"><span class="fa fa-key"></span>
                             {{ __('Login') }}
                         </a>
                     </li>
                     @if (Route::has('register'))
                         <li>
                             <a href="{{ route('register') }}" class="btn btn-danger btn-action rounded-pill"><span
                                     class="fa fa-user"></span>
                                 {{ __('Register') }}
                             </a>
                         </li>
                     @endif
                 @endauth
             @endif
         </ul>
     </div>
     <div class="offcanvas__info">
         <ul>
             <li><span class="icon_phone"></span> +1 123-456-7890</li>
             <li><span class="fa fa-envelope"></span> Support@gmail.com</li>
         </ul>
     </div>
 </div>
 <!-- Offcanvas Menu End -->

 <!-- Header Section Begin -->
 <header class="header-section header-normal">
     <div class="header__info">
         <div class="container">
             <div class="row">
                 <div class="col-lg-6 col-md-6">
                     <div class="header__info-left">
                         <ul>
                             <li><span class="icon_phone"></span> +1 123-456-7890</li>
                             <li><span class="fa fa-envelope"></span> Support@gmail.com</li>
                         </ul>
                     </div>
                 </div>
                 <div class="col-lg-6 col-md-6">
                     <div class="header__info-right">
                         <ul>
                             <li>
                                 <a href="{{ route('dashboard.transactionCustomer.index') }}">
                                     <span class="fa fa-shopping-cart ml-2" style="font-size: 1.2em;"></span>
                                     {{ __('Keranjang Shopping') }}
                                     @if (Auth::user())
                                         <span
                                             class="absolute -top-2 left-4 rounded-full bg-danger p-0.5 px-1 ml-2 text-sm text-red-50 font-weight-bold">
                                             {{ $total_pending_count ?? '' }}
                                         </span>
                                     @endif
                                 </a>
                             </li>
                             @if (Route::has('login'))
                                 @auth
                                     <li>
                                         @if (Auth::user()->roles == 'ADMIN')
                                             <a href="{{ url('/dashboard') }}"
                                                 class="btn btn-primary btn-action rounded-pill"><span
                                                     class="fa fa-home"></span>
                                                 {{ __('Dashboard') }}
                                             </a>
                                         @elseif (Auth::user()->roles == 'USER')
                                             <a href="{{ url('/dashboardCustomer') }}"
                                                 class="btn btn-primary btn-action rounded-pill"><span
                                                     class="fa fa-home"></span>
                                                 {{ __('Dashboard') }}
                                             </a>
                                         @else
                                             <span class="btn btn-danger btn-action rounded-pill">Not Found</span>
                                         @endif
                                     </li>
                                 @else
                                     <li>
                                         <a href="{{ route('login') }}"><span class="fa fa-key"></span>
                                             {{ __('Login') }}
                                         </a>
                                     </li>
                                     @if (Route::has('register'))
                                         <li>
                                             <a href="{{ route('register') }}"
                                                 class="btn btn-danger btn-action rounded-pill"><span
                                                     class="fa fa-user"></span>
                                                 {{ __('Register') }}
                                             </a>
                                         </li>
                                     @endif
                                 @endauth
                             @endif
                         </ul>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="container">
         <div class="row">
             <div class="col-lg-3 col-md-3">
                 <div class="header__logo">
                     <a href="{{ route('landingPage.index') }}"><img src="{{ asset('landing_page/img/logo.png') }}"
                             alt=""></a>
                 </div>
             </div>
             <div class="col-lg-9 col-md-9">
                 <nav class="header__menu ">
                     <ul>
                         <li class="{{ Request::routeIs('landingPage.index') ? 'active' : '' }}"><a
                                 href="{{ route('landingPage.index') }}">Home</a></li>
                         <li class="{{ Request::routeIs('landingPage.about') ? 'active' : '' }}"><a
                                 href="{{ route('landingPage.about') }}">About</a></li>
                         <li class="{{ Request::routeIs('landingPage.hosting') ? 'active' : '' }}"><a
                                 href="{{ route('landingPage.hosting') }}">Hosting</a></li>
                         <li class="{{ Request::routeIs('landingPage.pricing') ? 'active' : '' }}"><a
                                 href="#">Pages</a>
                             <ul class="dropdown">
                                 <li
                                     class="{{ Request::routeIs('landingPage.pricing') ? 'bg-primary col-md-12' : '' }}">
                                     <a href="{{ route('landingPage.pricing') }}"
                                         class="{{ Request::routeIs('landingPage.pricing') ? 'text-white' : '' }}">Pricing</a>
                                 </li>
                                 <li><a href="./blog-details.html">Blog Details</a></li>
                             </ul>
                         </li>
                         <li><a href="./blog.html">News</a></li>
                         <li class="{{ Request::routeIs('landingPage.contact') ? 'active' : '' }}"><a
                                 href="{{ route('landingPage.contact') }}">Contact</a></li>
                     </ul>
                 </nav>
             </div>
         </div>
         <div class="canvas__open">
             <span class="fa fa-bars"></span>
         </div>
     </div>
 </header>
 <!-- Header End -->
