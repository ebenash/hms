<!-- Sidebar -->
<nav id="sidebar">
    <!-- Sidebar Scroll Container -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="side-header side-content bg-white-op">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times"></i>
                </button>
                <!-- Themes functionality initialized in App() -> uiHandleTheme() -->
                <!--<div class="btn-group pull-right">
                    <button class="btn btn-link text-gray dropdown-toggle" data-toggle="dropdown" type="button">
                        <i class="si si-drop"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right font-s13 sidebar-mini-hide">
                        <li>
                            <a data-toggle="theme" data-theme="default" tabindex="-1" href="javascript:void(0)">
                                <i class="fa fa-circle text-default pull-right"></i> <span class="font-w600">Default</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="{{ asset('assets/css/themes/amethyst.min.css') }}" tabindex="-1" href="javascript:void(0)">
                                <i class="fa fa-circle text-amethyst pull-right"></i> <span class="font-w600">Amethyst</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="{{ asset('assets/css/themes/city.min.css') }}" tabindex="-1" href="javascript:void(0)">
                                <i class="fa fa-circle text-city pull-right"></i> <span class="font-w600">City</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="{{ asset('assets/css/themes/flat.min.css') }}" tabindex="-1" href="javascript:void(0)">
                                <i class="fa fa-circle text-flat pull-right"></i> <span class="font-w600">Flat</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="{{ asset('assets/css/themes/modern.min.css') }}" tabindex="-1" href="javascript:void(0)">
                                <i class="fa fa-circle text-modern pull-right"></i> <span class="font-w600">Modern</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="{{ asset('assets/css/themes/smooth.min.css') }}" tabindex="-1" href="javascript:void(0)">
                                <i class="fa fa-circle text-smooth pull-right"></i> <span class="font-w600">Smooth</span>
                            </a>
                        </li>
                    </ul>
                </div>-->
                <a class="h5 text-white" href="{{url('/')}}">
                    @if((isset($current_user->company->logo) && $current_user->company->logo!= ''))
                    <img src="{{url('/storage/uploads').'/'.$current_user->company->logo}}" height="50px" style="padding-bottom: 5px;"/>
                    @else
                    <img src="{{url('/storage/uploads/mist_logo.jpeg')}}" height="50px" style="padding-bottom: 5px;"/>
                    @endif
                </a>
            </div>
            <!-- END Side Header -->

            <!-- Side Content -->
            <div class="side-content">
                <ul class="nav-main">
                    <li>
                        <a class="active" href="{{url('/dashboard')}}"><i class="si si-speedometer"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                    </li>
                    <li class="nav-main-heading"><span class="sidebar-mini-hide">Menu</span></li>
                    <li class="open">
                        <a class="nav-submenu" href="#" data-toggle="nav-submenu"><i class="si si-users"></i><span class="sidebar-mini-hide">Guests</span></a>
                        <ul>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#modal-view-add-guest"><i class="fa fa-plus"></i>Add New Guest</a>
                            </li>
                            <li>
                                <a href="{{url('/guests')}}"><i class="fa fa-list"></i>Guest List</a>
                            </li>
                        </ul>
                    </li>
                    <li class="open">
                        <a class="nav-submenu" href="#" data-toggle="nav-submenu"><i class="si si-home"></i><span class="sidebar-mini-hide">Rooms</span></a>
                        <ul>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#modal-view-add-room"><i class="fa fa-plus"></i>Add New Room</a>
                            </li>
                            <li>
                                <a href="{{url('/rooms')}}"><i class="fa fa-list"></i>Room List</a>
                            </li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#modal-view-roomtypes"><i class="fa fa-bookmark"></i>Room Types</a>
                            </li>
                        </ul>
                    </li>
                    <li class="open">
                        <a class="nav-submenu" href="#" data-toggle="nav-submenu"><i class="si si-notebook"></i><span class="sidebar-mini-hide">Reservations</span></a>
                        <ul>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#modal-view-add-reservation"><i class="fa fa-plus"></i>Add New Reservation</a>
                            </li>
                            <li>
                                <a href="{{url('/reservations/today')}}"><i class="fa fa-calendar-check-o"></i>Today's Check-Ins</a>
                            </li>
                            <li>
                                <a href="{{url('/reservations')}}"><i class="fa fa-list"></i>Reservation List</a>
                            </li>
                            <li>
                                <a href="{{url('/reservations/calendar')}}"><i class="fa fa-calendar"></i>Reservations Calendar</a>
                            </li>
                        </ul>
                    </li>
                    <li class="open">
                        <a class="nav-submenu" href="#" data-toggle="nav-submenu"><i class="si si-calculator"></i><span class="sidebar-mini-hide">Accounting</span></a>
                        <ul>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#modal-view-add-reservation"><i class="fa fa-calendar"></i>Reservation Accounting</a>
                            </li>
                            <li>
                                <a href="{{url('/reservations/today')}}"><i class="fa fa-calendar-check-o"></i>Invoicing & Reciept Tool</a>
                            </li>
                            <li>
                                <a href="{{url('/reservations')}}"><i class="fa fa-list"></i>Payments</a>
                            </li>
                            <li>
                                <a href="{{url('/reservations/calendar')}}"><i class="fa fa-calendar"></i>Reports</a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
            <!-- END Side Content -->
        </div>
        <!-- Sidebar Content -->
    </div>
    <!-- END Sidebar Scroll Container -->
</nav>
<!-- END Sidebar -->