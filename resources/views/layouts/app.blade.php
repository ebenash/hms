
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('includes.head')
    <body onload=display_ct();>
        <div id="page-loader"></div>
        @guest
            <!-- Page Container -->
            <div id="page-container">
                <main id="main-container">
                    @include('includes.alerts')
                    @yield('content')
                </main>
                <!-- Footer -->
                @include('includes.footer')
                <!-- END Footer -->
            </div>
            <!-- END Page Container -->
        @else
            <!-- Page Container -->
            <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">

                @include('includes.sidebar')
                @include('includes.header')

                <!-- Main Container -->
                <main id="main-container">
                    <div class="content">
                        @include('includes.alerts')
                        @yield('content')
                    </div>
                </main>
                <!-- END Main Container -->
                <!-- Footer -->
                @include('includes.footer')
                <!-- END Footer -->
            </div>
            <!-- END Page Container -->
        @endguest
        @include('includes.modals')
        @include('includes.scripts')
    </body>
</html>
