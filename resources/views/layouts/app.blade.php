<!doctype html>
<html lang="{{ config('app.locale') }}">
    @include('includes.head')
    <body onload=display_ct();>
        <div class="loader" style="display:none"></div>
        <!-- Page Container -->
        <!--
            Available classes for #page-container:

        GENERIC

            'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

        SIDEBAR & SIDE OVERLAY

            'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
            'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
            'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
            'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
            'sidebar-dark'                              Dark themed sidebar

            'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
            'side-overlay-o'                            Visible Side Overlay by default

            'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

            'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

        HEADER

            ''                                          Static Header if no class is added
            'page-header-fixed'                         Fixed Header

        HEADER STYLE

            ''                                          Light themed Header
            'page-header-dark'                          Dark themed Header

        MAIN CONTENT LAYOUT

            ''                                          Full width Main Content if no class is added
            'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
            'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
        -->
        <div id="page-container" class="sidebar-o enable-page-overlay {{auth()->user()->settings->sidebar ?? 'sidebar-dark'}} {{auth()->user()->settings->header ?? ''}} {{auth()->user()->settings->minimize ?? ''}} side-scroll page-header-fixed main-content-narrow">
            <!-- Side Overlay-->
            @include('includes.right-sidebar')
            <!-- END Side Overlay -->

            <!-- Sidebar -->
            <!--
                Sidebar Mini Mode - Display Helper classes

                Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
                Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
                    If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

                Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
                Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
                Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
            -->
            @include('includes.sidebar')
            <!-- END Sidebar -->

            <!-- Header -->
            @include('includes.header')
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
                @include('includes.pageheader')

                <!-- Page Content -->
                <div class="content">
                    {{-- @include('includes.alerts') --}}
                    @yield('content')
                </div>

            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            @include('includes.footer')
            <!-- END Footer -->

            <!-- Apps Modal -->
            <!-- Opens from the modal toggle button in the header -->
            @include('includes.modals')
            <!-- END Apps Modal -->
        </div>
        <!-- END Page Container -->

        @include('includes.scripts')

        @include('includes.notifications')
    </body>
</html>
