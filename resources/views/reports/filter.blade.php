@extends('layouts.app')
@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        Reports
    </h1>
@endsection
@section('content')

<!-- Search -->
<div class="block block-rounded">
    <form action="{{route('reports-filter')}}" method="POST">
        @csrf
        <div class="block-header">
            <h3 class="block-title">Filter</h3>
            <div class="pull-right">
                {{-- <button type="submit" class="btn btn-dark">Generate Report</button> --}}
            </div>
        </div>
        <div class="block-content block-content-full">
            <!-- Form Search - Alternative Style -->
            <div class="row">
                <div class="form-group col-lg-3">
                    <select name="filter_type" id="filter_type" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" disabled onchange="hideFilterFields(this)">
                        <option value="">Select Filter Type</option>
                        <option value="typereservation" selected {{isset($filter) ? ($filter->filter_type == 'typereservation' ? 'selected' : '') : ''}}>Reservations</option>
                        {{-- <option value="typerooms" {{isset($filter) ? ($filter->filter_type == 'typerooms' ? 'selected' : '') : ''}}>Rooms</option> --}}
                        {{-- <option value="typeroomtypes" {{isset($filter) ? ($filter->filter_type == 'typeroomtypes' ? 'selected' : '') : ''}}>Room Types</option> --}}
                        {{-- <option value="typeguests" {{isset($filter) ? ($filter->filter_type == 'typeguests' ? 'selected' : '') : ''}}>Guests</option> --}}
                    </select>
                    <input type="hidden" name="filter_type" value="typereservation">
                </div>
                <div class="form-group col-lg-3">
                    <select name="reservation_status" id="reservation_status" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2">
                        <option value="">Select Reservation Status</option>
                        <option value="pending" {{isset($filter) ? ($filter->reservation_status == 'pending' ? 'selected' : '') : ''}}>Pending Confirmation/Requests</option>
                        <option value="confirmed" {{isset($filter) ? ($filter->reservation_status == 'confirmed' ? 'selected' : '') : ''}}>Confirmed Reservations</option>
                        <option value="cancelled" {{isset($filter) ? ($filter->reservation_status == 'cancelled' ? 'selected' : '') : ''}}>Cancelled Reservations</option>
                    </select>
                </div>
                    {{-- <select name="room_type" id="room_type" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2 col-lg-2">
                        @foreach ($all_roomtypes as $roomtype)
                            <option value="{{$roomtype->id}}" {{isset($filter['room_type']) ? ($filter['room_type'] == $roomtype->id ? 'selected' : '') : ''}}>{{$roomtype->name ?? 'Undefined Room Type'}}</option>
                        @endforeach
                    </select> --}}
                <div class="form-group col-lg-4">
                    <input type="text" class="js-flatpickr form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" id="daterange" name="daterange" value="{{$filter->daterange ?? ''}}" placeholder="Select Date Range" data-mode="range">
                     {{-- data-min-date="today"> --}}
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- END Search -->
@if (isset($filter))
    <!-- Dynamic Table Full -->
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">
                Filter <small>Reports</small>
            </h3>

            <div class="pull-right">
                <div style="display: inline-block;"><form method="post" action="{{route('reports-pdf')}}" target="_blank">{{ csrf_field() }} <input type="hidden" name="reservation_status" value="{{$filter->reservation_status}}"/><input type="hidden" name="daterange" value="{{$filter->daterange}}"/><button type="submit" data-toggle="tooltip" title="Export Data to PDF" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i> Export PDF </i></button></form></div>
                <div style="display: inline-block;"><form method="post" action="{{route('reports-excel')}}" target="_blank">{{ csrf_field() }} <input type="hidden" name="reservation_status" value="{{$filter->reservation_status}}"/><input type="hidden" name="daterange" value="{{$filter->daterange}}"/><button type="submit" data-toggle="tooltip" title="Export Data to Excel" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o"></i> Export Excel </i></button></form></div>
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-report">
                <thead>
                    <tr>
                        <td class="font-w600">#</td>
                        <td class="font-w600">Name</td>
                        <td class="font-w600">Room</td>
                        <td class="font-w600">Type</td>
                        <td class="font-w600">Arrival</td>
                        <td class="font-w600">Departure</td>
                        <td class="font-w600">Status</td>
                        <td class="font-w600">Days</td>
                        <td class="font-w600">Price</td>
                        <td class="font-w600">Total</td>
                        {{-- <td class="font-w600">Recorded</td> --}}
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count=($reservations->perPage()*($reservations->currentPage() -1))+1;
                    @endphp
                    @foreach($reservations as $reservation)
                        <tr>
                            <td class="text-center">{{$count++}}</td>
                            <td class="hidden-xs">{{$reservation->guest->full_name}}</td>
                            <td class="hidden-xs">{{$reservation->room->name ?? 'Unassigned Room'}}</td>
                            <td class="hidden-xs">{{$reservation->roomtype->name ?? 'Undefined Room Type'}}</td>
                            <td class="hidden-xs">{{date_format(new DateTime($reservation->check_in), 'jS F, Y')}}</td>
                            <td class="hidden-xs">{{date_format(new DateTime($reservation->check_out), 'jS F, Y')}}</td>
                            <td class="hidden-xs">@if($reservation->reservation_status == 'confirmed') <span class="badge badge-success">Confirmed</span>  @elseif($reservation->reservation_status == 'pending') <span class="badge badge-warning">Pending</span> @else <span class="badge badge-danger">Cancelled</span> @endif</td>
                            <td class="text-center">{{$reservation->days}}</td>
                            <td class="hidden-xs">{{$reservation->currency." ".number_format(($reservation->price/$reservation->days),2)}}</td>
                            <td class="hidden-xs">{{$reservation->currency." ".number_format($reservation->price,2)}}</td>
                            {{-- <td class="hidden-xs">{{date_format(new DateTime($reservation->created_at), 'jS F, Y')}}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Dynamic Table Full -->
@endif

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
        function hideFilterFields(select) {
            if (select.value == 'today') {
                $("#daterange").hide();
            } else {
                $("#daterange").show();
            }
        }
    </script>
    <script id="blockOfStuff" type="text/html">
        <div class="paginate" style="margin-left: auto;">
            {{$reservations->onEachSide(1)->links()}}
        </div>
    </script>

    <script type="text/javascript">
        $(function () {
            $('#DataTables_Table_0_info').html("Page {{$reservations->currentPage()}} of {{$reservations->lastPage()}}");
            $('#DataTables_Table_0_paginate').html("");
            var div = document.createElement('div');
            // div.setAttribute('class', 'someClass');
            div.innerHTML = document.getElementById('blockOfStuff').innerHTML;
            document.getElementById('DataTables_Table_0_paginate').appendChild(div);
        });
    </script>
@endsection
