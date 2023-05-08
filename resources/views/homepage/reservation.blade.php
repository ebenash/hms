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

        <form id="bookForm" action="{{route('home.reservation.store')}}" method="POST">
            @csrf
            <div class="row mt-5 mb-5">
                <div class="col-lg-4">

                    <section class="section section-tertiary section-no-border p-5 mt-1 mb-4" data-plugin-sticky data-plugin-options="{'minWidth': 991, 'containerSelector': '.container', 'padding': {'top': 150}}">
                        <div class="form-row">
                            <div class="form-group col">
                                <h4 class="mt-4 mb-4 pb-0 text-uppercase">Reservation Details</h4>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <div class="form-control-custom form-control-datepicker-custom">
                                    <input type="text" value="" class="form-control text-uppercase text-2" data-msg-required="This field is required." placeholder="Arrival" name="bookNowArrival" id="bookNowArrival" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <div class="form-control-custom form-control-datepicker-custom">
                                    <input type="text" value="" class="form-control text-uppercase text-2" data-msg-required="This field is required." placeholder="Departure" name="bookNowDeparture" id="bookNowDeparture" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <div class="form-control-custom">
                                    <select class="form-control text-uppercase text-2" name="bookNowAdults" data-msg-required="This field is required." id="bookNowAdults" required>
                                        <option value="">Adults</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <div class="form-control-custom">
                                    <select class="form-control text-uppercase text-2" name="bookNowKids" data-msg-required="This field is required." id="bookNowKids" required>
                                        <option value="">Kids</option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
                <div class="col-lg-8">

                    <section class="section section-quaternary section-no-border text-light p-5 mt-1 mb-4">
                        <div class="row">
                            <div class="col">
                                <h4 class="mt-4 mb-4 pb-0 text-uppercase">Select Your Room</h4>
                            </div>
                        </div>
                        @foreach ( $rooms as $room)
                            @php
                                $i=1;
                                $available = ceil($room->rooms->count()/2); //half of the room available
                            @endphp
                            @if($available > 0)
                                <div class="row">
                                    <div class="col-1 text-center">
                                        <label class="mt-4 mb-4">
                                            <input type="checkbox" name="bookNowRoom[]" id="bookNowRoom{{$room->id}}" value="{{$room->id}}">
                                        </label>
                                    </div>
                                    {{-- <div class="col-1 text-center">
                                        <label class="mt-4 mb-4">
                                            <input type="number" name="bookNowNum" id="bookNowNum{{$room->id}}" value="1" min="1" max="999" size="3">
                                        </label>
                                    </div> --}}
                                    <div class="col-2 d-none d-sm-block">
                                        <img src="{{asset($room->image_one ?? 'img/demos/hotel/room-1.jpg')}}" class="img-fluid" alt="">
                                    </div>
                                    <div class="col-10 col-sm-9">
                                        <div class="row">
                                            <h5 class="col-10 mt-0 mb-0">{{$room->name}}</h5>
                                            <div class="col-2 text-right">
                                                <label for="bookNowNum{{$room->id}}">Qty:</label>
                                                <select name="bookNowNum{{$room->id}}" id="bookNowNum{{$room->id}}">
                                                    @while ($i <= $available)
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
        // console.log(reference);
        var roomtype = reference["ref"];
        if (roomtype != undefined) {
            document.getElementById('bookNowRoom'+roomtype).checked = true;
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
