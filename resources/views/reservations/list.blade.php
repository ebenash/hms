@extends('layouts.app')
@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        @if(isset($today))
            Today's Confirmed Check-Ins<small></small>
        @elseif(isset($tomorrow))
            Tomorrow's Confirmed Check-Ins<small></small>
        @elseif(isset($requests))
            Requested Reservations<small></small>
        @elseif(isset($cancelled))
            Cancelled Reservations<small></small>
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
        <div class="block-content block-content-full form-inline"">
            <!-- Form Search - Alternative Style -->
            <div class="row">
                <div class="col-lg-12">
                    <select name="filter_type" id="filter_type" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2 col-lg-3" onchange="hideTodayDates(this)">
                        <option value="">Select Filter Type</option>
                        <option value="today" {{isset($today) ? 'selected' : ''}}>Today's Reservations</option>
                        <option value="requests" {{isset($requests) ? 'selected' : ''}}>Reservation Requests</option>
                        <option value="confirmed" {{isset($confirmed) ? 'selected' : ''}}>Confirmed Reservations</option>
                        <option value="cancelled" {{isset($cancelled) ? 'selected' : ''}}>Cancelled Reservations</option>
                    </select>
                    <input type="text" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2 col-lg-2" name="guest" value="{{isset($filter['guest']) ? $filter['guest'] : ''}}" placeholder="Guest">
                    <select name="room" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2 col-lg-2">
                        <option value="">Select Room</option>
                        @foreach ($all_rooms as $room)
                            <option value="{{$room->id}}" {{isset($filter['room']) ? ($filter['room'] == $room->id ? 'selected' : '') : ''}}>{{$room->name}}</option>
                        @endforeach
                    </select>
                    <select name="room_type" id="room_type" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2 col-lg-2">
                        <option value="">Select Room Type</option>
                        @foreach ($all_roomtypes as $roomtype)
                            <option value="{{$roomtype->id}}" {{isset($filter['room_type']) ? ($filter['room_type'] == $roomtype->id ? 'selected' : '') : ''}}>{{$roomtype->name}}</option>
                        @endforeach
                    </select>
                    <input type="text" class="js-flatpickr form-control form-control-alt mb-2 mr-sm-2 mb-sm-2 col-lg-2" id="daterange" name="daterange" value="{{isset($filter['daterange']) ? $filter['daterange'] : ''}}" placeholder="Select Date Range" data-mode="range">
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
            @if(isset($today))
                Today's <small>Check-Ins</small>
            @elseif(isset($tomorrow))
                Tomorrow's <small>Check-Ins</small>
            @elseif(isset($requests))
                Reservation <small>Requests</small>
            @elseif(isset($request))
                Cancelled <small>Requests</small>
            @else
                Confirmed <small>Reservations</small>
            @endif
        </h3>

		<div class="pull-right">
			@can('add reservations')<a href="{{route('reservations-create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New Reservation</a>@endcan
			@if(isset($today))
			    <a href="{{route('reservations-tomorrow')}}" class="btn btn-sm btn-primary"><i class="fa fa-calendar-check"></i> View Tomorrow's Check-Ins</a>
			@endif
			@if(isset($tomorrow))
			    <a href="{{route('reservations-today')}}" class="btn btn-sm btn-primary"><i class="fa fa-calendar-check"></i> View Today's Check-Ins</a>
			@endif
		</div>
    </div>
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->

        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
			<thead>
				<tr>
					<th class="hidden-sm">#</th>
					<th>Guest</th>
					<th class="hidden-sm">Room</th>
					<th class="hidden-sm">Check-In</th>
					<th class="hidden-sm">Check-Out</th>
					<th class="hidden-sm">Status</th>
					<th class="text-center" style="width: 10%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				@php
                    $count=($all_reservations->perPage()*($all_reservations->currentPage() -1))+1;
                @endphp
				@foreach($all_reservations as $reservation)
                    <tr>
                        <td class="text-center">{{$count++}}</td>
                        <td class="font-w600">{{$reservation->full_name}}</td>
                        <td class="hidden-sm">{{$reservation->roomname ?? 'Unassigned'}}</td>
                        <td class="hidden-sm">{{date_format(new DateTime($reservation->check_in), 'l jS F, Y')}}</td>
                        <td class="hidden-sm">{{date_format(new DateTime($reservation->check_out), 'l jS F Y')}}</td>
                        <td class="hidden-sm">@if($reservation->reservation_status == 'confirmed') <span class="badge badge-success">Confirmed</span>  @elseif($reservation->reservation_status == 'pending') {!! strtotime($reservation->check_in) < strtotime(date('Y-m-d')) ? '<span class="badge badge-danger">Overdue</span>':'<span class="badge badge-warning">Pending</span>' !!} @else <span class="badge badge-danger">Cancelled</span> @endif</td>
                        <td class="text-center">
                            <div class="btn-group">
                                @php
                                    $deleteurl = route('reservations-destroy',$reservation->id);
                                    // $successurl = route('settings-tab','users');
                                @endphp
                                @can('view reservations')<div style="display: inline-block;"><a href="{{route('reservations-show',$reservation->id)}}" class="btn btn-sm btn-alt-primary" data-toggle="tooltip" title="View Reservation"> <i class="fa fa-eye"> </i></a></div>@endcan
                                @can('edit reservations')<div style="display: inline-block;"><a href="{{route($reservation->reservation_status=='pending' ? 'reservations-view-request':'reservations-edit',$reservation->id)}}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="{{$reservation->reservation_status=='pending' ? 'Respond To Reservation Request':'Edit Reservation'}}"> <i class="fa fa-edit"></i> </a></div>@endcan
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
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
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
            $('#DataTables_Table_0_info').html("Page {{$all_reservations->currentPage()}} of {{$all_reservations->lastPage()}}");
            $('#DataTables_Table_0_paginate').html("");
            var div = document.createElement('div');
            // div.setAttribute('class', 'someClass');
            div.innerHTML = document.getElementById('blockOfStuff').innerHTML;
            document.getElementById('DataTables_Table_0_paginate').appendChild(div);
        });
    </script>

@endsection
