<head>


    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- <%= htmlWebpackPlugin.options.title %> -->
    <title>
        Royal Elmount Hotel
    </title>

    <meta name="keywords" content="Royal Elmount Hotel" />
    <meta name="description" content="Royal Elmount Hotel">
    <meta name="author" content="ebenash">

    {{-- <meta name="robots" content="noindex, nofollow"> --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('homepage/assets/img/favicon.ico')}}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ asset('homepage/assets/img/apple-touch-icon.png')}}">
    <link rel="icon" href="{{ asset('homepage/assets/img/favicon.ico')}}">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

    @yield('css_before')

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('homepage/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/vendor/animate/animate.min.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/vendor/simple-line-icons/css/simple-line-icons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/vendor/owl.carousel/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/vendor/magnific-popup/magnific-popup.min.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css')}}">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('homepage/assets/css/theme.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/css/theme-elements.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/css/theme-blog.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/css/theme-shop.css')}}">

    <!-- Current Page CSS -->
    <link rel="stylesheet" href="{{ asset('homepage/assets/vendor/rs-plugin/css/settings.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/vendor/rs-plugin/css/layers.css')}}">
    <link rel="stylesheet" href="{{ asset('homepage/assets/vendor/rs-plugin/css/navigation.css')}}">

    @php
        $bg = array('bg-1.svg', 'bg-2.svg', 'bg-3.svg', 'bg-4.svg', 'bg-5.svg', 'bg-6.svg','bg-7.svg', 'bg-8.svg', 'bg-9.svg', 'bg-10.svg', 'bg-11.svg', 'bg-12.svg'  ); // array of filenames
        $month = (int)date('m');
        // $i = $month > 6 ? $month - 6 : $month ;// generate random number size of the array
        $selectedBg = $bg[$month-1]; // set variable equal to which random filename was chosen

        // dd($selectedBg);
        if (!in_array($selectedBg, $bg)){
            $selectedBg = 'bg-1.svg';
        }
    @endphp

    <style type="text/css">
        html.boxed {
            background-image: url("homepage/assets/img/patterns/<?php echo $selectedBg; ?>") !important;
        }

        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../../media/loading/home-loader.gif') 50% 50% no-repeat rgb(249,249,249,0.7);
        }
    </style>
    @if ($selectedBg != 'bg-1.svg' && $selectedBg != 'bg-2.svg' && $selectedBg != 'bg-7.svg'  && $selectedBg != 'bg-7.svg' )
        <style type="text/css">
            html.boxed {
                background-size: 100%;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center top;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                background-size: cover;
                opacity: 0.95;
                -webkit-backface-visibility: hidden;
                -webkit-background-size: cover !important;
                z-index: -1;
                -webkit-transform: translate3d(0, 0);
                width: 100%;
                height: 100%;
                margin: 0 auto;
            }
        </style>
    @endif


    <!-- Demo CSS -->
    <link rel="stylesheet" href="{{ asset('homepage/assets/css/demos/demo-hotel.css')}}">

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{ asset('homepage/assets/css/skins/skin-hotel.css')}}">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('homepage/assets/css/custom.css')}}">

    {{-- <link rel="stylesheet" href="{{asset('homepage/assets/css/demos/demo-photography-2.css')}}"> --}}

    @yield('css_after')

    <!-- Head Libs -->
    <script src="{{ asset('homepage/assets/vendor/modernizr/modernizr.min.js')}}"></script>
</head>
