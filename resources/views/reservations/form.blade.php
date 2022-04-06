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
                <div class="col-lg-8 d-flex flex-column">
                    <!-- Reservation Details -->
                    <div class="block block-rounded flex-grow-1 d-flex flex-column">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Reservation Details</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                                {{-- <button type="button" class="btn-block-option">
                                    <i class="si si-settings"></i>
                                </button> --}}
                            </div>
                        </div>
                        <div class="block-content block-content-full d-flex align-items-center row">

                            <div class="form-row col-lg-12 mb-3">
                                <label for="room_type">Room Type</label>
                                <select class="{{isset($request) ? '': 'js-select2' }} form-control" id="room_type" data-placeholder="Select Room Type.." name="room_type" onchange="getRooms()" {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'') }}>
                                    <option>Select Room Type</option>
                                    @foreach($all_roomtypes->where('status',0) as $roomtype)
                                        <option value="{{$roomtype->id}}" @if(($reservation->roomtype->id ?? null) == $roomtype->id) selected="selected" @endif >{{$roomtype->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-row col-lg-12 mb-3">
                                <label for="room">Room</label>
                                <select class="js-select2 form-control" data-placeholder="Select Room Type First" name="{{isset($create) ? 'room[]': 'room' }}" id="room" {{isset($create) ? 'multiple required': (isset($show) ? 'disabled': 'required') }} style="{{(isset($request) ? "border: 1px solid red !important;":'')}}">

                                    @if(isset($create))
                                    @elseif(isset($request))
                                        <option>Select Room</option>
                                        @foreach($req_rooms as $room)
                                            <option value="{{$room->id}}" {{$room->id == $reservation->room_id ? 'selected' : ''}}>{{$room->name}}</option>
                                        @endforeach
                                    @else
                                        <option>Select Room</option>
                                        @if(isset($reservation->room))
                                            <option value="{{$reservation->room->id}}" selected="selected">{{$reservation->room->name}}</option>
                                        @endif
                                    @endif
                                </select>
                            </div>

                            <div class="form-row col-lg-12 mb-3">

                                @if(isset($show))
                                    <label for="roomtype">Guest</label>
                                @elseif(isset($request))
                                    <label for="roomtype">Guest</label>
                                @else
                                    <label for="roomtype">Guest Lookup</label>
                                    <div class="input-group col-lg-12 mb-3">
                                        <input type="text" class="form-control" id="search_guest" placeholder="Guest Search..">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-fw fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <div class="tab-pane fade fade-up active show col-lg-12" role="tabpanel" id="table-div" style="display: {{isset($create) ? (isset($guest) ? 'block' : 'none') : 'block'}};">
                                    @if(!isset($request))
                                        <div class="font-size-h4 font-w600 p-2 mb-4 border-left border-4x border-primary bg-body-light" id="summary-div">
                                            <span class="text-primary font-w700" >1</span> results found for <mark class="text-danger">guest</mark>
                                        </div>
                                    @endif
                                    <table class="table table-striped table-vcenter">
                                        <thead>
                                            <tr>
                                                <th class="d-none d-sm-table-cell text-center" style="width: 40px;">#</th>
                                                <th class="text-center" style="width: 70px;"><i class="si si-user"></i></th>
                                                <th>Name</th>
                                                <th class="d-none d-sm-table-cell">Email</th>
                                                <th class="d-none d-lg-table-cell" style="width: 15%;">Phone</th>
                                            </tr>
                                        </thead>
                                        <tbody id="search-div">
                                            @if(!isset($create))
                                                <tr>
                                                    <td class="d-none d-sm-table-cell text-center">
                                                        <div class="custom-control custom-radio custom-control-primary custom-control-lg mb-1">
                                                            <input type="radio" class="custom-control-input" name="guest_id" id="guest_id" value="{{$reservation->guest->id}}" checked>
                                                            <label class="custom-control-label" for="guest_id"></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <img class="img-avatar img-avatar48" src="{{asset('media/avatars/avatar3.jpg')}}" alt="">
                                                    </td>
                                                    <td class="font-w600">
                                                        <a href="javascript:void(0)">{{$reservation->guest->full_name}}</a>
                                                    </td>
                                                    <td class="d-none d-sm-table-cell">
                                                        {{$reservation->guest->email}}
                                                    </td>
                                                    <td class="d-none d-lg-table-cell">
                                                        {{$reservation->guest->phone}}
                                                    </td>
                                                </tr>
                                            @elseif(isset($guest))
                                                <tr>
                                                    <td class="d-none d-sm-table-cell text-center">
                                                        <div class="custom-control custom-radio custom-control-primary custom-control-lg mb-1">
                                                            <input type="radio" class="custom-control-input" name="guest_id" id="guest_id" value="{{$guest->id}}" checked>
                                                            <label class="custom-control-label" for="guest_id"></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <img class="img-avatar img-avatar48" src="{{asset('media/avatars/avatar3.jpg')}}" alt="">
                                                    </td>
                                                    <td class="font-w600">
                                                        <a href="javascript:void(0)">{{$guest->full_name}}</a>
                                                    </td>
                                                    <td class="d-none d-sm-table-cell">
                                                        {{$guest->email}}
                                                    </td>
                                                    <td class="d-none d-lg-table-cell">
                                                        {{$guest->phone}}
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Reservation Details -->
                </div>
                <div class="col-lg-4 d-flex flex-column">
                    <!-- Reservation Details -->
                    <div class="block block-rounded flex-grow-1 d-flex flex-column">
                        <div class="block-header block-header-default">
                            <h3 class="block-title"></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                                {{-- <button type="button" class="btn-block-option">
                                    <i class="si si-settings"></i>
                                </button> --}}
                            </div>
                        </div>
                        <div class="block-content block-content-full flex-grow-1 d-flex align-items-center row">
                            <div class="form-row mb-2 col-lg-12">
                                <label for="check_in">Check In Date</label>
                                <input type="text" class="js-flatpickr form-control {{isset($show) ? '':(isset($request) ? '':'bg-white') }}" id="check_in" name="check_in" placeholder="Choose check-in date.." {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} data-min-date="today" value="{{isset($reservation) ? date_format(date_create($reservation->check_in),'Y-m-d') : ''}}">
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <label for="check_out">Check Out Date</label>
                                <input type="text" class="js-flatpickr form-control {{isset($show) ? '':(isset($request) ? '':'bg-white') }}" id="check_out" name="check_out" placeholder="Choose check-out date.." {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} data-min-date="today" value="{{isset($reservation) ? date_format(date_create($reservation->check_out),'Y-m-d') : ''}}">
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <label for="adults">Adults</label>
                                <select class="form-control" id="adults" data-placeholder="Select Number of Adults.." name="adults" {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} >
                                    <option>Select Number of Adults</option>
                                    <option value="1" @if(isset($reservation)) {{$reservation->adults == '1' ?  'selected="selected"' : ''}} @endif>1</option>
                                    <option value="2" @if(isset($reservation)) {{$reservation->adults == '2' ?  'selected="selected"' : ''}} @endif>2</option>
                                    <option value="3" @if(isset($reservation)) {{$reservation->adults == '3' ?  'selected="selected"' : ''}} @endif>3</option>
                                    <option value="4" @if(isset($reservation)) {{$reservation->adults == '4' ?  'selected="selected"' : ''}} @endif>4</option>
                                    <option value="5" @if(isset($reservation)) {{$reservation->adults == '5' ?  'selected="selected"' : ''}} @endif>5</option>
                                </select>
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <label for="children">Children</label>
                                <select class="form-control" id="children" data-placeholder="Select Number of Children.." name="children" {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} >
                                    <option>Select Number of Children</option>
                                    <option value="0" @if(isset($reservation)) {{$reservation->children == '0' ? 'selected="selected"' : '' }} @endif>0</option>
                                    <option value="1" @if(isset($reservation)) {{$reservation->children == '1' ? 'selected="selected"' : '' }} @endif>1</option>
                                    <option value="2" @if(isset($reservation)) {{$reservation->children == '2' ? 'selected="selected"' : '' }} @endif>2</option>
                                    <option value="3" @if(isset($reservation)) {{$reservation->children == '3' ? 'selected="selected"' : '' }} @endif>3</option>
                                    <option value="4" @if(isset($reservation)) {{$reservation->children == '4' ? 'selected="selected"' : '' }} @endif>4</option>
                                    <option value="5" @if(isset($reservation)) {{$reservation->children == '5' ? 'selected="selected"' : '' }} @endif>5</option>
                                    <option value="6" @if(isset($reservation)) {{$reservation->children == '6' ? 'selected="selected"' : '' }} @endif>6</option>
                                </select>
                            </div>

                            <div class="form-row mb-2 col-lg-12">
                                <label for="price">Current Room Price Per Day</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-alt">
                                            {{$current_user->company->currency}}
                                        </span>
                                    </div>
                                    <input type="number" id="price_per_day" name="price_per_day" class="form-control text-center" value="{{isset($reservation->price) ? ($reservation->price/$reservation->days) : ''}}" {{isset($show) ? 'disabled':'required' }}  style="{{(isset($request) ? "border: 1px solid red !important;":'')}}" placeholder="Room Price Per Day">
                                </div>
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <label for="discount">Total Amount For {{$reservation->days ?? 'Specified'}} Day(s)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-alt">
                                            {{$current_user->company->currency}}
                                        </span>
                                    </div>
                                    <input type="hidden" name="currency" value="{{$current_user->company->currency}}">
                                    <input type="number" id="total_price" name="price" class="form-control text-center" value="{{$reservation->price ?? ''}}" readonly placeholder="Total Amount">
                                    <div class="input-group-append">
                                        <span class="input-group-text input-group-text-alt">
                                            <i class="fa fa-calculator"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-row mb-2 col-lg-12">
                                <label for="discount">Discount</label>
                                <div class="input-group">
                                    <input type="number" name="discount" class="form-control text-center" value="{{$reservation->discount ?? ''}}" {{isset($show) ? 'disabled':'required' }}  style="{{(isset($request) ? "border: 1px solid red !important;":'')}}" placeholder="Discount Percentage">
                                    <div class="input-group-append">
                                        <span class="input-group-text input-group-text-alt">
                                            <i class="fa fa-percent"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="form-row mb-2 col-lg-12">
                                <label for="payment_type">Payment Method</label>
                                <select name="payment_type" class="form-control" {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }}>
                                    <option>Select Payment Method</option>
                                    <option value="cash" @if(isset($reservation)) {{$reservation->payment_method == 'cash' ? 'selected="selected"' : ''}} @endif>Cash Payment</option>
                                    <option value="momo" @if(isset($reservation)) {{$reservation->payment_method == 'momo' ? 'selected="selected"' : ''}} @endif>Mobile Money</option>
                                    <option value="pos" @if(isset($reservation)) {{$reservation->payment_method == 'pos' ? 'selected="selected"' : ''}} @endif>Card POS</option>
                                    <option value="electronic" @if(isset($reservation)) {{$reservation->payment_method == 'electronic' ? 'selected="selected"' : ''}} @endif>Electronic Payment (Momo/Card)</option>
                                </select>
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <label for="status">Reservation Status</label>
                                <select name="status" class="form-control" {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }}>
                                    <option>Select Status</option>
                                    <option value="pending" @if(isset($reservation)) {{$reservation->reservation_status == 'pending' ? 'selected="selected"' : ''}} @endif>Pending Approval</option>
                                    <option value="confirmed" @if(isset($reservation)) {{$reservation->reservation_status == 'confirmed' ? 'selected="selected"' : ''}} @endif>Reservation Confirmed</option>
                                    <option value="cancelled" @if(isset($reservation)) {{$reservation->reservation_status == 'cancelled' ? 'selected="selected"' : ''}} @endif>Reservation Cancelled</option>
                                </select>
                            </div>
                            @if(!isset($show))
                                <div class="form-row mt-2 col-lg-12 pull-right">
                                    <button class="btn btn-primary" type="submit">{{isset($request) ? 'Send Request Reply' : (isset($update) ? 'Update Reservation' : 'Save Reservation')}}</button>
                                </div>
                            @endif
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



    <script>
        // getRooms();
        $("#price_per_day").keyup(function () {
            var price = $(this).val();
            var date1 = new Date($("#check_in").val());
            var date2 = new Date($("#check_out").val());

            // To calculate the time difference of two dates
            var timediff = date2.getTime() - date1.getTime();

            // To calculate the no. of days between two dates
            var daydiff = timediff / (1000 * 3600 * 24);
            console.log(daydiff);

            $('#total_price').val(price * daydiff);

        });


        function getRooms() {
            var room_type = $("#room_type").val();
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
                        $("#room").html("");
                        // let roomoption = new Option("Select a Room","");
                        // $(roomoption).html("Select a Room");
                        // $("#room").append(roomoption);

                        results.forEach(function (room) {
                            let option = new Option(room.name,room.id);
                            $(option).html(room.name,room.id);
                            $("#room").append(option);
                        });
                    }
                }.bind(this)
            })
        }
        // searchNode.disabled = false;
        // subSelectNode.disabled = true;

        var searchRequest = null;

        $(function () {
            var minlength = 3;

            $("#search_guest").keyup(function () {
                var that = this,
                value = $(this).val();
                console.log(value);

                if (value.length >= minlength ) {
                    if (searchRequest != null)
                        searchRequest.abort();
                        searchRequest = $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/admin/guests/findguest/'+value,
                        type: 'POST',
                        // data: {client_id: client_id, service_id: selected},
                        success: function(response){
                            console.log(response);
                            //we need to check if the value is the same
                            if (value==$(that).val()) {
                                $("#table-div").show();
                                $("#summary-div").html('<span class="text-primary font-w700" >'+response.length+'</span> results found for <mark class="text-danger">'+value+'</mark>');
                                $('#search-div').html("");
                                // JSON.parse($('<div>').html(response)[0].textContent).forEach(function (client) {
                                response.forEach(function (guest) {
                                    // console.log(guest.created_at);
                                    let option = '<tr>'+
                                                    '<td class="d-none d-sm-table-cell text-center">'+
                                                        '<div class="custom-control custom-radio custom-control-primary custom-control-lg mb-1">'+
                                                            '<input type="radio" class="custom-control-input" name="guest_id" id="guest'+guest.id+'" value="'+guest.id+'">'+
                                                            '<label class="custom-control-label" for="guest'+guest.id+'"></label>'+
                                                        '</div>'+
                                                    '</td>'+
                                                    '<td class="text-center">'+
                                                        '<img class="img-avatar img-avatar48" src="/media/avatars/avatar3.jpg" alt="">'+
                                                    '</td>'+
                                                    '<td class="font-w600">'+
                                                        '<a href="javascript:void(0)">'+guest.full_name+'</a>'+
                                                    '</td>'+
                                                    '<td class="d-none d-sm-table-cell" width="15px">'+
                                                        guest.email+
                                                    '</td>'+
                                                    '<td class="d-none d-lg-table-cell" width="15px">'+
                                                        guest.phone+
                                                    '</td>'+
                                                '</tr>';
                                    $('#search-div').append(option);
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>

@endsection


