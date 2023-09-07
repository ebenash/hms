<!doctype html>
<html lang="{{ config('app.locale') }}" class="boxed">
    @include('includes.homepage.head')
    <body>
        <div class="loader" style="display:none"></div>


        <!-- Side Overlay-->
        {{-- @include('includes.homepage.right-sidebar') --}}


        {{-- @include('includes.homepage.sidebar') --}}
        <!-- END Sidebar -->

        <!-- Header -->
        @include('includes.homepage.header')
        <!-- END Header -->
        <div class="body" id="nav">

            <!-- Main Container -->
            <div role="main" class="main">
                @include('includes.homepage.menu')
                @include('includes.homepage.alerts')
                @yield('content')
                @include('includes.homepage.actionbox')
                @include('includes.homepage.footer1')
            </div>
            <!-- END Main Container -->

        </div>

        <!-- Footer -->

        @include('includes.homepage.footer2')
        <!-- END Footer -->

        <!-- Apps Modal -->
        <!-- Opens from the modal toggle button in the header -->
        {{-- @include('includes.homepage.modals') --}}
        <!-- END Apps Modal -->

        <!-- END Page Container -->

        @include('includes.homepage.scripts')
    </body>
</>
