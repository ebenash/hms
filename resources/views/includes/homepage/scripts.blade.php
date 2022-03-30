<!-- Vendor -->
    <script src="{{ asset('homepage/assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/jquery.appear/jquery.appear.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/jquery-cookie/jquery-cookie.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/popper/umd/popper.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/common/common.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/jquery.validation/jquery.validation.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/jquery.gmap/jquery.gmap.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/jquery.lazyload/jquery.lazyload.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/isotope/jquery.isotope.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/vide/vide.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('homepage/assets/js/theme.js')}}"></script>

    <!-- Current Page Vendor and Views -->
    <script src="{{ asset('homepage/assets/vendor/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
    <script src="{{ asset('homepage/assets/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>

    <!-- Current Page Vendor and Views -->
    <script src="{{ asset('homepage/assets/js/views/view.contact.js')}}"></script>

    <!-- Demo -->
    <script src="{{ asset('homepage/assets/js/demos/demo-hotel.js')}}"></script>

    <!-- Theme Custom -->
    <script src="{{ asset('homepage/assets/js/custom.js')}}"></script>

    <!-- Theme Initialization Files -->
    <script src="{{ asset('homepage/assets/js/theme.init.js')}}"></script>


    <!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information. -->
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-136937398-1', 'auto');
        ga('send', 'pageview');
    </script>
    {{-- <script src="{{asset('homepage/assets/js/demos/demo-photography.js')}}"></script> --}}
    @stack('script_after')
