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

                            <div class="form-row mb-2 col-lg-12">
                                <div class="">Full Name: <b>{{$guest->full_name ?? $reservation->guest->full_name}}</b></div>
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <div class="">Email: <b>{{$guest->email ?? $reservation->guest->email}}</b></div>
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <div class="">Phone: <b>{{$guest->phone ?? $reservation->guest->phone}}</b></div>
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <div class="">City: <b>{{$guest->city ?? ($reservation->guest->city ?? "Not Specified")}}</b></div>
                            </div>
                            {{-- <div class="form-row mb-2 col-lg-12"> --}}
                                <div class="{}">Country: <b>{{$guest->country ?? ($reservation->guest->country ?? "Not Specified")}}</b></div>
                            {{-- </div> --}}
                            <input type="hidden" name="guest_id" id="guest_id" value="{{$guest->id ?? $reservation->guest->id}}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex flex-column">
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
                                <input type="text" class="review-old-flatpickr form-control {{isset($show) ? '':(isset($request) ? '':'bg-white') }}" id="check_in" name="check_in" placeholder="Choose check-in date.." {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} data-min-date="today" value="{{isset($reservation) ? date_format(date_create($reservation->check_in),'Y-m-d') : ''}}" autocomplete="off">
                            </div>
                            <div class="form-row mb-2 col-lg-12">
                                <label for="check_out">Check Out Date</label>
                                <input type="text" class="review-old-flatpickr form-control {{isset($show) ? '':(isset($request) ? '':'bg-white') }}" id="check_out" name="check_out" placeholder="Choose check-out date.." {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} data-min-date="today" value="{{isset($reservation) ? date_format(date_create($reservation->check_out),'Y-m-d') : ''}}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="roomdiv">
                @if(!isset($create))
                    @foreach ($distinctdetails as $detail)
                        @php
                            $i = 1;
                        @endphp
                        <div class="col-lg-12 d-flex flex-column roombox">
                            <!-- Reservation Details -->
                            <div class="block block-rounded flex-grow-1 d-flex flex-column">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Room Details</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option btn-remove-phone">
                                            <i class="si si-close"></i>
                                        </button>
                                        {{-- <button type="button" class="btn-block-option">
                                            <i class="si si-settings"></i>
                                        </button> --}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8 d-flex flex-column">
                                        <div class="block-content block-content-full flex-grow-1 d-flex align-items-center row">

                                            <div class="form-row mb-2 col-lg-12">
                                                <label for="room_type">Room Type</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="room_type{{$i}}" data-placeholder="Select Room Type.." name="room_type{{$i}}" onchange="getRooms({{$i}})" {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'') }} autocomplete="off">
                                                        <option>Select Room Type</option>
                                                        @foreach($all_roomtypes->where('status',0) as $roomtype)
                                                            <option value="{{$roomtype->id}}" @if(($detail->room_type_id ?? null) == $roomtype->id) selected="selected" @endif >{{$roomtype->name ?? 'Undefined Room Type'}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row col-lg-12 mb-3">
                                                <label for="room">Select Room(s)</label>
                                                <div class="input-group">
                                                    <select class="form-control" data-placeholder="Select Room Type First" name="{{isset($create) || isset($update) ? 'room'.$i.'[]': 'room'.$i }}" id="room{{$i}}" {{isset($create) || isset($update) ? 'multiple required': (isset($show) ? 'multiple disabled': (strtotime($reservation->check_in) >= strtotime(date('Y-m-d', strtotime('-5 days'))) ? 'required':'disabled')) }} style="{{(isset($request) ? "border: 1px solid red !important;":'')}}" autocomplete="off">

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
                                                    <input type="number" id="price_per_day{{$i}}" name="price_per_day{{$i}}" class="form-control text-center" onkeyup="pricePerDay({{$i}})" value="{{$detail->price_per_day ?? ''}}" {{isset($show) ? 'disabled':(isset($request) ? (strtotime($reservation->check_in) >= strtotime(date('Y-m-d')) ? 'required':'disabled') : 'required') }}  style="{{(isset($request) ? "border: 1px solid red !important;":'')}}" placeholder="Room Price Per Day" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-flex flex-column">
                                        <div class="block-content block-content-full flex-grow-1 d-flex align-items-center row">

                                            <div class="form-row mb-2 col-lg-12">
                                                <label for="adults{{$i}}">Adults</label>
                                                <input type="number" class="form-control" id="adults{{$i}}" name="adults{{$i}}" placeholder="Adults" {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} value="{{$detail->adults ?? 0}}" autocomplete="off">
                                            </div>
                                            <div class="form-row mb-2 col-lg-12">
                                                <label for="children{{$i}}">Children</label>
                                                <input type="number" class="form-control" id="children{{$i}}" name="children{{$i}}" placeholder="Children" {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} value="{{$detail->children ?? 0}}" autocomplete="off">
                                            </div>


                                            <div class="form-row mb-2 col-lg-12">
                                                <label for="total_price{{$i}}">Room Total For <span id="roomdays{{$i}}">{{$reservation->days ?? 'Specified'}}</span> Day(s)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text input-group-text-alt">
                                                            {{$current_user->company->currency}}
                                                        </span>
                                                    </div>
                                                    <input type="number" id="total_price{{$i}}" name="total_price{{$i}}" class="form-control text-center" value="{{$detail->total_price ?? 0}}" readonly placeholder="Total Amount" autocomplete="off">
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
                        <a href="#" class="btn btn-sm btn-secondary mb-4" id="add-roombox"><i class="fa fa-plus"></i> Add Room</a>
                    </div>
                @endif
            @endif
            <div class="row">
                <div class="col-lg-12 d-flex flex-column">
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

                            <input type="hidden" name="roomtypecount" id="roomtypecount" value="0" autocomplete="off">

                            <div class="form-row mb-2 col-lg-6">
                                <label for="discount">Grand Total For {{$reservation->days ?? 'Specified'}} Day(s)</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-alt">
                                            {{$current_user->company->currency}}
                                        </span>
                                    </div>
                                    <input type="hidden" name="currency" value="{{$current_user->company->currency}}">
                                    <input type="number" id="grand_total" name="grand_total" class="form-control text-center" value="{{$reservation->grand_total ?? ''}}" readonly placeholder="0.00" style="height:90px;font-size:40pt;" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text input-group-text-alt">
                                            <i class="fa fa-calculator"></i>
                                        </span>
                                    </div>
                                </div>
                                <label for="price">Amount Paid</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-alt">
                                            {{$current_user->company->currency}}
                                        </span>
                                    </div>
                                    <input type="number" id="amount_paid" name="amount_paid" class="form-control text-center" onkeyup="calculateBalance()" value="{{$reservation->amount_paid ?? 0}}" {{isset($show) ? 'disabled':(isset($request) ? 'readonly' : 'required') }} placeholder="Total Deposit Received" autocomplete="off">
                                </div>
                                <label for="balance">Balance Remaining</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-alt">
                                            {{$current_user->company->currency}}
                                        </span>
                                    </div>
                                    <input type="hidden" name="currency" value="{{$current_user->company->currency}}">
                                    <input type="number" id="balance" name="balance" class="form-control text-center" value="{{$reservation->balance ?? 0}}" readonly placeholder="Grand Total - Amount Paid" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text input-group-text-alt">
                                            <i class="fa fa-calculator"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2 col-lg-6">
                                <div class="form-row mb-2 col-lg-12">
                                    <label for="payment_type">Payment Method</label>
                                    <select name="payment_type" id="payment_type" class="form-control" {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} onchange="restrictIfPaystack()" autocomplete="off">
                                        <option value="">Select Payment Method</option>
                                        <option value="paystack" @if(isset($reservation)) {{$reservation->payment_method == 'paystack' ? 'selected="selected"' : ''}} @endif>Send Paystack Invoice</option>
                                        <option value="cash" @if(isset($reservation)) {{$reservation->payment_method == 'cash' ? 'selected="selected"' : ''}} @endif>Cash Payment</option>
                                        <option value="momo" @if(isset($reservation)) {{$reservation->payment_method == 'momo' ? 'selected="selected"' : ''}} @endif>Mobile Money</option>
                                        <option value="pos" @if(isset($reservation)) {{$reservation->payment_method == 'pos' ? 'selected="selected"' : ''}} @endif>Card POS</option>
                                        <option value="bank" @if(isset($reservation)) {{$reservation->payment_method == 'bank' ? 'selected="selected"' : ''}} @endif>Bank Payment</option>
                                        <option value="expedia" @if(isset($reservation)) {{$reservation->payment_method == 'expedia' ? 'selected="selected"' : ''}} @endif>Expedia</option>
                                        <option value="complementary" @if(isset($reservation)) {{$reservation->payment_method == 'complementary' ? 'selected="selected"' : ''}} @endif>Complementary</option>
                                    </select>
                                </div>
                                <div class="form-row mb-2 col-lg-12">
                                    <label for="status">Reservation Status</label>
                                    <select name="status" id="status" class="form-control" {{isset($show) ? 'disabled':(isset($request) ? 'disabled':'required') }} autocomplete="off">
                                        <option value="">Select Status</option>
                                        <option value="pending" @if(isset($reservation)) {{$reservation->reservation_status == 'pending' ? 'selected="selected"' : ''}} @endif>Pending Approval</option>
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
                                @if(!isset($show))
                                    @if(isset($reservation) && (strtotime($reservation->check_in) < strtotime(date('Y-m-d', strtotime('-5 days')))))
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
            }else{
                $("#status").removeAttr('readonly','readonly').removeAttr("style", "pointer-events: none;").removeAttr("tabindex","-1");
            }
        }

        function pricePerDay(index){
            if(($('#room'+index).val()).length < 1){
                swalnotify("Error!", "Please Select Room(s) First","error");
            }else{
                var price = $("#price_per_day"+index).val();
                var date1 = new Date($("#check_in").val());
                var date2 = new Date($("#check_out").val());

                // To calculate the time difference of two dates
                var timediff = date2.getTime() - date1.getTime();
                // console.log($("#room"+index).val());

                // To calculate the no. of days between two dates
                var daydiff = timediff / (1000 * 3600 * 24);
                $("#roomdays"+index).html(daydiff);
                var roomcount = ($("#room"+index).val()).length;
                $("#roomnums"+index).html("("+roomcount+" room(s) selected)");
                var totalprice = roomcount * (price * daydiff);
                // console.log(daydiff);

                $('#total_price'+index).val(totalprice);
                getGrandTotal();
                calculateBalance();
            }

        };

        function getGrandTotal() {
            var divcount = +$('.roombox').length;
            var grandtotal = 0;
            console.log(divcount);
            for (let index = 1; index < divcount+1; index++)
            {
                grandtotal = +grandtotal + +$('#total_price'+index).val();
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

        $('.review-old-flatpickr').flatpickr({ minDate: (today.setDate(today.getDate()-5)) })


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

        $(document.body).on('click', '.btn-remove-phone', function () {
            $(this).closest('.roombox').remove();
        });

        $('#roomtypecount').val($('.roombox').length);


        $('#add-roombox').click(function () {

            if(!$('#check_in').val() && !$('#check_out').val()){
                swalnotify("Error!", "Please Enter Check-In and Check-Out Dates First","error");
            }else{
                var excludedoptions = markSelectedRooms();
                // console.log(excludedoptions);
                var index = $('.roombox').length + 1;
                $('#roomtypecount').val(index);
                // pricePerDay(index);

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
                                    '<button type="button" class="btn-block-option btn-remove-phone">'+
                                        '<i class="si si-close"></i>'+
                                    '</button>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-lg-8 d-flex flex-column">'+
                                    '<div class="block-content block-content-full flex-grow-1 d-flex align-items-center row">'+

                                        '<div class="form-row mb-2 col-lg-12">'+
                                            '<label for="room_type">Room Type</label>'+
                                            '<div class="input-group">'+
                                                '<select class="form-control" id="room_type'+index+'" data-placeholder="Select Room Type.." name="room_type'+index+'" onchange="getRooms('+index+')">'+
                                                    '<option>Select Room Type</option>'+
                                                    options+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-row col-lg-12 mb-3">'+
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
                                                '<input type="number" onkeyup="pricePerDay('+index+')" id="price_per_day'+index+'" name="price_per_day'+index+'" class="form-control text-center" value="" placeholder="Room Price Per Day">'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-lg-4 d-flex flex-column">'+
                                    '<div class="block-content block-content-full flex-grow-1 d-flex align-items-center row">'+

                                        '<div class="form-row mb-2 col-lg-12">'+
                                            '<label for="adults'+index+'">Adults</label>'+
                                            '<input type="number" class="form-control" id="adults'+index+'" name="adults'+index+'" placeholder="Adults" required value="">'+
                                        '</div>'+
                                        '<div class="form-row mb-2 col-lg-12">'+
                                            '<label for="children'+index+'">Children</label>'+
                                            '<input type="number" class="form-control" id="children'+index+'" name="children'+index+'" placeholder="Children" required value="">'+
                                        '</div>'+


                                        '<div class="form-row mb-2 col-lg-12">'+
                                            '<label for="total_price'+index+'">Room Total For <span id="roomdays'+index+'">Specified</span> Day(s)</label>'+
                                            '<div class="input-group">'+
                                                '<div class="input-group-prepend">'+
                                                    '<span class="input-group-text input-group-text-alt">GHS</span>'+
                                                '</div>'+
                                                '<input type="hidden" name="currency" value="GHS">'+
                                                '<input type="number" id="total_price'+index+'" name="total_price'+index+'" class="form-control text-center" value="" readonly placeholder="Total Amount">'+
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

        });
    </script>

@endsection


