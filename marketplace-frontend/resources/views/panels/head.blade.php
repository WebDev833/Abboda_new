<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Food and grocery delivery. We deliver anything anywhere</title>
    <link rel="manifest" href="/manifest.json?v={{ time() }}">
    <link rel="icon" type="image/png" href="{{ asset('/images/favicon.png?v=1')}}">

    <link rel="apple-touch-icon" href="{{ asset('/images/icon-256x256.png')}}" />


   <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href=" {{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('fonts/Linearicons/Linearicons/Font/demo-files/demo.css') }}">
    <link rel="stylesheet" href=" {{ asset('plugins/bootstrap4/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('plugins/owl-carousel/assets/owl.carousel.css') }}">
    <link rel="stylesheet" href=" {{ asset('plugins/slick/slick/slick.css') }}">
    <link rel="stylesheet" href=" {{ asset('plugins/lightGallery-master/dist/css/lightgallery.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css') }}">
    <link rel="stylesheet" href=" {{ asset('plugins/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href=" {{ asset('plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/style.css?v=4') }}">
    <link rel="stylesheet" href=" {{ asset('css/custom.css?v=4') }}">
    <link rel="stylesheet" href=" {{ asset('css/mediaquery.css?v=4') }}">
    <link rel="stylesheet" href=" {{ asset('css/mystyle.css?v=4') }}">
<link rel="stylesheet" href="//unpkg.com/swiper/swiper-bundle.min.css" />
<script src="//unpkg.com/swiper/swiper-bundle.min.js"></script>
    @yield('page-styles')


    
</head>