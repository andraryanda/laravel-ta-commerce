<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('AL-N3T Support Gesitnet') }}</title>
    {{-- <title>{{ __('Als Store RT/RW NET') }}</title> --}}

    <link rel="shortcut icon" href="{{ asset('logo/alnet.jpg') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">



    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.css') }}" rel="stylesheet" />
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>

    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js') }}"></script>
</body>

</html>
