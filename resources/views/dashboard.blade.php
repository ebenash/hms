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
                                <dt class="font-size-h3 font-w700">{{$count_today}}</dt>
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
                                <dt class="font-size-h3 font-w700">{{$count_requests}}</dt>
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
                                <dt class="font-size-h3 font-w700">{{$count_confirmed}}</dt>
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
                                <dt class="font-size-h3 font-w700">{{$count_cancelled}}</dt>
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

        <h2 class="content-heading">What’s happening today?</h2>

        <!-- Statistics -->
        <div class="row">
            <div class="col-xl-8 d-flex flex-column">
                <!-- Earnings Summary -->
                <div class="block block-rounded flex-grow-1 d-flex flex-column">
                    <ul class="nav nav-tabs nav-tabs-block align-items-center" data-toggle="tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-reservation-arrivals">Arrivals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-reservation-stay-over">Stay-Over</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-reservation-departures">Departures</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-reservation-requests">New Requests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-reservation-recents">Recent Reservations</a>
                        </li>
                        <li class="nav-item ml-auto">
                            <div class="block-options pl-3 pr-2">
                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                            </div>
                        </li>
                    </ul>
                    <div class="tab-content block-content block-content-full flex-grow-1 d-flex"><!--align-items-center-->
                        <div class="tab-pane active" id="tab-reservation-arrivals" role="tabpanel" style="width:100% !important; height:300px;overflow:auto;">
                            <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm mb-0">
                                <thead style="background-color: white; position: sticky;top: -1px;">
                                    <tr class="text-uppercase">
                                        <th class="font-w700" style="width: 5%;">ID</th>
                                        <th class="d-none d-sm-table-cell font-w700" style="width: 40%;">Dates</th>
                                        <th class="font-w700" style="width: 20%;">Guest</th>
                                        <th class="font-w700" style="width: 15%;">Status</th>
                                        <th class="d-none d-sm-table-cell font-w700 text-right" style="width: 15%;">Room</th>
                                        <th class="font-w700 text-center" style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($arrivals as $reservation)
                                        @php
                                            $amtpaid = $reservation->success_payments->sum('amount')/100;
                                        @endphp
                                        @foreach($reservation->details as $detail)
                                            <tr>
                                                <td>
                                                    <span class="font-w600"><a href="{{route('reservations-show',$reservation->id)}}">#{{$reservation->id}}</a></span>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <span class="font-size-sm text-muted">{{$reservation->check_in}} to {{$reservation->check_out}}</span>
                                                </td>
                                                <td>
                                                    <span class="font-w600 text-muted">{{$reservation->guest->full_name}}</span>
                                                </td>
                                                <td>
                                                    @if($reservation->reservation_type == 'complementary') <span class="text-primary">Complementary</span> @endif @if($reservation->reservation_status == 'confirmed') <span class="text-success">Confirmed</span>  @if($reservation->reservation_type != 'complementary') @if($amtpaid >= $reservation->grand_total) <span class="text-success">Fully Paid</span> @elseif(($amtpaid > 0) && ($amtpaid < $reservation->grand_total)) <span class="text-warning">Part Paid</span> @else<span class="text-danger">Not Paid</span> @endif @endif  @elseif($reservation->reservation_status == 'pending') {!! strtotime($reservation->check_in) < strtotime(date('Y-m-d')) ? '<span class="text-danger">Overdue</span>':'<span class="text-warning">Pending</span>' !!} @elseif($reservation->reservation_status == 'rejected') <span class="text-danger">Rejected</span> @else <span class="text-danger">Cancelled</span> @endif
                                                </td>
                                                <td class="d-none d-sm-table-cell text-right">
                                                    @if($detail->room)<span class="badge badge-secondary">{{$detail->room->name}}</span>@endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route(($reservation->reservation_status=='pending' && $reservation->created_by==0) ? 'reservations-view-request':'reservations-edit',$reservation->id)}}" data-toggle="tooltip" data-placement="left" title="Manage">
                                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab-reservation-stay-over" role="tabpanel" style="width:100% !important; height:300px;overflow:auto;">
                            <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm mb-0">
                                <thead style="background-color: white; position: sticky;top: -1px;">
                                    <tr class="text-uppercase">
                                        <th class="font-w700" style="width: 5%;">ID</th>
                                        <th class="d-none d-sm-table-cell font-w700" style="width: 40%;">Dates</th>
                                        <th class="font-w700" style="width: 20%;">Guest</th>
                                        <th class="font-w700" style="width: 15%;">Status</th>
                                        <th class="d-none d-sm-table-cell font-w700 text-right" style="width: 15%;">Room</th>
                                        <th class="font-w700 text-center" style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stay_over as $reservation)
                                        @php
                                            $amtpaid = $reservation->success_payments->sum('amount')/100;
                                        @endphp
                                        @foreach($reservation->details as $detail)
                                            <tr>
                                                <td>
                                                    <span class="font-w600"><a href="{{route('reservations-show',$reservation->id)}}">#{{$reservation->id}}</a></span>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <span class="font-size-sm text-muted">{{$reservation->check_in}} to {{$reservation->check_out}}</span>
                                                </td>
                                                <td>
                                                    <span class="font-w600 text-muted">{{$reservation->guest->full_name ?? ''}}</span>
                                                </td>
                                                <td>
                                                     @if($reservation->reservation_type == 'complementary') <span class="text-primary">Complementary</span> @endif @if($reservation->reservation_status == 'confirmed') <span class="text-success">Confirmed</span>  @if($reservation->reservation_type != 'complementary') @if($amtpaid >= $reservation->grand_total) <span class="text-success">Fully Paid</span> @elseif(($amtpaid > 0) && ($amtpaid < $reservation->grand_total)) <span class="text-warning">Part Paid</span> @else<span class="text-danger">Not Paid</span> @endif @endif  @elseif($reservation->reservation_status == 'pending') {!! strtotime($reservation->check_in) < strtotime(date('Y-m-d')) ? '<span class="text-danger">Overdue</span>':'<span class="text-warning">Pending</span>' !!} @elseif($reservation->reservation_status == 'rejected') <span class="text-danger">Rejected</span> @else <span class="text-danger">Cancelled</span> @endif
                                                </td>
                                                <td class="d-none d-sm-table-cell text-right">
                                                    @if($detail->room)<span class="badge badge-secondary">{{$detail->room->name}}</span>@endif
                                                </td>
                                                <td class="text-center">
                                                    @can('edit reservations')
                                                        <a href="{{route(($reservation->reservation_status=='pending' && $reservation->created_by==0) ? 'reservations-view-request':'reservations-edit',$reservation->id)}}" data-toggle="tooltip" data-placement="left" title="Manage">
                                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab-reservation-departures" role="tabpanel" style="width:100% !important; height:300px;overflow:auto;">
                            <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm mb-0">
                                <thead style="background-color: white; position: sticky;top: -1px;">
                                    <tr class="text-uppercase">
                                        <th class="font-w700" style="width: 5%;">ID</th>
                                        <th class="d-none d-sm-table-cell font-w700" style="width: 40%;">Dates</th>
                                        <th class="font-w700" style="width: 20%;">Guest</th>
                                        <th class="font-w700" style="width: 15%;">Status</th>
                                        <th class="d-none d-sm-table-cell font-w700 text-right" style="width: 15%;">Room</th>
                                        <th class="font-w700 text-center" style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($departures as $reservation)
                                        @php
                                            $amtpaid = $reservation->success_payments->sum('amount')/100;
                                        @endphp
                                        @foreach($reservation->details as $detail)
                                            <tr>
                                                <td>
                                                    <span class="font-w600"><a href="{{route('reservations-show',$reservation->id)}}">#{{$reservation->id}}</a></span>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <span class="font-size-sm text-muted">{{$reservation->check_in}} to {{$reservation->check_out}}</span>
                                                </td>
                                                <td>
                                                    <span class="font-w600 text-muted">{{$reservation->guest->full_name ?? ''}}</span>
                                                </td>
                                                <td>
                                                     @if($reservation->reservation_type == 'complementary') <span class="text-primary">Complementary</span> @endif @if($reservation->reservation_status == 'confirmed') <span class="text-success">Confirmed</span>  @if($reservation->reservation_type != 'complementary') @if($amtpaid >= $reservation->grand_total) <span class="text-success">Fully Paid</span> @elseif(($amtpaid > 0) && ($amtpaid < $reservation->grand_total)) <span class="text-warning">Part Paid</span> @else<span class="text-danger">Not Paid</span> @endif @endif  @elseif($reservation->reservation_status == 'pending') {!! strtotime($reservation->check_in) < strtotime(date('Y-m-d')) ? '<span class="text-danger">Overdue</span>':'<span class="text-warning">Pending</span>' !!} @elseif($reservation->reservation_status == 'rejected') <span class="text-danger">Rejected</span> @else <span class="text-danger">Cancelled</span> @endif
                                                </td>
                                                <td class="d-none d-sm-table-cell text-right">
                                                    @if($detail->room)<span class="badge badge-secondary">{{$detail->room->name}}</span>@endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route(($reservation->reservation_status=='pending' && $reservation->created_by==0) ? 'reservations-view-request':'reservations-edit',$reservation->id)}}" data-toggle="tooltip" data-placement="left" title="Manage">
                                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab-reservation-requests" role="tabpanel" style="width:100% !important; height:300px;overflow:auto;">
                            <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm mb-0">
                                <thead style="background-color: white; position: sticky;top: -1px;">
                                    <tr class="text-uppercase">
                                        <th class="font-w700" style="width: 5%;">ID</th>
                                        <th class="d-none d-sm-table-cell font-w700" style="width: 40%;">Dates</th>
                                        <th class="font-w700" style="width: 20%;">Guest</th>
                                        <th class="font-w700" style="width: 15%;">Status</th>
                                        <th class="d-none d-sm-table-cell font-w700 text-right" style="width: 15%;">Requested</th>
                                        <th class="font-w700 text-center" style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $reservation)
                                        @php
                                            $amtpaid = $reservation->success_payments->sum('amount')/100;
                                        @endphp
                                        @foreach($reservation->details as $detail)
                                            <tr>
                                                <td>
                                                    <span class="font-w600"><a href="{{route('reservations-show',$reservation->id)}}">#{{$reservation->id}}</a></span>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <span class="font-size-sm text-muted">{{$reservation->check_in}} to {{$reservation->check_out}}</span>
                                                </td>
                                                <td>
                                                    <span class="font-w600 text-muted">{{$reservation->guest->full_name ?? ''}}</span>
                                                </td>
                                                <td>
                                                     @if($reservation->reservation_type == 'complementary') <span class="text-primary">Complementary</span> @endif @if($reservation->reservation_status == 'confirmed') <span class="text-success">Confirmed</span>  @if($reservation->reservation_type != 'complementary') @if($amtpaid >= $reservation->grand_total) <span class="text-success">Fully Paid</span> @elseif(($amtpaid > 0) && ($amtpaid < $reservation->grand_total)) <span class="text-warning">Part Paid</span> @else<span class="text-danger">Not Paid</span> @endif @endif  @elseif($reservation->reservation_status == 'pending') {!! strtotime($reservation->check_in) < strtotime(date('Y-m-d')) ? '<span class="text-danger">Overdue</span>':'<span class="text-warning">Pending</span>' !!} @elseif($reservation->reservation_status == 'rejected') <span class="text-danger">Rejected</span> @else <span class="text-danger">Cancelled</span> @endif
                                                </td>
                                                <td class="d-none d-sm-table-cell text-right">
                                                    @if($detail->roomtype)<span class="badge badge-secondary">{{$detail->roomtype->name}}</span>@endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route(($reservation->reservation_status=='pending' && $reservation->created_by==0) ? 'reservations-view-request':'reservations-edit',$reservation->id)}}" data-toggle="tooltip" data-placement="left" title="Manage">
                                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tab-reservation-recents" role="tabpanel" style="width:100% !important; height:300px;overflow:auto;">
                            <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm mb-0">
                                <thead style="background-color: white; position: sticky;top: -1px;">
                                    <tr class="text-uppercase">
                                        <th class="font-w700" style="width: 5%;">ID</th>
                                        <th class="d-none d-sm-table-cell font-w700" style="width: 40%;">Dates</th>
                                        <th class="font-w700" style="width: 20%;">Guest</th>
                                        <th class="font-w700" style="width: 15%;">Status</th>
                                        <th class="d-none d-sm-table-cell font-w700 text-right" style="width: 15%;">Room</th>
                                        <th class="font-w700 text-center" style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_reservations as $reservation)
                                        @php
                                            $amtpaid = $reservation->success_payments->sum('amount')/100;
                                        @endphp
                                        @foreach($reservation->details as $detail)
                                        {{-- {{dump($detail)}} --}}
                                            <tr>
                                                <td>
                                                    <span class="font-w600"><a href="{{route('reservations-show',$reservation->id)}}">#{{$reservation->id}}</a></span>
                                                </td>
                                                <td class="d-none d-sm-table-cell">
                                                    <span class="font-size-sm text-muted">{{$reservation->check_in}} to {{$reservation->check_out}}</span>
                                                </td>
                                                <td>
                                                    <span class="font-w600 text-muted">{{$reservation->guest->full_name ?? ''}}</span>
                                                </td>
                                                <td>
                                                     @if($reservation->reservation_type == 'complementary') <span class="text-primary">Complementary</span> @endif @if($reservation->reservation_status == 'confirmed') <span class="text-success">Confirmed</span>  @if($reservation->reservation_type != 'complementary') @if($amtpaid >= $reservation->grand_total) <span class="text-success">Fully Paid</span> @elseif(($amtpaid > 0) && ($amtpaid < $reservation->grand_total)) <span class="text-warning">Part Paid</span> @else<span class="text-danger">Not Paid</span> @endif @endif  @elseif($reservation->reservation_status == 'pending') {!! strtotime($reservation->check_in) < strtotime(date('Y-m-d')) ? '<span class="text-danger">Overdue</span>':'<span class="text-warning">Pending</span>' !!} @elseif($reservation->reservation_status == 'rejected') <span class="text-danger">Rejected</span> @else <span class="text-danger">Cancelled</span> @endif
                                                </td>
                                                <td class="d-none d-sm-table-cell text-right">
                                                    @if($detail->room)<span class="badge badge-secondary">{{$detail->room->name}}</span>@endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route(($reservation->reservation_status=='pending' && $reservation->created_by==0) ? 'reservations-view-request':'reservations-edit',$reservation->id)}}" data-toggle="tooltip" data-placement="left" title="Manage">
                                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="block-content bg-body-light">
                        <div class="row items-push text-center w-100">
                            <div class="col-sm-4">
                                <dl class="mb-0">
                                    <dt class="font-size-h3 font-w700">
                                        @if($recent_count > $recent_count_yesterday)<i class="fa fa-arrow-up font-size-lg text-success"></i> @elseif($recent_count == $recent_count_yesterday)<i class="fa fa-arrow-right font-size-lg text-warning"></i> @else <i class="fa fa-arrow-down font-size-lg text-danger"></i> @endif {{$recent_count}}
                                    </dt>
                                    <dd class="text-muted mb-0">New Reservations</dd>
                                </dl>
                            </div>
                            <div class="col-sm-4">
                                <dl class="mb-0">
                                    <dt class="font-size-h3 font-w700">
                                        @if($count_sales > $count_sales_yesterday)<i class="fa fa-arrow-up font-size-lg text-success"></i> @elseif($count_sales == $count_sales_yesterday)<i class="fa fa-arrow-right font-size-lg text-warning"></i> @else <i class="fa fa-arrow-down font-size-lg text-danger"></i> @endif {{$count_sales}}
                                    </dt>
                                    <dd class="text-muted mb-0">Sales Today</dd>
                                </dl>
                            </div>
                            <div class="col-sm-4">
                                <dl class="mb-0">
                                    <dt class="font-size-h3 font-w700">
                                        @if($pending_sales > $pending_sales_yesterday)<i class="fa fa-arrow-up font-size-lg text-success"></i> @elseif($pending_sales == $pending_sales_yesterday)<i class="fa fa-arrow-right font-size-lg text-warning"></i> @else <i class="fa fa-arrow-down font-size-lg text-danger"></i> @endif {{$pending_sales}}
                                    </dt>
                                    <dd class="text-muted mb-0">Pending Sales</dd>
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
                                    <dt class="font-size-h3 font-w700">GH₵ {{number_format($sum_today,2)}}</dt>
                                    <dd class="text-muted mb-0">Today's Earnings</dd>
                                </dl>
                                <div>
                                    @if($sum_today > $sum_yesterday)
                                        <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-success bg-success-light">
                                            <i class="fa fa-caret-up mr-1"></i>
                                           {{ number_format((($sum_today-$sum_yesterday)/($sum_yesterday != 0 ? $sum_yesterday : 1))*100,2)}}%
                                        </div>
                                    @elseif($sum_today == $sum_yesterday)
                                        <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-warning bg-warning-light">
                                            <i class="fa fa-caret-right mr-1"></i>
                                            0.00%
                                        </div>
                                    @else
                                        <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-danger bg-danger-light">
                                            <i class="fa fa-caret-down mr-1"></i>
                                           {{ number_format((($sum_today-$sum_yesterday)/($sum_yesterday != 0 ? $sum_yesterday : 1))*100,2)}}%
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="block-content block-content-full block-content-sm font-size-sm">
                                <a class="font-w500 d-flex align-items-center" href="{{route('reservations-today')}}">
                                    View Reservations
                                    <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-12">
                        <div class="block block-rounded d-flex flex-column bg-{{$balance > 0 ? ($balance > 1000 ? 'danger' : 'warning') : 'success'}}-light">
                            <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between">
                                <dl class="mb-0">
                                    <dd class="text-muted mb-0">Balance Receivable</dd>
                                    <dt class="font-size-h3 font-w700">GH₵ {{number_format($balance,2)}}</dt>
                                    <span class="font-w600 text-{{$overall_balance > 0 ? ($overall_balance > 1000 ? 'danger' : 'warning') : 'success'}}">
                                        Total: ₵{{number_format($overall_balance,2)}}
                                    </span>
                                </dl>
                                <div>
                                    @if($balance < 0)
                                        <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-success-light bg-success">
                                            <i class="fa fa-caret-down mr-1"></i>
                                           {{ number_format((($overall_balance-($overall_balance-$balance))/(($overall_balance-$balance) != 0 ? ($overall_balance-$balance) : 1))*100,2)}}%
                                        </div>
                                    @elseif($balance == 0)
                                        <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-warning-light bg-warning">
                                            <i class="fa fa-caret-right mr-1"></i>
                                            0.00%
                                        </div>
                                    @else
                                        <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-danger-light bg-danger">
                                            <i class="fa fa-caret-up mr-1"></i>
                                           {{ number_format((($overall_balance-($overall_balance-$balance))/(($overall_balance-$balance) != 0 ? ($overall_balance-$balance) : 1))*100,2)}}%
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="block-content p-1 text-center oveflow-hidden">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="block block-rounded d-flex flex-column">
                            <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between">
                                <dl class="mb-0">
                                    <dt class="font-size-h3 font-w700">GH₵ {{number_format($sum_sales,2)}}</dt>
                                    <dd class="text-muted mb-0">Today's Sales</dd>
                                </dl>
                                <div>
                                    @if($sum_sales > $sum_sales_yesterday)
                                        <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-success bg-success-light">
                                            <i class="fa fa-caret-up mr-1"></i>
                                           {{ number_format((($sum_sales-$sum_sales_yesterday)/($sum_sales_yesterday != 0 ? $sum_sales_yesterday : 1))*100,2)}}%
                                        </div>
                                    @elseif($sum_sales == $sum_sales_yesterday)
                                        <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-warning bg-warning-light">
                                            <i class="fa fa-caret-right mr-1"></i>
                                            0.00%
                                        </div>
                                    @else
                                        <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-danger bg-danger-light">
                                            <i class="fa fa-caret-down mr-1"></i>
                                           {{ number_format((($sum_sales-$sum_sales_yesterday)/($sum_sales_yesterday != 0 ? $sum_sales_yesterday : 1))*100,2)}}%
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="block-content block-content-full block-content-sm font-size-sm">
                                <a class="font-w500 d-flex align-items-center" href="{{route('other.sales')}}">
                                    View Sales
                                    <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Last 2 Weeks -->
            </div>
        </div>
        <!-- END Statistics -->
        @can('view reservations')
            <div class="row">
                <div class="col-lg-12 d-flex flex-column">
                    <!-- Calendar -->
                    <div class="block block-rounded flex-grow-1 d-flex flex-column">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Calendar</h3>
                            <div class="block-options">

                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle" onclick="resizecalendar()"></button>
                                {{-- <button type="button" class="btn-block-option" data-toggle="block-option" data-action="pinned_toggle">
                                    <i class="si si-pin"></i>
                                </button> --}}
                                {{-- <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button> --}}
                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                            </div>
                        </div>
                        <div class="block-content block-content-full flex-grow-1 align-items-center" id="calendar">
                            <?php $all_calendar_reservations = $helper->get_calendar($callendar_reservation_list); ?>
                            @if(isset($calendar_reservation))
                                {!! $calendar_reservation->calendar() !!}
                            @else
                                {!! $all_calendar_reservations->calendar() !!}
                                {{-- {!! $all_calendar_reservations->script() !!} --}}
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

    @if(!isset($calendar_reservation))
        {!! $all_calendar_reservations->script() !!}
    @endif
    <script>
        function resizecalendar() {
            $('.fc-col-header').css('width', '100%');
            $('.fc-daygrid-body').css('width', '100%');
            $('.fc-scrollgrid-sync-table').css('width', '100%');
        }

    </script>

@endsection
