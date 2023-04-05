<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Deerhost Template">
    <meta name="keywords" content="Deerhost, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DEERHOST | Template</title>

    @include('landing_page.layout_landing_page.partials.style.css')
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    {{-- Body/Halaman Landing Page --}}
    @include('landing_page.layout_landing_page.components.navbar')

    @yield('indexLandingPage')
    @yield('aboutLandingPage')
    @yield('hostingLandingPage')
    @yield('contactLandingPage')
    @yield('pricingLandingPage')
    {{-- @include('landing_page.layout_landing_page.components.body') --}}
    {{-- End Landing Page --}}

    <!-- Footer Section Begin -->
    @include('landing_page.layout_landing_page.components.footer')
    <!-- Footer Section End -->

    @include('landing_page.layout_landing_page.partials.javascript.js')
</body>

</html>
