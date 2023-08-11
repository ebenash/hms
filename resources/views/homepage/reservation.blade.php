@extends('layouts.homepage')

@section('content')
    <section class="page-header section section-primary section-no-border section-center page-header-custom-background m-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="font-weight-bold text-light text-uppercase">Book Now <span>Make a Reservation</span></h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="mt-5 mb-5">
            <form id="bookForm" action="{{route('home.reservation.availability')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">

                        <section class="section section-tertiary section-no-border p-5 mt-1 mb-4 row">
                            {{-- <div class="form-row col-lg-12">
                                <div class="form-group col">
                                    <h4 class="text-uppercase">Reservation Details</h4>
                                </div>
                            </div> --}}
                            <input type="hidden" value="" name="refRoomType" id="refRoomType">
                            <div class="form-row col-lg-3">
                                <div class="form-group col">
                                    <div class="form-control-custom form-control-datepicker-custom">
                                        <input type="text" value="{{$filter->bookNowArrival ?? ''}}" class="form-control text-uppercase text-2" data-msg-required="This field is required." placeholder="Arrival" name="bookNowArrival" id="bookNowArrival" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row col-lg-3">
                                <div class="form-group col">
                                    <div class="form-control-custom form-control-datepicker-custom">
                                        <input type="text" value="{{$filter->bookNowDeparture ?? ''}}" class="form-control text-uppercase text-2" data-msg-required="This field is required." placeholder="Departure" name="bookNowDeparture" id="bookNowDeparture" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row col-lg-3">
                                <div class="form-group col">
                                    <div class="form-control-custom">
                                        <select class="form-control text-uppercase text-2" name="bookNowAdults" data-msg-required="This field is required." id="bookNowAdults" required autocomplete="off">
                                            <option value="">Adults</option>
                                            <option value="1" {{isset($filter) && $filter->bookNowAdults == 1 ? 'selected' : ''}}>1</option>
                                            <option value="2" {{isset($filter) && $filter->bookNowAdults == 2 ? 'selected' : ''}}>2</option>
                                            <option value="3" {{isset($filter) && $filter->bookNowAdults == 3 ? 'selected' : ''}}>3</option>
                                            <option value="4" {{isset($filter) && $filter->bookNowAdults == 4 ? 'selected' : ''}}>4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row col-lg-3">
                                <div class="form-group col">
                                    <div class="form-control-custom">
                                        <select class="form-control text-uppercase text-2" name="bookNowKids" data-msg-required="This field is required." id="bookNowKids" required autocomplete="off">
                                            <option value="">Kids</option>
                                            <option value="0" {{isset($filter) && $filter->bookNowKids == 0 ? 'selected' : ''}}>0</option>
                                            <option value="1" {{isset($filter) && $filter->bookNowKids == 1 ? 'selected' : ''}}>1</option>
                                            <option value="2" {{isset($filter) && $filter->bookNowKids == 2 ? 'selected' : ''}}>2</option>
                                            <option value="3" {{isset($filter) && $filter->bookNowKids == 3 ? 'selected' : ''}}>3</option>
                                            <option value="4" {{isset($filter) && $filter->bookNowKids == 4 ? 'selected' : ''}}>4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row col-lg-12">
                                <div class="form-group col">
                                    <input type="submit" value="Check Availabilty" class="btn btn-primary btn-block text-uppercase">
                                </div>
                            </div>
                        </section>

                    </div>
                </div>
            </form>
            @if(isset($available))
                <form id="bookForm" action="{{route('home.reservation.store')}}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$filter->bookNowArrival ?? ''}}" name="bookNowArrival">
                    <input type="hidden" value="{{$filter->bookNowDeparture ?? ''}}" name="bookNowDeparture">
                    <input type="hidden" value="{{$filter->bookNowAdults ?? ''}}" name="bookNowAdults">
                    <input type="hidden" value="{{$filter->bookNowKids ?? ''}}" name="bookNowKids">

                    <div class="row">
                        <div class="col-lg-7">
                            <section class="section section-quaternary section-no-border text-light p-5 mt-1 mb-4">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="mt-4 mb-4 pb-0 text-uppercase">Select Your Room</h4>
                                    </div>
                                </div>
                                @foreach ( $available as $room)
                                    @php
                                        $i=1;
                                        $numavailable = ceil($room->count/2); //half of the room available
                                    @endphp
                                    @if($numavailable > 0)
                                        <div class="row">
                                            <div class="col-1 text-center">
                                                <label class="mt-4 mb-4">
                                                    <input type="checkbox" name="bookNowRoom[]" id="bookNowRoom{{$room->id}}" value="{{$room->id}}" {{isset($ref) && $ref == $room->id ? 'checked' : ''}}>
                                                </label>
                                            </div>
                                            {{-- <div class="col-1 text-center">
                                                <label class="mt-4 mb-4">
                                                    <input type="number" name="bookNowNum" id="bookNowNum{{$room->id}}" value="1" min="1" max="999" size="3">
                                                </label>
                                            </div> --}}
                                            <div class="col-3 d-none d-sm-block">
                                                <img src="{{asset($room->image_one ?? 'img/demos/hotel/room-1.jpg')}}" class="img-fluid" alt="">
                                            </div>
                                            <div class="col-8">
                                                <div class="row">
                                                    <h5 class="col-8 mt-0 mb-0">{{$room->room_type}}</h5>
                                                    <div class="col-4 text-right">
                                                        <label for="bookNowNum{{$room->id}}">Qty:</label>
                                                        <select name="bookNowNum{{$room->id}}" id="bookNowNum{{$room->id}}">
                                                            @while ($i <= $numavailable)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                                @php
                                                                    $i++;
                                                                @endphp
                                                            @endwhile
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="room-suite-info">
                                                    <ul>
                                                        <li><label>BEDS</label>	<span>{{$room->bed_type}}</span></li>
                                                        <li><label>RATES FROM</label> <strong>GHS {{$room->price_from}}</strong></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </section>
                        </div>
                        <div class="col-lg-5">

                            <section class="section section-quaternary section-no-border text-light p-5 mt-1 mb-4">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="mt-4 mb-4 pb-0 text-uppercase">Guest Details</h4>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="bookNowFullName" class="form-control-label">Full Name</label>
                                        <input type="text" class="form-control" id="bookNowFullName" name="bookNowFullName" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="bookNowEmail" class="form-control-label">Email Address</label>
                                        <input type="email" class="form-control" id="bookNowEmail" name="bookNowEmail" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="bookNowPhone" class="form-control-label">Phone Number</label>
                                        <input type="text" class="form-control" id="bookNowPhone" name="bookNowPhone" placeholder="">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="bookNowCity" class="form-control-label">City</label>
                                        <input type="text" class="form-control" id="bookNowCity" name="bookNowCity" placeholder="">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="bookNowCountry" class="form-control-label">Country</label>
                                        <input type="text" class="form-control" id="bookNowCountry" name="bookNowCountry" placeholder="">
                                    </div>
                                </div>

                            </section>

                            <div class="row">
                                <div class="col">
                                    <input type="submit" value="Book Now" class="btn btn-primary btn-lg btn-block text-uppercase p-4 mb-4">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <p class="pb-4 text-2">
                                        * Please note that this is not confirmation of a reservation. Confirmation is dependent on room availability and payment of deposit. Booking management will be in contact with you to facilitate finalization on both fronts. <br/>* For bulk reservations, contact the hotel directly.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection
