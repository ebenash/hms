@extends('layouts.app')
@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        @if(isset($create))
            Add New Reservation
        @elseif(isset($update))
            Edit Reservation
        @elseif(isset($request))
            Reservation Request Details
        @else
            Reservation Details
        @endif
    </h1>
@endsection
@section('content')

@section('content')
    @if(isset($request))
        <style type="text/css">
            .select2-container--default{
                border-radius: 5px;
                border: 1px solid red;
            }
        </style>
    @endif
    @if(!isset($show))
        <form method="post" action="{{isset($create) ? route('reservations-store') : (isset($update) ? route('reservations-update',$reservation->id) : route('reservations-update-request',$reservation->id))}}" class="form-horizontal push-10-t">
            @csrf
    @endif
            <div class="row">
                <div class="col-lg-6 d-flex flex-column">
                    <div class="block block-rounded flex-grow-1 d-flex flex-column">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Guest Details</h3>
                        </div>
                        <div class="block-content block-content-full d-flex align-items-center row">

                            <div class="form-row mb-2 col-lg-12">
                                <div class="">Full Name: <b>{{$guest->full_name ?? $reservation->guest->full_name}}</b></div>
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <div class="">Email: <b>{{$guest->email ?? $reservation->guest->email}}</b></div>
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <div class="">Phone: <b>{{$guest->phone ?? $reservation->guest->phone}}</b></div>
                            </div>
                            {{-- <div class="form-row mb-2 col-lg-12">
                                <div class="">City: <b>{{$guest->city ?? ($reservation->guest->city ?? "Not Specified")}}</b></div>
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <div class="{}">Country: <b>{{$guest->country ?? ($reservation->guest->country ?? "Not Specified")}}</b></div>
                            </div> --}}
                            <input type="hidden" name="guest_id" id="guest_id" value="{{$guest->id ?? $reservation->guest->id}}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex flex-column">
                    <!-- Reservation Details -->
                    <div class="block block-rounded flex-grow-1 d-flex flex-column">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{isset($reservation) ? 'Invoice Number: #'.$reservation->id : ''}}</h3>
                        </div>
                        <div class="block-content block-content-full flex-grow-1 d-flex align-items-center row">
                            {{-- <div class="form-row mb-2 col-lg-12">
                                <label for="check_in">Check In Date</label>
                                <input type="text" class="review-old-flatpickr form-control {{isset($show) ? '':(isset($request) ? '':'bg-white') }}" id="check_in" name="check_in" placeholder="Choose check-in date.." {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} data-min-date="today" value="{{isset($reservation) ? date_format(date_create($reservation->check_in),'Y-m-d') : ''}}" autocomplete="off">
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <label for="check_out">Check Out Date</label>
                                <input type="text" class="review-old-flatpickr form-control {{isset($show) ? '':(isset($request) ? '':'bg-white') }}" id="check_out" name="check_out" placeholder="Choose check-out date.." {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} data-min-date="today" value="{{isset($reservation) ? date_format(date_create($reservation->check_out),'Y-m-d') : ''}}" autocomplete="off">
                            </div> --}}
                            <div class="form-row mb-2 col-lg-12">
                                <label for="check_out">Reservation Dates</label>
                                <input type="text" class="review-old-flatpickr form-control {{isset($show) || isset($request) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? '':'bg-white' }}" id="reservation_daterange" name="reservation_daterange" placeholder="Choose check-out and check-out date range.." {!!(isset($show) || isset($request) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed')) ? 'readonly style="pointer-events: none;" tabindex="-1"':'required' !!} data-min-date="today" value="{{isset($reservation) ? date_format(date_create($reservation->check_in),'Y-m-d').' to '.date_format(date_create($reservation->check_out),'Y-m-d')  : ''}}" placeholder="Select Date Range" data-mode="range" autocomplete="off">
                                 {{-- data-min-date="today"> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="roomdiv">
                @if(!isset($create))
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($distinctdetails as $detail)
                        <div class="col-lg-12 d-flex flex-column roombox">
                            <!-- Reservation Details -->
                            <div class="block block-rounded flex-grow-1 d-flex flex-column">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Room Details</h3>
                                </div>
                                <div class="block-content block-content-full flex-grow-1 d-flex row">
                                    <div class="col-lg-8 d-flex flex-column">
                                        <div class="row">

                                            <div class="form-row mb-2 col-lg-12">
                                                <label for="room_type">Room Type</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="room_type{{$i}}" data-placeholder="Select Room Type.." name="room_type{{$i}}" onchange="getRooms({{$i}})" {!!isset($show) || isset($request)  || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly style="pointer-events: none;" tabindex="-1"':'' !!} autocomplete="off">
                                                        <option>Select Room Type</option>
                                                        @foreach($all_roomtypes->where('status',0) as $roomtype)
                                                            <option value="{{$roomtype->id}}" @if(($detail->room_type_id ?? null) == $roomtype->id) selected="selected" @endif >{{$roomtype->name ?? 'Undefined Room Type'}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row col-lg-12 mb-2">
                                                <label for="room">Select Room(s)</label>
                                                <div class="input-group">
                                                    <select class="form-control" data-placeholder="Select Room Type First" name="{{isset($create) || isset($update) ? 'room'.$i.'[]': 'room'.$i }}" id="room{{$i}}" {!! isset($create) || isset($update) ? 'multiple required': (isset($show) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'multiple readonly style="pointer-events: none;" tabindex="-1"': (strtotime($reservation->check_in) >= strtotime(date('Y-m-d', strtotime('-5 days'))) ? 'required':'disabled')) !!} style="{{(isset($request) ? "border: 1px solid red !important;":'')}}" autocomplete="off">

                                                        @if(isset($create))
                                                        @elseif(isset($request))
                                                        <option value="">Select Room</option>
                                                            @foreach($req_rooms as $room)
                                                                <option value="{{$room->id}}" {{$room->id == $detail->room_id ? 'selected' : ''}}>{{$room->name}}</option>
                                                            @endforeach
                                                        @else
                                                            {{-- <option>Select Room</option> --}}
                                                            @php
                                                                $selectedrooms = [];
                                                            @endphp
                                                            @foreach ($reservation->details as $room)
                                                                @php
                                                                    $selectedrooms[] = $room->room_id;
                                                                @endphp
                                                            @endforeach
                                                            @if(isset($detail->roomtype->rooms))
                                                                @foreach($detail->roomtype->rooms as $room)
                                                                    <option value="{{$room->id}}" {{in_array($room->id,$selectedrooms) ? 'selected' : ''}}>{{$room->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row mb-2 col-lg-12">
                                                <label for="price">Room Price Per Day <span id="roomnums{{$i}}"></span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text input-group-text-alt">
                                                            {{$current_user->company->currency}}
                                                        </span>
                                                    </div>
                                                    <input type="number" step="0.01" id="price_per_day{{$i}}" name="price_per_day{{$i}}" class="form-control text-center" onkeyup="pricePerDay({{$i}})" value="{{$detail->price_per_day ?? ''}}" {{isset($show) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly':(isset($request) ? (strtotime($reservation->check_in) >= strtotime(date('Y-m-d')) ? 'required':'disabled') : 'required') }}  style="{{(isset($request) ? "border: 1px solid red !important;":'')}}" placeholder="Room Price Per Day" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-flex flex-column">
                                        <div class="row">

                                            <div class="form-row mb-4 col-lg-12">
                                                <label for="adults{{$i}}">Adults</label>
                                                <input type="number" class="form-control" id="adults{{$i}}" name="adults{{$i}}" placeholder="Adults" {{isset($show) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly':(isset($request) ? 'disabled':'required') }} value="{{$detail->adults ?? 0}}" autocomplete="off">
                                            </div>
                                            <div class="form-row mb-4 col-lg-12">
                                                <label for="children{{$i}}">Children</label>
                                                <input type="number" class="form-control" id="children{{$i}}" name="children{{$i}}" placeholder="Children" {{isset($show) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly':(isset($request) ? 'disabled':'required') }} value="{{$detail->children ?? 0}}" autocomplete="off">
                                            </div>


                                            <div class="form-row mb-4 col-lg-12">
                                                <label for="total_price{{$i}}">Room Total For <span id="resdays{{$i}}">{{$reservation->days ?? 'Specified'}}</span> Day(s)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text input-group-text-alt">
                                                            {{$current_user->company->currency}}
                                                        </span>
                                                    </div>
                                                    <input type="number" step="0.01" id="total_price{{$i}}" name="total_price{{$i}}" class="form-control text-center" value="{{$detail->total_price ?? 0}}" readonly placeholder="Total Amount" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text input-group-text-alt">
                                                            <i class="fa fa-calculator"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Reservation Details -->
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @endif
            </div>
            <div class="row" id="rentaldiv">
                @if(!isset($create))
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($reservation->rentals as $rental)
                        <div class="col-lg-12 d-flex flex-column rentalbox">
                            <!-- Reservation Details -->
                            <div class="block block-rounded flex-grow-1 d-flex flex-column">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Rental Details</h3>
                                </div>
                                <div class="block-content block-content-full flex-grow-1 d-flex align-items-center row">
                                    <div class="col-lg-6 d-flex flex-column">
                                        <div class="row">
                                            <div class="form-row col-lg-12 mb-2">
                                                <label for="rental_description{{$i}}">Rental Description</label>
                                                <div class="input-group">
                                                    <input type="text" id="rental_description{{$i}}" name="rental_description{{$i}}" class="form-control" value="{{$rental->description ?? ''}}" placeholder="Rental Description" {{isset($show) ||isset($request) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly':'' }} autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-row mb-2 col-lg-6">
                                                <label for="rental_type">Rental Type</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="rental_type{{$i}}" data-placeholder="Select Rental Type.." name="rental_type{{$i}}" {!! isset($show) || isset($request) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly style="pointer-events: none;" tabindex="-1"':'' !!} autocomplete="off">
                                                        <option>Select Rental Type</option>
                                                        <option value="grounds" {{$rental->rental_type == 'grounds' ? 'selected' : ''}}>Rent Lawn Grounds</option>
                                                        <option value="poolside" {{$rental->rental_type == 'poolside' ? 'selected' : ''}}>Rent Poolside</option>
                                                        <option value="chairs" {{$rental->rental_type == 'chairs' ? 'selected' : ''}}>Rent Chairs</option>
                                                        <option value="tables" {{$rental->rental_type == 'tables' ? 'selected' : ''}}>Rent Tables</option>
                                                        <option value="canopies" {{$rental->rental_type == 'canopies' ? 'selected' : ''}}>Rent Canopies</option>
                                                        <option value="other" {{$rental->rental_type == 'other' ? 'selected' : ''}}>Rent Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row mb-2 col-lg-6">
                                                <label for="rental_quantity{{$i}}">Quantity</label>
                                                <input type="number" class="form-control" id="rental_quantity{{$i}}" name="rental_quantity{{$i}}" value="{{$rental->quantity ?? '1'}}" placeholder="Quantity" required  {{isset($show) || isset($request) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly':'' }} autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 d-flex flex-column">
                                        <div class="row">
                                            <div class="form-row mb-2 col-lg-12">
                                                <label for="rental_price">Item Price Per Day</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text input-group-text-alt">
                                                            {{$current_user->company->currency}}
                                                        </span>
                                                    </div>
                                                    <input type="number" step="0.01" id="rental_price_per_day{{$i}}" name="rental_price_per_day{{$i}}" class="form-control text-center" onkeyup="rentalPricePerDay({{$i}})" value="{{$rental->price ?? ''}}" {{isset($show) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly':(isset($request) ? (strtotime($reservation->check_in) >= strtotime(date('Y-m-d')) ? 'required':'disabled') : 'required') }}  style="{{(isset($request) ? "border: 1px solid red !important;":'')}}" placeholder="Item Price Per Day" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-row mb-2 col-lg-12">
                                                <label for="rental_total_price{{$i}}">Total For <span id="resdays{{$i}}">{{$reservation->days ?? 'Specified'}}</span> Day(s)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text input-group-text-alt">
                                                            {{$current_user->company->currency}}
                                                        </span>
                                                    </div>
                                                    <input type="number" step="0.01" id="rental_total_price{{$i}}" name="rental_total_price{{$i}}" class="form-control text-center" value="{{$rental->total_price ?? 0}}" readonly placeholder="Total Amount" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text input-group-text-alt">
                                                            <i class="fa fa-calculator"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Reservation Details -->
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @endif
            </div>
            <div class="row" id="expensediv">
                @if(!isset($create))
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($reservation->expenses as $expense)
                        <div class="col-lg-12 d-flex flex-column expensebox">
                            <!-- Reservation Details -->
                            <div class="block block-rounded flex-grow-1 d-flex flex-column">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Additional Sale Details</h3>
                                </div>
                                <div class="block-content block-content-full flex-grow-1 d-flex align-items-center row">
                                    <div class="col-lg-6 d-flex flex-column">
                                        <div class="row">
                                            <div class="form-row col-lg-12 mb-2">
                                                <label for="expense_description{{$i}}">Sale Description</label>
                                                <div class="input-group">
                                                    <input type="text" id="expense_description{{$i}}" name="expense_description{{$i}}" class="form-control" value="{{$expense->description ?? ''}}" placeholder="Sale Description" {{isset($show) || isset($request) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly':'' }} autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-row mb-2 col-lg-6">
                                                <label for="expense_type">Sale Type</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="expense_type{{$i}}" data-placeholder="Select Sale Type.." name="expense_type{{$i}}" {!! isset($show) || isset($request) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly style="pointer-events: none;" tabindex="-1"':'' !!} autocomplete="off">
                                                        <option>Select Sale Type</option>
                                                        <option value="food" {{$expense->expense_type == 'food' ? 'selected' : ''}}>Food</option>
                                                        <option value="drinks" {{$expense->expense_type == 'drinks' ? 'selected' : ''}}>Drinks</option>
                                                        <option value="other" {{$expense->expense_type == 'other' ? 'selected' : ''}}>Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row mb-2 col-lg-6">
                                                <label for="expense_quantity{{$i}}">Quantity</label>
                                                <input type="number" class="form-control" id="expense_quantity{{$i}}" name="expense_quantity{{$i}}" value="{{$expense->quantity ?? '1'}}" placeholder="Quantity" required  {{isset($show) || isset($request) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly':'' }} autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 d-flex flex-column">
                                        <div class="row">
                                            <div class="form-row mb-2 col-lg-12">
                                                <label for="expense_price">Item Price <span id="roomnums{{$i}}"></span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text input-group-text-alt">
                                                            {{$current_user->company->currency}}
                                                        </span>
                                                    </div>
                                                    <input type="number" step="0.01" id="expense_price{{$i}}" name="expense_price{{$i}}" class="form-control text-center" onkeyup="expensePrice({{$i}})" value="{{$expense->price ?? ''}}" {{isset($show) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly':(isset($request) ? (strtotime($reservation->check_in) >= strtotime(date('Y-m-d')) ? 'required':'disabled') : 'required') }}  style="{{(isset($request) ? "border: 1px solid red !important;":'')}}" placeholder="Item Price" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-row mb-2 col-lg-12">
                                                <label for="expense_total_price{{$i}}">Total For <span id="resdays{{$i}}">{{$reservation->days ?? 'Specified'}}</span> Day(s)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text input-group-text-alt">
                                                            {{$current_user->company->currency}}
                                                        </span>
                                                    </div>
                                                    <input type="number" step="0.01" id="expense_total_price{{$i}}" name="expense_total_price{{$i}}" class="form-control text-center" value="{{$expense->total_price ?? 0}}" readonly placeholder="Total Amount" autocomplete="off">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text input-group-text-alt">
                                                            <i class="fa fa-calculator"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Reservation Details -->
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @endif
            </div>
            @if(!isset($show))
                @if(isset($reservation) && (strtotime($reservation->check_in) < strtotime(date('Y-m-d', strtotime('-5 days')))))
                @elseif(isset($request))
                @else
                <div class="text-center">
                            <div style="display: inline-block;" id="roombutton">
                                <a href="#" class="btn btn-sm btn-primary mb-4" id="add-roombox"><i class="fa fa-plus"></i> Add Room</a>
                            </div>
                            <div style="display: inline-block;" id="rentalbutton">
                                <a href="#" class="btn btn-sm btn-info mb-4" id="add-rentalbox"><i class="fa fa-plus"></i> Add Rental</a>
                            </div>
                            <div style="display: {{isset($create) ? 'none' : 'inline-block'}};" id="expensesbutton">
                                <a href="#" class="btn btn-sm btn-secondary mb-4" id="add-expensebox"><i class="fa fa-plus"></i> Additional Sale</a>
                            </div>
                        </div>
                @endif
            @endif
            <div class="row">
                <div class="col-lg-12 d-flex flex-column">
                    <!-- Reservation Details -->
                    <div class="block block-rounded flex-grow-1 d-flex flex-column">
                        <div class="block-header block-header-default">
                            <h3 class="block-title"></h3>
                        </div>
                        <div class="block-content block-content-full flex-grow-1 d-flex align-items-center row">

                            <input type="hidden" name="roomtypecount" id="roomtypecount" value="0" autocomplete="off">
                            <input type="hidden" name="rentaltypecount" id="rentaltypecount" value="0" autocomplete="off">
                            <input type="hidden" name="expensetypecount" id="expensetypecount" value="0" autocomplete="off">

                            <div class="form-row mb-2 col-lg-6">
                                <div class="form-row mb-2 col-lg-12">
                                    <label for="discount">Grand Total For {{$reservation->days ?? 'Specified'}} Day(s)</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text input-group-text-alt">
                                                {{$current_user->company->currency}}
                                            </span>
                                        </div>
                                        <input type="hidden" name="currency" value="{{$current_user->company->currency}}">
                                        <input type="number" step="0.01" id="grand_total" name="grand_total" class="form-control text-center" value="{{$reservation->grand_total ?? ''}}" readonly placeholder="0.00" style="height:90px;font-size:40pt;" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text input-group-text-alt">
                                                <i class="fa fa-calculator"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mb-2 col-lg-12">
                                    <label for="price">Amount Paid</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text input-group-text-alt">
                                                {{$current_user->company->currency}}
                                            </span>
                                        </div>
                                        <input type="number" step="0.01" id="amount_paid" name="amount_paid" class="form-control text-center" onkeyup="calculateBalance()" value="{{$reservation->amount_paid ?? 0}}" {{isset($show) ? 'disabled':(isset($request) ? 'readonly' : 'required') }} placeholder="Total Deposit Received" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-row mb-2 col-lg-12">
                                    <label for="balance">Balance Remaining</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text input-group-text-alt">
                                                {{$current_user->company->currency}}
                                            </span>
                                        </div>
                                        <input type="hidden" name="currency" value="{{$current_user->company->currency}}">
                                        <input type="number" step="0.01" id="balance" name="balance" class="form-control text-center" value="{{$reservation->balance ?? 0}}" readonly placeholder="Grand Total - Amount Paid" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text input-group-text-alt">
                                                <i class="fa fa-calculator"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mb-2 col-lg-12 row">
                                    <div class="col-lg-{{isset($reservation) && ($reservation->payment_method == 'expedia' || $reservation->payment_method == 'booking.com') ? '6':'12 pr-0'}} pl-0" id="vatdiv">
                                        <label for="vat_invoice_number">Receipt Number</label>
                                        <input type="text" class="form-control" id="vat_invoice_number" name="vat_invoice_number" placeholder="Receipt/VAT Invoice Number" {{isset($show) || isset($request) ? 'disabled': '' }} value="{{$reservation->vat_invoice_number ?? ''}}" autocomplete="off">
                                    </div>
                                    <div class="col-lg-6 pr-0" id="otadiv" style="display: {{isset($reservation) && ($reservation->payment_method == 'expedia' || $reservation->payment_method == 'booking.com') ? 'block':'none'}};">
                                        <label for="ota_reservation_number">Reservation Number</label>
                                        <input type="text" class="form-control" id="ota_reservation_number" name="ota_reservation_number" placeholder="OTA Reservation Number" {{isset($show) || isset($request) ? 'disabled': '' }} value="{{$reservation->ota_reservation_number ?? ''}}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 col-lg-6">
                                <div class="form-row mb-2 col-lg-12">
                                    <label for="payment_type">Payment Method</label>
                                    <select name="payment_type" id="payment_type" class="form-control" {!! isset($show) || isset($request) || (!auth()->user()->hasRole(['administrator']) && isset($reservation) && $reservation->reservation_status == 'confirmed') ? 'readonly style="pointer-events: none;" tabindex="-1"':'required' !!} onchange="restrictIfPaystackOTA({{ isset($reservation) ? $reservation->payment_method : NULL }})" autocomplete="off">
                                        <option value="">Select Payment Method</option>
                                        <option value="paystack" @if(isset($reservation)) {{$reservation->payment_method == 'paystack' ? 'selected="selected"' : ''}} @endif>Send Paystack Invoice</option>
                                        <option value="cash" @if(isset($reservation)) {{$reservation->payment_method == 'cash' ? 'selected="selected"' : ''}} @endif>Cash Payment</option>
                                        <option value="momo" @if(isset($reservation)) {{$reservation->payment_method == 'momo' ? 'selected="selected"' : ''}} @endif>Mobile Money</option>
                                        <option value="pos" @if(isset($reservation)) {{$reservation->payment_method == 'pos' ? 'selected="selected"' : ''}} @endif>Card POS</option>
                                        <option value="bank" @if(isset($reservation)) {{$reservation->payment_method == 'bank' ? 'selected="selected"' : ''}} @endif>Bank Payment</option>
                                        <option value="expedia" @if(isset($reservation)) {{$reservation->payment_method == 'expedia' ? 'selected="selected"' : ''}} @endif>Expedia</option>
                                        <option value="booking.com" @if(isset($reservation)) {{$reservation->payment_method == 'booking.com' ? 'selected="selected"' : ''}} @endif>Booking.com (Payment On Arrival)</option>
                                        <option value="complementary" @if(isset($reservation)) {{$reservation->payment_method == 'complementary' ? 'selected="selected"' : ''}} @endif>Complementary</option>
                                    </select>
                                </div>
                                <div class="form-row mb-2 col-lg-12">
                                    <label for="status">Reservation Status</label>
                                    <select name="status" id="status" class="form-control" {!! isset($show) || isset($request) || (isset($reservation) && ((!auth()->user()->hasRole(['administrator']) && $reservation->reservation_status == 'confirmed') && ($reservation->payment_method != 'expedia' && $reservation->payment_method != 'booking.com'))) ? 'readonly style="pointer-events: none;" tabindex="-1"':'required' !!} autocomplete="off">
                                        @if(!isset($reservation))
                                            <option value="">Select Status</option>
                                            <option value="pending" @if(isset($reservation)) {{$reservation->reservation_status == 'pending' ? 'selected="selected"' : ''}} @endif>Pending Approval</option>
                                        @elseif(isset($reservation) && $reservation->reservation_status != 'confirmed')
                                            <option value="">Select Status</option>
                                            <option value="pending" @if(isset($reservation)) {{$reservation->reservation_status == 'pending' ? 'selected="selected"' : ''}} @endif>Pending Approval</option>
                                        @endif
                                        <option value="confirmed" @if(isset($reservation)) {{$reservation->reservation_status == 'confirmed' ? 'selected="selected"' : ''}} @endif>Reservation Confirmed</option>
                                        @if (!isset($create))
                                            <option value="cancelled" @if(isset($reservation)) {{$reservation->reservation_status == 'cancelled' ? 'selected="selected"' : ''}} @endif>Reservation Cancelled</option>
                                            <option value="rejected" @if(isset($reservation)) {{$reservation->reservation_status == 'rejected' ? 'selected="selected"' : ''}} @endif>Reservation Rejected</option>
                                        @endif
                                    </select>
                                </div>
                                @if (isset($request) && $reservation->invoice_sent == false)
                                    <div class="form-row mb-2 col-lg-12">
                                        <label for="hotelresponse">Hotel Response</label>
                                        <select name="hotelresponse" class="form-control" required style="border: 1px solid red !important;" autocomplete="off">
                                            <option value="">Select Hotel Response</option>
                                            <option value="approve">Approve And Send Invoice To Guest</option>
                                            <option value="reject">Reject Reservation Request</option>
                                        </select>
                                    </div>
                                @else
                                    <div class="form-row mb-2 col-lg-12">
                                        <label for="notes">Notes</label>
                                        <input type="text" class="form-control" id="notes" name="notes" placeholder="Notes" {{isset($show) ? 'disabled': '' }} value="{{$reservation->notes ?? ''}}" autocomplete="off">
                                    </div>
                                @endif
                                <div class="form-row mb-2 col-lg-12">
                                    <label for="signed_by">Signed By</label>
                                    <input type="text" class="form-control" id="signed_by" name="signed_by" placeholder="{{isset($show) || isset($update) ? 'Last':''}} Signed By {{$reservation->signed_by ?? ''}}" {{isset($show) ? 'disabled': '' }} required value="" style="{{(isset($request) ? "border: 1px solid red !important;":'')}}" autocomplete="off">
                                </div>
                                @if(!isset($show))
                                    @if(isset($reservation) && (strtotime($reservation->check_in) < strtotime(date('Y-m-d', strtotime('-10 days')))))
                                    @else
                                        <div class="form-row mt-2 col-lg-12 pull-right">
                                            <button class="btn btn-primary btn-lg btn-block" type="submit">{{isset($request) ? ($reservation->invoice_sent ? 'Update Request' : 'Send Request Reply') : (isset($update) ? 'Update Reservation' : 'Save Reservation')}}</button>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- END Reservation Details -->
                </div>
            </div>
    @if(!isset($show))
        </form>
    @endif

@endsection

@section('css_after')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
    <link rel="stylesheet" href="{{asset('js/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('js/plugins/flatpickr/flatpickr.min.css')}}">
    <style>
        .select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 38px !important;
}
.select2-selection__arrow {
    height: 36px !important;
}


    </style>

@endsection
@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('js/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('js/plugins/flatpickr/flatpickr.min.js')}}"></script>

    <!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Inputs + Ion Range Slider plugins) -->
    <script>jQuery(function(){One.helpers(['flatpickr', 'datepicker', 'select2']);});</script>


    @if(isset($reservation) && $reservation->reservation_status == 'confirmed')
        <script>
             console.log("Confirmed");
        </script>
    @else
        <script>
            console.log("Not Confirmed");
        $(function () {
            restrictIfPaystack();
        });
    </script>
    @endif
    <script>
        function restrictIfPaystack() {
            var paymenttype = $("#payment_type").val();
            console.log(paymenttype);
            if (paymenttype == 'paystack') {
                $("#status").val("pending").attr('readonly','readonly').attr("style", "pointer-events: none;").attr("tabindex","-1");
                $("#vatdiv").removeClass('col-lg-6').addClass("col-lg-12");
                $("#otadiv").hide();
            }
        }
        function restrictIfPaystackOTA(selectval) {
            var paymenttype = $("#payment_type").val();
            console.log(paymenttype);
            if (paymenttype == 'paystack') {
                $("#status").val("pending").attr('readonly','readonly').attr("style", "pointer-events: none;").attr("tabindex","-1");
                $("#vatdiv").removeClass('col-lg-6').addClass("col-lg-12");
                $("#otadiv").hide();
            }else if (paymenttype == 'expedia' || paymenttype == 'booking.com') {
                $("#status").val("confirmed").attr('readonly','readonly').attr("style", "pointer-events: none;").attr("tabindex","-1");
                $("#vatdiv").removeClass('col-lg-12').addClass("col-lg-6");
                $("#otadiv").show();
            }else{
                $("#status").val(selectval);
                $("#status").removeAttr('readonly','readonly').removeAttr("style", "pointer-events: none;").removeAttr("tabindex","-1");
                $("#vatdiv").removeClass('col-lg-6').addClass("col-lg-12");
                $("#otadiv").hide();
            }
        }

        function pricePerDay(index){
            if($("#room"+index+" :selected").length < 1){
                swalnotify("Error!", "Please Select Room(s) First","error");
            }else{
                var price = $("#price_per_day"+index).val();
                var dates = ($("#reservation_daterange").val()).split(' to ');
                // console.log(dates);
                var date1 = new Date(dates[0]);
                var date2 = new Date(dates[1]);

                // To calculate the time difference of two dates
                var timediff = date2.getTime() - date1.getTime();
                // console.log($("#room"+index).val());

                // To calculate the no. of days between two dates
                var daydiff = timediff / (1000 * 3600 * 24);
                $("#resdays"+index).html(daydiff);
                var roomcount = $("#room"+index+" :selected").length;
                $("#roomnums"+index).html("("+roomcount+" room(s) selected)");
                var totalprice = roomcount * (price * daydiff);
                // console.log(daydiff);

                $('#total_price'+index).val(totalprice);
                getGrandTotal();
                calculateBalance();
            }

        }

        function rentalPricePerDay(index){
            var price = $("#rental_price_per_day"+index).val();
            var quantity = $("#rental_quantity"+index).val();
            var dates = ($("#reservation_daterange").val()).split(' to ');

            var date1 = new Date(dates[0]);
            var date2 = new Date(dates[1]);

            // To calculate the time difference of two dates
            var timediff = date2.getTime() - date1.getTime();

            // To calculate the no. of days between two dates
            var daydiff = timediff / (1000 * 3600 * 24);
            $("#resdays"+index).html(daydiff);
            var totalprice = quantity * (price * daydiff);
            // console.log(quantity);

            $('#rental_total_price'+index).val(totalprice);
            getGrandTotal();
            calculateBalance();
        }

        function expensePrice(index){
            var price = $("#expense_price"+index).val();
            var quantity = $("#expense_quantity"+index).val();

            var totalprice = quantity * price;
            // console.log(totalprice);
            $('#expense_total_price'+index).val(totalprice);
            getGrandTotal();
            calculateBalance();
        }

        function getGrandTotal() {
            var roomdivcount = +$('.roombox').length;
            var rentaldivcount = +$('.rentalbox').length;
            var expensedivcount = +$('.expensebox').length;

            var grandtotal = 0;
            // console.log(expensedivcount);
            for (let index = 1; index < roomdivcount+1; index++)
            {
                grandtotal = +grandtotal + +$('#total_price'+index).val();
            }
            for (let index = 1; index < rentaldivcount+1; index++)
            {
                grandtotal = +grandtotal + +$('#rental_total_price'+index).val();
            }
            for (let index = 1; index < expensedivcount+1; index++)
            {
                grandtotal = +grandtotal + +$('#expense_total_price'+index).val();
            }
            $('#grand_total').val(grandtotal);
        }

        function markSelectedRooms() {
            var divcount = +$('#roomtypecount').val();
            var selected = [];
            for (let index = 1; index < divcount+1; index++)
            {
                selected.push(+$('#room_type'+index).val());
            }
            return selected;
        }

        var today = new Date();
        $('.review-old-flatpickr').flatpickr({ minDate: (today.setDate(today.getDate()-10)) })


        function getRooms(index) {
            var room_type = $("#room_type"+index).val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/admin/rooms/getrooms/'+room_type,
                type: 'POST',
                // data: {client_id: client_id, service_id: selected},
                success: function (results) {
                    console.log(results);
                    if (results) {
                        $("#room"+index).html("");
                        // let roomoption = new Option("Select a Room","");
                        // $(roomoption).html("Select a Room");
                        // $("#room").append(roomoption);

                        results.forEach(function (room) {
                            let option = new Option(room.name,room.id);
                            $(option).html(room.name,room.id);
                            $("#room"+index).append(option);
                        });
                    }
                }.bind(this)
            })
        }

        function calculateBalance() {
            var balance = +$('#grand_total').val() - + $("#amount_paid").val()
            $('#balance').val(balance)
        }
        // searchNode.disabled = false;
        // subSelectNode.disabled = true;

        $(document.body).on('click', '.changeType', function () {
            $(this).closest('.roombox').find('.type-text').text($(this).text());
            $(this).closest('.roombox').find('.type-input').val($(this).data('type-value'));
        });

        $(document.body).on('click', '.btn-remove-roomdiv', function () {
            $(this).closest('.roombox').remove();
            swaltoast("Success", "Room Type Form Removed", "success");
            if($('.roombox').length < 1){
                $('#expensesbutton').hide();
                // $('#rentalbutton').css('display', 'inline-block');
            }
        });
        $(document.body).on('click', '.btn-remove-rentaldiv', function () {
            swaltoast("Success", "Rental Form Removed", "success");
            $(this).closest('.rentalbox').remove();
            if($('.rentalbox').length < 1){
                $('#expensesbutton').hide();
                // $('#roombutton').css('display', 'inline-block');
            }
        });
        $(document.body).on('click', '.btn-remove-expensediv', function () {
            swaltoast("Success", "Sale Form Removed", "success");
            $(this).closest('.expensebox').remove();
            if($('.expensebox').length < 1){
                $('#expensesbutton').hide();
                // $('#roombutton').css('display', 'inline-block');
                // $('#rentalbutton').css('display', 'inline-block');
            }
        });

        $('#roomtypecount').val($('.roombox').length);

        $('#add-roombox').click(function () {

            if(!$('#reservation_daterange').val()){
                swalnotify("Error!", "Please Enter Reservation Dates First","error");
            }else{
                swaltoast("Success", "New Room Type Form Added", "success");
                var dates = ($("#reservation_daterange").val()).split(' to ');
                // console.log(dates);
                var check_in = new Date(dates[0]);
                var check_out = new Date(dates[1]);

                if(dates[1] === undefined || (check_in.getTime() >= check_out.getTime())){
                    swalnotify("Error!", "Check-out date value must be after the Check-in date.","error");
                    $('#roomdiv').html("");
                }else{
                    var excludedoptions = markSelectedRooms();
                    // console.log(excludedoptions);
                    var index = $('.roombox').length + 1;
                    $('#roomtypecount').val(index);
                    // pricePerDay(index);

                    // $('#rentalbutton').hide();
                    $('#expensesbutton').css('display', 'inline-block');

                    var roomtypes = JSON.parse('<?php echo $all_roomtypes->where("status",0); ?>');
                    var options = '';
                    roomtypes.forEach(function (roomtype) {
                        if (!excludedoptions.includes(roomtype.id)) {
                            options += '<option value="'+roomtype.id+'">'+roomtype.name+'</option>';
                        }
                    });
                    event.preventDefault();
                    $('#roomdiv').append('' +
                        '<div class="col-lg-12 d-flex flex-column roombox">'+
                            '<div class="block block-rounded flex-grow-1 d-flex flex-column">'+
                                '<div class="block-header block-header-default">'+
                                    '<h3 class="block-title">Room Details</h3>'+
                                    '<div class="block-options">'+
                                        '<button type="button" class="btn btn-sm btn-alt-danger btn-remove-roomdiv">'+
                                            '<i class="si si-close"></i>'+
                                        '</button>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="block-content block-content-full flex-grow-1 d-flex row">'+
                                    '<div class="col-lg-8 d-flex flex-column">'+
                                        '<div class="row">'+

                                            '<div class="form-row mb-2 col-lg-12">'+
                                                '<label for="room_type">Room Type</label>'+
                                                '<div class="input-group">'+
                                                    '<select class="form-control" id="room_type'+index+'" data-placeholder="Select Room Type.." name="room_type'+index+'" onchange="getRooms('+index+')">'+
                                                        '<option>Select Room Type</option>'+
                                                        options+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-row col-lg-12 mb-2">'+
                                                '<label for="room'+index+'">Select Room(s)</label>'+
                                                '<div class="input-group">'+
                                                    '<select class="form-control" data-placeholder="Select Room Type First" name="room'+index+'[]" id="room'+index+'" multiple required>'+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-row mb-2 col-lg-12">'+
                                                '<label for="price">Room Price Per Day <span id="roomnums'+index+'"></span></label>'+
                                                '<div class="input-group">'+
                                                    '<div class="input-group-prepend">'+
                                                        '<span class="input-group-text input-group-text-alt">GHS</span>'+
                                                    '</div>'+
                                                    '<input type="number" step="0.01" onkeyup="pricePerDay('+index+')" id="price_per_day'+index+'" name="price_per_day'+index+'" class="form-control text-center" value="" placeholder="Room Price Per Day">'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-4 d-flex flex-column">'+
                                        '<div class="row">'+

                                            '<div class="form-row mb-4 col-lg-12">'+
                                                '<label for="adults'+index+'">Adults</label>'+
                                                '<input type="number" class="form-control" id="adults'+index+'" name="adults'+index+'" placeholder="Adults" required value="">'+
                                            '</div>'+
                                            '<div class="form-row mb-4 col-lg-12">'+
                                                '<label for="children'+index+'">Children</label>'+
                                                '<input type="number" class="form-control" id="children'+index+'" name="children'+index+'" placeholder="Children" required value="">'+
                                            '</div>'+


                                            '<div class="form-row mb-4 col-lg-12">'+
                                                '<label for="total_price'+index+'">Room Total For <span id="resdays'+index+'">Specified</span> Day(s)</label>'+
                                                '<div class="input-group">'+
                                                    '<div class="input-group-prepend">'+
                                                        '<span class="input-group-text input-group-text-alt">GHS</span>'+
                                                    '</div>'+
                                                    '<input type="hidden" name="currency" value="GHS">'+
                                                    '<input type="number" step="0.01" id="total_price'+index+'" name="total_price'+index+'" class="form-control text-center" value="" readonly placeholder="Total Amount">'+
                                                    '<div class="input-group-append">'+
                                                        '<span class="input-group-text input-group-text-alt">'+
                                                            '<i class="fa fa-calculator"></i>'+
                                                        '</span>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+

                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                }
            }

        });

        $('#add-rentalbox').click(function () {

            if(!$('#reservation_daterange').val()){
                swalnotify("Error!", "Please Enter Reservation Dates First","error");
            }else{
                swaltoast("Success", "New Rental Form Added", "success");
                var dates = ($("#reservation_daterange").val()).split(' to ');
                // console.log(dates);
                var check_in = new Date(dates[0]);
                var check_out = new Date(dates[1]);

                if(dates[1] === undefined || (check_in.getTime() >= check_out.getTime())){
                    swalnotify("Error!", "Rental end date value must be after the Rental start date.","error");
                    $('#rentaldiv').html("");
                }else{
                    console.log(check_out);
                    var index = $('.rentalbox').length + 1;
                    $('#rentaltypecount').val(index);
                    // pricePerDay(index);

                    // $('#roombutton').hide();
                    $('#expensesbutton').css('display', 'inline-block');

                    var options = '';
                    event.preventDefault();
                    $('#rentaldiv').append('' +
                        '<div class="col-lg-12 d-flex flex-column rentalbox">'+
                            '<div class="block block-rounded flex-grow-1 d-flex flex-column">'+
                                '<div class="block-header block-header-default">'+
                                    '<h3 class="block-title">Rental Details</h3>'+
                                    '<div class="block-options">'+
                                        '<button type="button" class="btn btn-sm btn-alt-danger btn-remove-rentaldiv">'+
                                            '<i class="si si-close"></i>'+
                                        '</button>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="block-content block-content-full flex-grow-1 d-flex align-items-center row">'+
                                    '<div class="col-lg-8 d-flex flex-column">'+
                                        '<div class="row">'+
                                            '<div class="form-row col-lg-12 mb-2">'+
                                                '<label for="rental_description'+index+'">Rental Description</label>'+
                                                '<div class="input-group">'+
                                                    '<input type="text" id="rental_description'+index+'" name="rental_description'+index+'" class="form-control" value="" placeholder="Rental Description">'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-row mb-2 col-lg-6">'+
                                                '<label for="rental_type">Rental Type</label>'+
                                                '<div class="input-group">'+
                                                    '<select class="form-control" id="rental_type'+index+'" data-placeholder="Select Rental Type.." name="rental_type'+index+'">'+
                                                        '<option>Select Rental Type</option>'+
                                                        '<option value="grounds">Rent Lawn Grounds</option>'+
                                                        '<option value="poolside">Rent Poolside</option>'+
                                                        '<option value="chairs">Rent Chairs</option>'+
                                                        '<option value="tables">Rent Tables</option>'+
                                                        '<option value="canopies">Rent Canopies</option>'+
                                                        '<option value="other">Rent Others</option>'+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-row mb-2 col-lg-6">'+
                                                '<label for="rental_quantity'+index+'">Quantity</label>'+
                                                '<input type="number" class="form-control" id="rental_quantity'+index+'" name="rental_quantity'+index+'" value="1" placeholder="Quantity" required value="">'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-4 d-flex flex-column">'+
                                        '<div class="row">'+

                                            '<div class="form-row mb-2 col-lg-12">'+
                                                '<label for="rental_price_per_day">Item Price</span></label>'+
                                                '<div class="input-group">'+
                                                    '<div class="input-group-prepend">'+
                                                        '<span class="input-group-text input-group-text-alt">GHS</span>'+
                                                    '</div>'+
                                                    '<input type="number" step="0.01" onkeyup="rentalPricePerDay('+index+')" id="rental_price_per_day'+index+'" name="rental_price_per_day'+index+'" class="form-control text-center" value="" placeholder="Item Price Per Day">'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-row mb-2 col-lg-12">'+
                                                '<label for="rental_total_price'+index+'">Total For <span id="resdays'+index+'">Specified</span> Day(s)</label>'+
                                                '<div class="input-group">'+
                                                    '<div class="input-group-prepend">'+
                                                        '<span class="input-group-text input-group-text-alt">GHS</span>'+
                                                    '</div>'+
                                                    '<input type="number" step="0.01" id="rental_total_price'+index+'" name="rental_total_price'+index+'" class="form-control text-center" value="" readonly placeholder="Total Amount">'+
                                                    '<div class="input-group-append">'+
                                                        '<span class="input-group-text input-group-text-alt">'+
                                                            '<i class="fa fa-calculator"></i>'+
                                                        '</span>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+

                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                }
            }

        });

        $('#add-expensebox').click(function () {

            if(!$('#reservation_daterange').val()){
                swalnotify("Error!", "Please Enter Reservation Dates First","error");
            }else{
                swaltoast("Success", "New Sale Form Added", "success");
                var dates = ($("#reservation_daterange").val()).split(' to ');
                // console.log(dates);
                var check_in = new Date(dates[0]);
                var check_out = new Date(dates[1]);

                if(dates[1] === undefined || (check_in.getTime() >= check_out.getTime())){
                    swalnotify("Error!", "Check-out date value must be after the Check-in date.","error");
                    $('#expensediv').html("");
                }else{
                    // console.log(excludedoptions);
                    var index = $('.expensebox').length + 1;
                    $('#expensetypecount').val(index);

                    // $('#rentalbutton').hide();
                    $('#expensesbutton').css('display', 'inline-block');

                    event.preventDefault();
                    $('#expensediv').append('' +
                        '<div class="col-lg-12 d-flex flex-column expensebox">'+
                            '<div class="block block-rounded flex-grow-1 d-flex flex-column">'+
                                '<div class="block-header block-header-default">'+
                                    '<h3 class="block-title">Additional Sale Details</h3>'+
                                    '<div class="block-options">'+
                                        '<button type="button" class="btn btn-sm btn-alt-danger btn-remove-expensediv">'+
                                            '<i class="si si-close"></i>'+
                                        '</button>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="block-content block-content-full flex-grow-1 d-flex align-items-center row">'+
                                    '<div class="col-lg-8 d-flex flex-column">'+
                                        '<div class="row">'+
                                            '<div class="form-row col-lg-12 mb-2">'+
                                                '<label for="expense_description'+index+'">Sale Description</label>'+
                                                '<div class="input-group">'+
                                                    '<input type="text" id="expense_description'+index+'" name="expense_description'+index+'" class="form-control" value="" placeholder="Sale Description">'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-row mb-2 col-lg-6">'+
                                                '<label for="expense_type">Sale Type</label>'+
                                                '<div class="input-group">'+
                                                    '<select class="form-control" id="expense_type'+index+'" data-placeholder="Select Sale Type.." name="expense_type'+index+'">'+
                                                        '<option>Select Sale Type</option>'+
                                                        '<option value="food">Food</option>'+
                                                        '<option value="drinks">Drinks</option>'+
                                                        '<option value="other">Other</option>'+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="form-row mb-2 col-lg-6">'+
                                                '<label for="expense_quantity'+index+'">Quantity</label>'+
                                                '<input type="number" class="form-control" id="expense_quantity'+index+'" name="expense_quantity'+index+'" value="1" placeholder="Quantity" required value="">'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-lg-4 d-flex flex-column">'+
                                        '<div class="row">'+

                                            '<div class="form-row mb-2 col-lg-12">'+
                                                '<label for="expense_price">Item Price</span></label>'+
                                                '<div class="input-group">'+
                                                    '<div class="input-group-prepend">'+
                                                        '<span class="input-group-text input-group-text-alt">GHS</span>'+
                                                    '</div>'+
                                                    '<input type="number" step="0.01" onkeyup="expensePrice('+index+')" id="expense_price'+index+'" name="expense_price'+index+'" class="form-control text-center" value="" placeholder="Item Price">'+
                                                '</div>'+
                                            '</div>'+

                                            '<div class="form-row mb-2 col-lg-12">'+
                                                '<label for="expense_total_price'+index+'">Total Sale Amount</label>'+
                                                '<div class="input-group">'+
                                                    '<div class="input-group-prepend">'+
                                                        '<span class="input-group-text input-group-text-alt">GHS</span>'+
                                                    '</div>'+
                                                    '<input type="number" step="0.01" id="expense_total_price'+index+'" name="expense_total_price'+index+'" class="form-control text-center" value="" readonly placeholder="Total Amount">'+
                                                    '<div class="input-group-append">'+
                                                        '<span class="input-group-text input-group-text-alt">'+
                                                            '<i class="fa fa-calculator"></i>'+
                                                        '</span>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+

                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );
                }
            }

        });
    </script>

@endsection


