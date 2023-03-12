
<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header bg-white-5">
        <!-- Logo -->
        <a class="font-w600 text-dual" href="{{url('/admin/dashboard')}}">
            <span class="smini-visible">
                <img src="{{route('hms-uploads-file',($current_user->company->logo ?? 'mist_logo.jpeg'))}}" width="20px"/>
            </span>
            <span class="smini-hide font-size-h5 tracking-wider">
                <img src="{{route('hms-uploads-file',($current_user->company->logo ?? 'mist_logo.jpeg'))}}" height="40px"/>
            </span>
        </a>
        <!-- END Logo -->

        <!-- Extra -->
        <div>

            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="d-lg-none btn btn-sm btn-dual ml-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                <i class="nav-main-link-icon fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
        </div>
        <!-- END Extra -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/dashboard') ? ' active' : '' }}" href="{{route('dashboard')}}">
                        <i class="nav-main-link-icon si si-speedometer"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                    </a>
                </li>
                <li class="nav-main-heading">Menu</li>
                <li class="nav-main-item{{ request()->is('admin/guests') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#"><i class="nav-main-link-icon si si-users"></i><span class="nav-main-link-name">Guests</span></a>
                    <ul class="nav-main-submenu">
                        @can('add guests')
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="#" data-toggle="modal" data-target="#modal-view-add-guest"><i class="nav-main-link-icon fa fa-plus"></i><span class="nav-main-link-name">Add New Guest</span></a>
                            </li>
                        @endcan
                        @can('view guests')
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/guests') ? ' active' : '' }}" href="{{url('/admin/guests')}}"><i class="nav-main-link-icon fa fa-list"></i><span class="nav-main-link-name">Guest List</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <li class="nav-main-item{{ request()->is('admin/rooms') ? ' open' : (request()->is('admin/roomtypes') ? ' open' : '') }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#"><i class="nav-main-link-icon si si-home"></i><span class="nav-main-link-name">Rooms</span></a>
                    <ul class="nav-main-submenu">
                        {{-- <li class="nav-main-item">
                            <a class="nav-main-link" href="#" data-toggle="modal" data-target="#modal-view-add-room"><i class="nav-main-link-icon fa fa-plus"></i><span class="nav-main-link-name">Add New Room</span></a>
                        </li> --}}
                        @can('view rooms')
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/rooms') ? ' active' : '' }}" href="{{url('/admin/rooms')}}"><i class="nav-main-link-icon fa fa-list"></i><span class="nav-main-link-name">Room List</span></a>
                            </li>
                        @endcan
                        @can('view roomtypes')
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/roomtypes') ? ' active' : '' }}" href="{{url('/admin/roomtypes')}}"><i class="nav-main-link-icon fa fa-bookmark"></i><span class="nav-main-link-name">Room Types</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <li class="nav-main-item{{ request()->is('admin/reservations/*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#"><i class="nav-main-link-icon si si-notebook"></i><span class="nav-main-link-name">Reservations</span></a>
                    <ul class="nav-main-submenu">
                        @can('add reservations')
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/reservations/create/guest/*') ? ' active' : '' }}" href="javascript:void(0)" data-toggle="modal" data-target="#modal-view-add-reservation"><i class="nav-main-link-icon fa fa-plus"></i><span class="nav-main-link-name">Add New Reservation</span></a>
                            </li>
                        @endcan
                        @can('view reservations')
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/reservations/today') ? ' active' : '' }}" href="{{route('reservations-today')}}"><i class="nav-main-link-icon fa fa-calendar-check"></i><span class="nav-main-link-name">Today's Check-Ins</span></a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/reservations/confirmed') ? ' active' : '' }}" href="{{route('reservations-confirmed')}}"><i class="nav-main-link-icon fa fa-list"></i><span class="nav-main-link-name">Confirmed Reservations</span></a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/reservations/requests') ? ' active' : '' }}" href="{{route('reservations-requests')}}"><i class="nav-main-link-icon fa fa-calendar-plus"></i><span class="nav-main-link-name">Reservation Requests</span></a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/reservations/pending') ? ' active' : '' }}" href="{{route('reservations-pending')}}"><i class="nav-main-link-icon fa fa-calendar-minus"></i><span class="nav-main-link-name">Pending Reservations</span></a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('admin/reservations/calendar') ? ' active' : '' }}" href="{{url('/admin/reservations/calendar')}}"><i class="nav-main-link-icon fa fa-calendar"></i><span class="nav-main-link-name">Reservations Calendar</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
                {{-- <li class="nav-main-item{{ request()->is('admin/accounting/*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#"><i class="nav-main-link-icon si si-calculator"></i><span class="nav-main-link-name">Accounting</span></a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/accounting/') ? ' active' : '' }}" href="#" data-toggle="modal" data-target="#modal-view-add-reservation"><i class="nav-main-link-icon fa fa-calendar"></i><span class="nav-main-link-name">Overview</span></a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/accounting/invoicing') ? ' active' : '' }}" href="{{url('/admin/reservations/today')}}"><i class="nav-main-link-icon fa fa-calendar-check"></i><span class="nav-main-link-name">Invoicing & Reciept Tool</span></a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/accounting/payments') ? ' active' : '' }}" href="{{url('/admin/reservations')}}"><i class="nav-main-link-icon fa fa-list"></i><span class="nav-main-link-name">Payments</span></a>
                        </li>
                    </ul>
                </li> --}}
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/reports') ? ' active' : '' }}" href="{{route('reports')}}" ><i class="nav-main-link-icon si si-docs"></i><span class="nav-main-link-name">Reports</span></a>
                </li>
                @can('view settings')
                    <li class="nav-main-item">
                        <a class="nav-main-link{{ request()->is('admin/settings') ? ' active' : '' }}" href="{{route('settings')}}" ><i class="nav-main-link-icon si si-settings"></i><span class="nav-main-link-name">Configuration</span></a>
                    </li>
                @endcan
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