@push('script_after')
    <script>
        function getUrlVars() {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
            });
            return vars;
        }
        var reference = getUrlVars();
        console.log(roomtype);
        var roomtype = reference["ref"];
        if (roomtype != undefined) {
            document.getElementById('refRoomType').value = roomtype;
            // document.getElementById('bookNowRoom'+roomtype).checked = true;
        }
        var arrival = reference["bookNowArrivalHeader"];
// console.log(decodeURIComponent(arrival));
        if (arrival != undefined) {
            document.getElementById('bookNowArrival').value = decodeURIComponent(arrival);
            document.getElementById('bookNowArrivalHeader').value = decodeURIComponent(arrival);
        }
        var departure = reference["bookNowDepartureHeader"];
        if (departure != undefined) {
            document.getElementById('bookNowDeparture').value = decodeURIComponent(departure);
            document.getElementById('bookNowDepartureHeader').value = decodeURIComponent(departure);
        }
        var adults = reference["bookNowAdultsHeader"];
        if (adults != undefined) {
            document.getElementById('bookNowAdults').value = adults;
            document.getElementById('bookNowAdultsHeader').value = adults;
        }
        var children = reference["bookNowKidsHeader"];
        if (children != undefined) {
            document.getElementById('bookNowKids').value = children;
            document.getElementById('bookNowKidsHeader').value = children;
        }


    </script>
@endpush
