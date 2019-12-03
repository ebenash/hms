@extends('layouts.app')

@section('content')
    
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- Page Header -->
        <div class="content bg-image overflow-hidden" style="background-image: url('assets/img/photos/photo3@2x.jpg');">
            <div class="push-50-t push-15">
                <h1 class="h2 text-white animated zoomIn">Dashboard</h1>
                <h2 class="h5 text-white-op animated zoomIn">Welcome {{$current_user->role->role_name}}</h2>
            </div>
        </div>
        <!-- END Page Header -->

        <!-- Stats -->
        <div class="content bg-white border-b">
            <div class="row items-push text-uppercase">
                <div class="col-xs-6 col-sm-3">
                    <div class="font-w700 text-gray-darker animated fadeIn">Reservation Earnings</div>
                    <div class="text-muted animated fadeIn"><small><i class="si si-calendar"></i> Today</small></div>
                    <a class="h2 font-w300 text-primary animated flipInX" href="{{url('/accounting')}}">GHS {{number_format($reservations_data['sum_today'],2)}}</a>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="font-w700 text-gray-darker animated fadeIn">Reservation Earnings</div>
                    <div class="text-muted animated fadeIn"><small><i class="si si-calendar"></i> This Month</small></div>
                    <a class="h2 font-w300 text-primary animated flipInX" href="{{url('/accounting')}}">GHS {{number_format($reservations_data['sum_monthly'],2)}}</a>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="font-w700 text-gray-darker animated fadeIn">Total Earnings</div>
                    <div class="text-muted animated fadeIn"><small><i class="si si-calendar"></i> All Time</small></div>
                    <a class="h2 font-w300 text-primary animated flipInX" href="{{url('/accounting')}}">GHS {{number_format($all_reservations->where('reservation_status',1)->sum('price'),2)}}</a>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <div class="font-w700 text-gray-darker animated fadeIn">Total Prospective Earnings</div>
                    <div class="text-muted animated fadeIn"><small><i class="si si-calendar"></i> All Time</small></div>
                    <a class="h2 font-w300 text-primary animated flipInX" href="{{url('/accounting')}}">GHS {{number_format($all_reservations->where('reservation_status','<',2)->sum('price'),2)}}</a>
                    <div class="text-muted animated fadeIn"><small>out of a possible GHS {{number_format($all_reservations->sum('price'),2)}}</small></div>
                </div>
            </div>
        </div>
        <!-- END Stats -->

        <!-- Page Content -->
        <div class="content">

            <div class="row">
                <div class="col-lg-8">
                    <div class="block">
                        <div class="block-header">
                            <ul class="block-options">
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Reservation Calendar</h3>
                        </div>
                        <div class="block-content">
                            <?php $all_calendar_reservations = Calendar::addEvents($callendar_reservation_list); ?>
                            {!! $all_calendar_reservations->calendar() !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Latest Sales Widget -->
                    <div class="block">
                        <div class="block-header">
                            <ul class="block-options">
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="refresh_toggle" data-action-mode="demo"><i class="si si-refresh"></i></button>
                                </li>
                            </ul>
                            <h3 class="block-title">Confirmed Reservations</h3>
                        </div>
                        <div class="block-content bg-gray-lighter">
                            <div class="row items-push">
                                <div class="col-xs-4">
                                    <div class="text-muted"><small><i class="si si-calendar"></i> Today</small></div>
                                    <div class="font-w600">{{$reservations_data['count_today']}} Confirmed Reservations</div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="text-muted"><small><i class="si si-calendar"></i> This Week</small></div>
                                    <div class="font-w600">{{$reservations_data['count_sevenday']}} Confirmed Reservations</div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="text-muted"><small><i class="si si-calendar"></i> This Month</small></div>
                                    <div class="font-w600">{{$reservations_data['count_monthly']}} Confirmed Reservations</div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="pull-t pull-r-l">
                                <!-- Slick slider (.js-slider class is initialized in App() -> uiHelperSlick()) -->
                                <!-- For more info and examples you can check out http://kenwheeler.github.io/slick/ -->
                                <div class="js-slider remove-margin-b" data-slider-autoplay="true" data-slider-autoplay-speed="2500">
                                    <div>
                                        <table class="table remove-margin-b font-s13">
                                            <tbody>
                                                @foreach($reservations_data['recent_reservations'] as $reservation)
                                                <tr>
                                                    <td class="font-w600">
                                                    <a href="javascript:void(0)">{{$reservation->room->name."-".$reservation->guest->first_name}}</a>
                                                    </td>
                                                <td class="hidden-xs text-muted text-right" style="width: 150px;">Check in: {{$reservation->check_in}}</td>
                                                <td class="font-w600 text-success text-right" style="width: 120px;">+ GH₵ {{$reservation->price}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- END Slick slider -->
                            </div>
                        </div>
                    </div>
                    <!-- END Latest Sales Widget -->
                </div>
            </div>
        </div>
        <!-- END Page Content -->
           
@endsection
