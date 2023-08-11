@extends('layouts.app')
@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        @if(isset($filter['filter_type']) && $filter['filter_type']=='today')
            Today's Confirmed Check-Ins<small></small>
        @elseif(isset($tomorrow))
            Tomorrow's Confirmed Check-Ins<small></small>
        @elseif(isset($filter['filter_type']) && $filter['filter_type']=='requests')
            Requested Reservations<small></small>
        @elseif(isset($filter['filter_type']) && $filter['filter_type']=='pending')
            Pending Reservations<small></small>
        @elseif(isset($filter['filter_type']) && $filter['filter_type']=='cancelled')
            Cancelled Reservations<small></small>
        @elseif(isset($filter['filter_type']) && $filter['filter_type']=='rejected')
            Rejected Reservations<small></small>
        @else
            Confirmed Reservations<small></small>
        @endif
    </h1>
@endsection
@section('content')

<!-- Search -->
<div class="block block-rounded">
    <form action="{{route('reservations-filter')}}" method="POST">
        @csrf
        <div class="block-header">
            <h3 class="block-title">Search</h3>
            <div class="pull-right">
                <button type="submit" class="btn btn-dark">Submit Filter</button>
            </div>
        </div>
        <div class="block-content block-content-full">
            <!-- Form Search - Alternative Style -->
            <div class="row">
                <div class="col-lg-3">
                    <select name="filter_type" id="filter_type" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" onchange="hideTodayDates(this)">
                        <option value="">Select Filter Type</option>
                        <option value="today" {{isset($filter['filter_type']) && $filter['filter_type']=='today' ? 'selected' : ''}}>Today's Reservations</option>
                        <option value="requests" {{isset($filter['filter_type']) && $filter['filter_type']=='requests' ? 'selected' : ''}}>Reservation Requests</option>
                        <option value="pending" {{isset($filter['filter_type']) && $filter['filter_type']=='pending' ? 'selected' : ''}}>Pending Reservation</option>
                        <option value="confirmed" {{isset($filter['filter_type']) && $filter['filter_type']=='confirmed' ? 'selected' : ''}}>Confirmed Reservations</option>
                        <option value="cancelled" {{isset($filter['filter_type']) && $filter['filter_type']=='cancelled' ? 'selected' : ''}}>Cancelled Reservations</option>
                        <option value="rejected" {{isset($filter['filter_type']) && $filter['filter_type']=='rejected' ? 'selected' : ''}}>Rejected Reservations</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <input type="text" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" name="guest" value="{{isset($filter['guest']) ? $filter['guest'] : ''}}" placeholder="Guest/ Res #">
                </div>
                <div class="col-lg-2">
                    <select name="room" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2">
                        <option value="">Select Room</option>
                        @foreach ($all_rooms as $room)
                            <option value="{{$room->id}}" {{isset($filter['room']) ? ($filter['room'] == $room->id ? 'selected' : '') : ''}}>{{$room->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2">
                    <select name="room_type" id="room_type" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2">
                        <option value="">Select Room Type</option>
                        @foreach ($all_roomtypes as $roomtype)
                            <option value="{{$roomtype->id}}" {{isset($filter['room_type']) ? ($filter['room_type'] == $roomtype->id ? 'selected' : '') : ''}}>{{$roomtype->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3">
                    <input type="text" class="review-old-flatpickr form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" id="daterange" name="daterange" value="{{isset($filter['daterange']) ? $filter['daterange'] : ''}}" placeholder="Select Date Range" data-mode="range">
                     {{-- data-min-date="today"> --}}
                </div>
            </div>
        </div>
    </form>
</div>
<!-- END Search -->
<!-- Dynamic Table Full -->
<div class="block block-rounded">
    <div class="block-header">
        <h3 class="block-title">
            @if(isset($filter['filter_type']) && $filter['filter_type']=='today')
                Today's <small>Check-Ins</small>
            @elseif(isset($tomorrow))
                Tomorrow's <small>Check-Ins</small>
            @elseif(isset($filter['filter_type']) && $filter['filter_type']=='requests')
                Reservation <small>Requests</small>
            @elseif(isset($filter['filter_type']) && $filter['filter_type']=='pending')
                Pending <small>Reservations</small>
            @elseif(isset($filter['filter_type']) && $filter['filter_type']=='cancelled')
                Cancelled <small>Requests</small>
            @elseif(isset($filter['filter_type']) && $filter['filter_type']=='rejected')
                Rejected <small>Requests</small>
            @else
                Confirmed <small>Reservations</small>
            @endif
        </h3>

		<div class="pull-right">
			@can('add reservations')<a href="javascript:void(0)" data-toggle="modal" data-target="#modal-view-add-reservation" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New Reservation</a>@endcan
			@if(isset($filter['filter_type']) && $filter['filter_type']=='today')
			    <a href="{{route('reservations-tomorrow')}}" class="btn btn-sm btn-primary"><i class="fa fa-calendar-check"></i> View Tomorrow's Check-Ins</a>
			@endif
			@if(isset($tomorrow))
			    <a href="{{route('reservations-today')}}" class="btn btn-sm btn-primary"><i class="fa fa-calendar-check"></i> View Today's Check-Ins</a>
			@endif
		</div>
    </div>
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->

        <table class="table table-bordered table-striped table-vcenter js-dataTable-reservations display nowrap" style="width:100%">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Guest</th>
					<th class="hidden-sm">Check-In</th>
					<th class="hidden-sm">Check-Out</th>
					<th class="hidden-sm">Status</th>
					<th class="hidden-sm">Room(s)</th>
					<th class="hidden-sm">Room-Type(s)</th>
					<th class="hidden-sm">Date Added</th>
					<th class="text-center" style="width: 10%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				{{-- @php
                    $count=($all_reservations->perPage()*($all_reservations->currentPage() -1))+1;
                @endphp --}}
				@foreach($all_reservations as $reservation)
                    @php
                        $amtpaid = $reservation->success_payments->sum('amount')/100;
                    @endphp
                    <tr>
                        <td class="text-center font-w600"><a href="{{route('reservations-show',$reservation->id)}}">#{{$reservation->id}}</a></td>
                        <td class="font-w600">{{$reservation->full_name}}</td>
                        <td class="hidden-sm" data-sort="{{date_format(new DateTime($reservation->check_in),'Y-m-d')}}">{{date_format(new DateTime($reservation->check_in), 'jS F, Y')}}</td>
                        <td class="hidden-sm" data-sort="{{date_format(new DateTime($reservation->check_out),'Y-m-d')}}">{{date_format(new DateTime($reservation->check_out), 'jS F Y')}}</td>
                        <td class="hidden-sm">@if($reservation->reservation_type == 'complementary') <span class="badge badge-primary">Complementary</span> @endif @if($reservation->reservation_status == 'confirmed') <span class="badge badge-success">Confirmed</span>  @if($reservation->reservation_type != 'complementary') @if($amtpaid >= $reservation->grand_total) <span class="badge badge-success">Fully Paid</span> @elseif(($amtpaid > 0) && ($amtpaid < $reservation->grand_total)) <span class="badge badge-warning">Part Paid</span> @else<span class="badge badge-danger">Not Paid</span> @endif @endif  @elseif($reservation->reservation_status == 'pending') {!! strtotime($reservation->check_in) < strtotime(date('Y-m-d')) ? '<span class="badge badge-danger">Overdue</span>':'<span class="badge badge-warning">Pending</span>' !!} @elseif($reservation->reservation_status == 'rejected') <span class="badge badge-danger">Rejected</span> @else <span class="badge badge-danger">Cancelled</span> @endif</td>
                        <td class="hidden-xs">
                            @foreach ($reservation->details as $detail)
                                <span class="badge badge-primary">{{$detail->room->name ?? ''}}</span>
                            @endforeach
                        </td>
                        <td class="hidden-xs">
                            @php
                                $roomtypes = array();
                                foreach ($reservation->details as $detail){
                                    $roomtype = $detail->roomtype->name;
                                    if ($roomtype) {
                                        !in_array($roomtype,$roomtypes) ? $roomtypes[]=$roomtype : false;
                                    }
                                }
                            @endphp
                            @foreach ($roomtypes as $type)
                                <span class="badge badge-secondary">{{$type}}</span>
                            @endforeach
                        </td>
                        <td class="hidden-sm" data-sort="{{date_format(new DateTime($reservation->created_at),'Y-m-d')}}">{{date_format(new DateTime($reservation->created_at), 'l jS F Y')}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                @php
                                    $deleteurl = route('reservations-destroy',$reservation->id);
                                    // $successurl = route('settings-tab','users');
                                @endphp
                                @can('view reservations')<div style="display: inline-block;"><a href="{{route('reservations-show',$reservation->id)}}" class="btn btn-sm btn-alt-primary" data-toggle="tooltip" title="View Reservation"> <i class="fa fa-eye"> </i></a></div>@endcan
                                @can('edit reservations')<div style="display: inline-block;"><a href="{{route(($reservation->reservation_status=='pending' && $reservation->created_by==0) ? 'reservations-view-request':'reservations-edit',$reservation->id)}}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="{{($reservation->reservation_status=='pending' && $reservation->created_by==0) ? 'Respond To Reservation Request':'Edit Reservation'}}"> <i class="fa fa-edit"></i> </a></div>@endcan
                                @can('remove reservations')<div style="display: inline-block;"><button class="btn btn-sm btn-danger" type="button" data-toggle="tooltip" title="Remove Reservation" onclick="confimdelete('{{$deleteurl}}')"><i class="fa fa-times"> </i></button></div>@endcan
                            </div>
                        </td>
                    </tr>
				@endforeach
			</tbody>
		</table>
    </div>
</div>
<!-- END Dynamic Table Full -->

@endsection

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flatpickr/flatpickr.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/tables_datatables.js') }}"></script>

    <script>jQuery(function(){One.helpers(['flatpickr']);});</script>
    <script>
        function hideTodayDates(select) {
            if (select.value == 'today') {
                $("#daterange").hide();
            } else {
                $("#daterange").show();
            }
        }
    </script>

    <script id="blockOfStuff" type="text/html">
        <div class="paginate" style="margin-left: auto;">
            {{$all_reservations->onEachSide(1)->links()}}
        </div>
    </script>

    <script type="text/javascript">
        $(function () {
            jQuery(".js-dataTable-reservations").dataTable({
                pageLength: 200,
                responsive: true,
                scrollX: true,
                lengthMenu: [
                    [50, 100, 200, 500],
                    [50, 100, 200, 500]
                ],
                order: [[3, 'asc']],
                columnDefs: [
                    // { targets: [0, 1], visible: false },
                    { responsivePriority: 2, targets: -1 }
                ],
                searching: false,
                autoWidth: !1,
                buttons: [{ extend: "colvis", className: "btn btn-sm btn-alt-primary" }, { extend: "copy", className: "btn btn-sm btn-alt-primary" }, { extend: "csv", className: "btn btn-sm btn-alt-primary" }, { extend: "pdf", className: "btn btn-sm btn-alt-primary" }, { extend: "print", className: "btn btn-sm btn-alt-primary" }],
                dom: "<'row'<'col-sm-12'<'text-left py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
            })

            $('#DataTables_Table_0_info').html("Page {{$all_reservations->currentPage()}} of {{$all_reservations->lastPage()}}");
            $('#DataTables_Table_0_paginate').html("");
            var div = document.createElement('div');
            // div.setAttribute('class', 'someClass');
            div.innerHTML = document.getElementById('blockOfStuff').innerHTML;
            document.getElementById('DataTables_Table_0_paginate').appendChild(div);
        });
        var today = new Date();
        $('.today-flatpickr').flatpickr({ minDate: "today" });
        $('.review-old-flatpickr').flatpickr()
        // $('.review-old-flatpickr').flatpickr({ minDate: (today.setDate(today.getDate()-30)) })
    </script>

@endsection
