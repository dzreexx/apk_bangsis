<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheet -->
    <link href="{{ asset('../css/vendor/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vendor/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/brands.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/regular.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/solid.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('image/logotni.png') }}">
    <title>Apk Bangsis - {{ $title }}</title>
</head>

<body>
    <script src="{{ asset('js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('js/vendor/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/swiper-script.js') }}"></script>
    <script src="{{ asset('js/submit-form.js') }}"></script>
    <script src="{{ asset('js/vendor/isotope.pkgd.min.js') }}"></script>

    <!-- Header -->
    @include('partials.banner')
    @include('partials.navbar')
    
    <div class="container">
        @yield('container')
    </div>
    

    <script src="{{ asset('js/vendor/fslightbox.js') }}"></script>
    <script src="{{ asset('js/masonry.js') }}"></script>
</body>

</html>