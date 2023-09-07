<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ config('app.name', 'MIST Hotel Management System') }}</title>

    <meta name="description" content="{{ config('app.name', 'MIST Hotel Management System') }}">
    <meta name="author" content="ebenash">
    <meta name="robots" content="noindex, nofollow">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.ico') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

    <!-- Fonts and Styles -->
    @yield('css_before')
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"> --}}
    <link rel="stylesheet" id="css-main" href="{{ mix('/css/oneui.min.css') }}">

    {{-- {{dd(auth()->user()->settings)}} --}}
    <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
    @if (isset(auth()->user()->settings->theme))
        <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/'.(auth()->user()->settings->theme).'.css') }}">
    {{-- @else
        <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/default-extra.css') }}"> --}}
    @endif

    {{-- <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}"> --}}

    @yield('css_after')

    <!-- Scripts -->
    {{-- <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script> --}}
    <style>
        @media screen and (max-width: 540px) {
            .logo-view {
                height: 50px;
            }
        }

        /* For Tablets */
        @media screen and (min-width: 540px){
            .logo-view {
                width: 80%;
            }
        }
        div.dt-button-collection{
            padding-top: 5px;
        }


        /* #feedbackbutton {
            position: fixed;
            bottom: 30px;
            right: 90px;
            animation: shadow-pulse 1s 5;
            z-index: 11;
        }

        @media (max-width: 1300px) {
            #feedbackbutton {
                position: fixed;
                bottom: 45px;
                right: 80px;
                animation: shadow-pulse 1s 5;
                z-index: 11;
            }
        } */

        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../../media/loading/admin-loader.gif') 50% 50% no-repeat rgb(249,249,249,0.7);
        }

    </style>
</head>
