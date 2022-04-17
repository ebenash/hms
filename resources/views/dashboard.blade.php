@extends('layouts.app')

@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        Main Dashboard
    </h1>
    <h2 class="h6 font-w500 text-muted mb-0">
        Welcome <a class="font-w600" href="{{route('user-profile')}}">{{ Auth::user()->name ?? 'User'}}</a>@can('respond to reservation requests'), you have <a href="javascript:void(0)">{{count($notifications)}}</a> new notifications. @endcan
    </h2>
@endsection

@section('content')

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @can('view reservations')
            <!-- Reservations Overview -->
            <div class="row row-deck">
                <div class="col-sm-6 col-xl-3">
                    <!-- Today Checkins -->
                    <div class="block block-rounded d-flex flex-column">
                        <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                            <dl class="mb-0">
                                <dt class="font-size-h2 font-w700">{{$count_today}}</dt>
                                <dd class="text-muted mb-0">Today</dd>
                            </dl>
                            <div class="item item-rounded bg-body">
                                <i class="fa fa-calendar-alt font-size-h3 text-primary"></i>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                            <a class="font-w500 d-flex align-items-center" href="{{route('reservations-today')}}">
                                Check-ins today
                                <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                            </a>
                        </div>
                    </div>
                    <!-- END Today Checkins -->
                </div>
                <div class="col-sm-6 col-xl-3">
                    <!-- Pending Requests -->
                    <div class="block block-rounded d-flex flex-column">
                        <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                            <dl class="mb-0">
                                <dt class="font-size-h2 font-w700">{{$count_requests}}</dt>
                                <dd class="text-muted mb-0">Requests</dd>
                            </dl>
                            <div class="item item-rounded bg-body">
                                <i class="fa fa-calendar-plus font-size-h3 text-primary"></i>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                            <a class="font-w500 d-flex align-items-center" href="{{route('reservations-requests')}}">
                                Pending requests
                                <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                            </a>
                        </div>
                    </div>
                    <!-- END Pending Requests -->
                </div>
                <div class="col-sm-6 col-xl-3">
                    <!-- Confirmed Reservations -->
                    <div class="block block-rounded d-flex flex-column">
                        <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                            <dl class="mb-0">
                                <dt class="font-size-h2 font-w700">{{$count_confirmed}}</dt>
                                <dd class="text-muted mb-0">Confirmed</dd>
                            </dl>
                            <div class="item item-rounded bg-body">
                                <i class="fa fa-calendar-check font-size-h3 text-primary"></i>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                            <a class="font-w500 d-flex align-items-center" href="{{route('reservations-confirmed')}}">
                                Confirmed reservations
                                <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                            </a>
                        </div>
                    </div>
                    <!-- END Confirmed Reservations-->
                </div>
                <div class="col-sm-6 col-xl-3">
                    <!-- Cancelled -->
                    <div class="block block-rounded d-flex flex-column">
                        <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                            <dl class="mb-0">
                                <dt class="font-size-h2 font-w700">{{$count_cancelled}}</dt>
                                <dd class="text-muted mb-0">Cancelled</dd>
                            </dl>
                            <div class="item item-rounded bg-body">
                                <i class="fa fa-calendar-times font-size-h3 text-primary"></i>
                            </div>
                        </div>
                        <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                            <a class="font-w500 d-flex align-items-center" href="{{route('reservations-cancelled')}}">
                                Cancelled reservations
                                <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                            </a>
                        </div>
                    </div>
                    <!-- END Cancelled -->
                </div>
            </div>
            <!-- END Reservations Overview -->
        @endcan

        <!-- Statistics -->
        {{-- <div class="row">
            <div class="col-xl-8 d-flex flex-column">
                <!-- Earnings Summary -->
                <div class="block block-rounded flex-grow-1 d-flex flex-column">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Earnings Summary</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option">
                                <i class="si si-settings"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full flex-grow-1 d-flex align-items-center">
                        <!-- Earnings Chart Container -->
                        <!-- Chart.js Chart is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _js/pages/be_pages_dashboard.js -->
                        <!-- For more info and examples you can check out http://www.chartjs.org/docs/ -->
                        <canvas class="js-chartjs-earnings"></canvas>
                    </div>
                    <div class="block-content bg-body-light">
                        <div class="row items-push text-center w-100">
                            <div class="col-sm-4">
                                <dl class="mb-0">
                                    <dt class="font-size-h3 font-w700">
                                        <i class="fa fa-arrow-up font-size-lg text-success"></i> 2.5%
                                    </dt>
                                    <dd class="text-muted mb-0">Customer Growth</dd>
                                </dl>
                            </div>
                            <div class="col-sm-4">
                                <dl class="mb-0">
                                    <dt class="font-size-h3 font-w700">
                                        <i class="fa fa-arrow-up font-size-lg text-success"></i> 3.8%
                                    </dt>
                                    <dd class="text-muted mb-0">Page Views</dd>
                                </dl>
                            </div>
                            <div class="col-sm-4">
                                <dl class="mb-0">
                                    <dt class="font-size-h3 font-w700">
                                        <i class="fa fa-arrow-up font-size-lg text-success"></i> 1.7%
                                    </dt>
                                    <dd class="text-muted mb-0">New Products</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Earnings Summary -->
            </div>
            <div class="col-xl-4 d-flex flex-column">
                <!-- Last 2 Weeks -->
                <!-- Sparkline Charts (.js-sparkline class is initialized in Helpers.sparkline() -->
                <!-- For more info and examples you can check out http://omnipotent.net/jquery.sparkline/#s-about -->
                <div class="row row-deck flex-grow-1">
                    <div class="col-md-6 col-xl-12">
                        <div class="block block-rounded d-flex flex-column">
                            <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between">
                                <dl class="mb-0">
                                    <dt class="font-size-h2 font-w700">570</dt>
                                    <dd class="text-muted mb-0">Total Orders</dd>
                                </dl>
                                <div>
                                    <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-danger bg-danger-light">
                                        <i class="fa fa-caret-down mr-1"></i>
                                        2.2%
                                    </div>
                                </div>
                            </div>
                            <div class="block-content p-1 text-center overflow-hidden">
                                <!-- Sparkline Line: Orders -->
                                <span class="js-sparkline" data-type="line"
                                        data-points="[33,29,32,37,38,30,34,28,43,45,26,45,49,39]"
                                        data-width="100%"
                                        data-height="70px"
                                        data-chart-range-min="20"
                                        data-line-color="rgba(210, 108, 122, .4)"
                                        data-fill-color="rgba(210, 108, 122, .15)"
                                        data-spot-color="transparent"
                                        data-min-spot-color="transparent"
                                        data-max-spot-color="transparent"
                                        data-highlight-spot-color="#D26C7A"
                                        data-highlight-line-color="#D26C7A"
                                        data-tooltip-suffix="Orders"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-12">
                        <div class="block block-rounded d-flex flex-column">
                            <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between">
                                <dl class="mb-0">
                                    <dt class="font-size-h2 font-w700">$5,234.21</dt>
                                    <dd class="text-muted mb-0">Total Earnings</dd>
                                </dl>
                                <div>
                                    <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-success bg-success-light">
                                        <i class="fa fa-caret-up mr-1"></i>
                                        4.2%
                                    </div>
                                </div>
                            </div>
                            <div class="block-content p-1 text-center oveflow-hidden">
                                <!-- Sparkline Line: Earnings -->
                                <span class="js-sparkline" data-type="line"
                                        data-points="[716,1185,750,1365,956,890,1200,968,1158,1025,920,1190,720,1352]"
                                        data-width="100%"
                                        data-height="70px"
                                        data-chart-range-min="300"
                                        data-line-color="rgba(70,195,123, .4)"
                                        data-fill-color="rgba(70,195,123, .15)"
                                        data-spot-color="transparent"
                                        data-min-spot-color="transparent"
                                        data-max-spot-color="transparent"
                                        data-highlight-spot-color="#46C37B"
                                        data-highlight-line-color="#46C37B"
                                        data-tooltip-prefix="$"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="block block-rounded d-flex flex-column">
                            <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between">
                                <dl class="mb-0">
                                    <dt class="font-size-h2 font-w700">264</dt>
                                    <dd class="text-muted mb-0">New Customers</dd>
                                </dl>
                                <div>
                                    <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-success bg-success-light">
                                        <i class="fa fa-caret-up mr-1"></i>
                                        9.3%
                                    </div>
                                </div>
                            </div>
                            <div class="block-content p-1 text-center oveflow-hidden">
                                <!-- Sparkline Line: New Customers -->
                                <span class="js-sparkline" data-type="line"
                                        data-points="[25,15,36,14,29,19,36,41,28,26,29,33,23,41]"
                                        data-width="100%"
                                        data-height="70px"
                                        data-chart-range-min="0"
                                        data-line-color="rgba(70,195,123, .4)"
                                        data-fill-color="rgba(70,195,123, .15)"
                                        data-spot-color="transparent"
                                        data-min-spot-color="transparent"
                                        data-max-spot-color="transparent"
                                        data-highlight-spot-color="#46C37B"
                                        data-highlight-line-color="#46C37B"
                                        data-tooltip-prefix="$"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Last 2 Weeks -->
            </div>
        </div> --}}
        <!-- END Statistics -->
        @can('view reservations')
            <div class="row">
                <div class="col-lg-12 d-flex flex-column">
                    <!-- Calendar -->
                    <div class="block block-rounded flex-grow-1 d-flex flex-column">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Calendar</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                                {{-- <button type="button" class="btn-block-option">
                                    <i class="si si-settings"></i>
                                </button> --}}
                            </div>
                        </div>
                        <div class="block-content block-content-full flex-grow-1 align-items-center">
                            <?php $all_calendar_reservations = $helper->get_calendar($callendar_reservation_list); ?>
                            @if(isset($calendar_reservation))
                                {!! $calendar_reservation->calendar() !!}
                            @else
                                {!! $all_calendar_reservations->calendar() !!}
                                {!! $all_calendar_reservations->script() !!}
                            @endif
                        </div>
                    </div>
                    <!-- END Calendar -->
                </div>
            </div>
        @endcan
        {{-- <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Recent Orders</h3>
                <div class="block-options">
                    X
                </div>
            </div>
            <div class="block-content">
                <!-- Recent Orders Table -->
                <div class="table-responsive">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 120px;">Res ID</th>
                                <th class="d-none d-sm-table-cell">Room Name</th>
                                <th class="d-none d-xl-table-cell">Guest Name</th>
                                <th>Status</th>
                                <th class="d-none d-xl-table-cell text-center">Check-in</th>
                                <th class="d-none d-sm-table-cell text-center">Days</th>
                                <th class="d-none d-sm-table-cell text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_reservations as $reservation)
                                <tr>
                                    <td class="text-center font-size-sm">
                                        <a class="font-w600" href="javascript:void(0)">
                                            <strong>RES.{{$reservation->id}}</strong>
                                        </a>
                                    </td>
                                    <td class="d-none d-sm-table-cell font-size-sm font-w600 text-muted">{{$reservation->room->name}}</td>
                                    <td class="d-none d-xl-table-cell font-size-sm">
                                        <a class="font-w600" href="javascript:void(0)">{{$reservation->guest->first_name.' '.$reservation->guest->last_name}}</a>
                                    </td>
                                    <td>
                                        <span class="font-size-sm font-w600 px-2 py-1 rounded  bg-success-light text-success">{{$reservation->reservation_status}}</span>
                                    </td>
                                    <td class="d-none d-xl-table-cell text-center font-size-sm">
                                        <a class="font-w600" href="javascript:void(0)">{{$reservation->check_in}}</a>
                                    </td>
                                    <td class="d-none d-sm-table-cell text-center">
                                        <span class="font-size-sm font-w600 px-2 py-1 rounded bg-body-dark">{{$reservation->days}} days</span>
                                    </td>
                                    <td class="d-none d-sm-table-cell text-right font-size-sm">
                                        <strong>GH₵ {{number_format($reservation->price,2)}}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- END Recent Orders Table -->
            </div>
        </div> --}}
        <!-- END Recent Orders -->

@endsection

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/fullcalendar/main.min.css') }}"/>
@endsection
@section('js_after')
    <!-- Page JS Plugins -->

    <script src="{{ asset('js/plugins/fullcalendar/main.js') }}"></script>
    <script src="{{ asset('js/plugins/fullcalendar/locales-all.min.js') }}"></script>

@endsection
