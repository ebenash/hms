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

            <div class="pull-right">
                <button type="submit" class="btn btn-dark">Generate</button>
            </div>
            </div>
        </div>
        <div class="block-content block-content-full">
            <!-- Form Search - Alternative Style -->
            <div class="row">
                <div class="col-lg-3">
                    <input type="text" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" id="search" name="search" value="{{isset($filter) ? $filter->search : ''}}" placeholder="Search" autocomplete="off">
                </div>
                <div class="col-lg-3">
                    <select name="filter_type" id="filter_type" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" required>
                        <option value="">Select Filter Type</option>
                        <option value="typereservationincome" {{isset($filter) ? ($filter->filter_type == 'typereservationincome' ? 'selected' : '') : ''}}>Reservation Income Summary</option>
                        <option value="typeroomincome" {{isset($filter) ? ($filter->filter_type == 'typeroomincome' ? 'selected' : '') : ''}}>Room Income Summary</option>
                        <option value="typeota" {{isset($filter) ? ($filter->filter_type == 'typeota' ? 'selected' : '') : ''}}>OTA Summary</option>
                        <option value="typepaystack" {{isset($filter) ? ($filter->filter_type == 'typepaystack' ? 'selected' : '') : ''}}>Paystack Invoices</option>
                        <option value="typesales" {{isset($filter) ? ($filter->filter_type == 'typesales' ? 'selected' : '') : ''}}>Sales Income</option>
                        {{-- <option value="typeguests" {{isset($filter) ? ($filter->filter_type == 'typeguests' ? 'selected' : '') : ''}}>Guests</option> --}}
                    </select>
                </div>
                <div class="col-lg-3">
                    <select name="reservation_status" id="reservation_status" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2">
                        <option value="">Select Reservation Status</option>
                        <option value="pending" {{isset($filter) ? ($filter->reservation_status == 'pending' ? 'selected' : '') : ''}}>Pending Confirmation/Requests</option>
                        <option value="confirmed" {{isset($filter) ? ($filter->reservation_status == 'confirmed' ? 'selected' : '') : ''}}>Confirmed Reservations</option>
                        <option value="cancelled" {{isset($filter) ? ($filter->reservation_status == 'cancelled' ? 'selected' : '') : ''}}>Cancelled Reservations</option>
                        <option value="rejected" {{isset($filter) ? ($filter->reservation_status == 'rejected' ? 'selected' : '') : ''}}>Rejected Reservations</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <input type="text" class="today-flatpickr form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" id="daterange" name="daterange" value="{{$filter->daterange ?? ''}}" placeholder="Select Date Range" data-mode="range">
                     {{-- data-min-date="today"> --}}
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
                {{-- <div style="display: inline-block;"><form method="post" action="{{route('reports-pdf')}}" target="_blank">{{ csrf_field() }} <input type="hidden" name="reservation_status" value="{{$filter->reservation_status}}"/><input type="hidden" name="daterange" value="{{$filter->daterange}}"/><button type="submit" data-toggle="tooltip" title="Export Data to PDF" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i> Export PDF </i></button></form></div>
                <div style="display: inline-block;"><form method="post" action="{{route('reports-excel')}}" target="_blank">{{ csrf_field() }} <input type="hidden" name="reservation_status" value="{{$filter->reservation_status}}"/><input type="hidden" name="daterange" value="{{$filter->daterange}}"/><button type="submit" data-toggle="tooltip" title="Export Data to Excel" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o"></i> Export Excel </i></button></form></div> --}}
            </div>
        </div>
        <div class="block-content block-content-full">
            <table class="table table-bordered table-striped table-vcenter js-dataTable-report">
                <thead>
                    <tr>
                        <td class="font-w600">No.</td>
                        @if(isset($filter) && $filter->filter_type == 'typesales')
                            <td class="font-w600">Description</td>
                            <td class="font-w600">Type</td>
                        @else
                            <td class="font-w600">Guest</td>
                        @endif
                        @if(isset($filter) && $filter->filter_type == 'typepaystack')
                            <th class="font-w600">Customer Number</th>
                            <th class="font-w600">Reservation</th>
                            <th class="font-w600">Invoice ID</th>
                            <th class="font-w600">Invoice Number</th>
                            <th class="font-w600">Amount</th>
                            <th class="font-w600">Request Code</th>
                        @elseif(isset($filter) && $filter->filter_type != 'typesales')
                            <td class="font-w600">Room(s)</td>
                            <td class="font-w600">Type</td>
                            <td class="font-w600">Arrival</td>
                            <td class="font-w600">Departure</td>
                        @endif
                        <td class="font-w600">Status</td>
                        @if(isset($filter) && $filter->filter_type == 'typepaystack')
                            <th class="font-w600">Paid At</th>
                        @else
                            <td class="font-w600">Method</td>
                            @if(isset($filter) && $filter->filter_type != 'typesales')
                                <td class="font-w600">Days</td>
                            @endif
                            @if(isset($filter) && $filter->filter_type == 'typeroomincome')
                                <td class="font-w600">Per Day(GHS)</td>
                            @elseif(isset($filter) && $filter->filter_type == 'typesales')
                                <td class="font-w600">Quantity</td>
                                <td class="font-w600">Price(GHS)</td>
                            @endif
                            <td class="font-w600">Total(GHS)</td>
                            @if(isset($filter) && $filter->filter_type != 'typeroomincome')
                                <td class="font-w600">Paid(GHS)</td>
                                <td class="font-w600">Balance(GHS)</td>
                                <td class="font-w600">VAT/Receipt Number</td>
                                <td class="font-w600">OTA Reservation Number</td>
                            @endif
                            {{-- @if(isset($filter) && $filter->filter_type == 'typeota')
                                <td class="font-w600">Reservation #</td>
                            @endif --}}
                        @endif
                        <td class="font-w600">Recorded</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count=($reports->perPage()*($reports->currentPage() -1))+1;
                    @endphp
                    @foreach($reports as $report)
                        <tr>
                            {{-- @if(isset($filter) && $filter->filter_type == 'typesales')
                                @foreach ($report->details as $item)
                                    <td class="text-center font-w600"><a href="{{route('reservations-show',$item->reservations_id)}}">#{{$item->reservation_id}}</a></td>
                                @endforeach
                            @else --}}
                                @if(isset($filter) && $filter->filter_type == 'typepaystack')
                                    <td class="text-center">{{$count++}}</td>
                                @else
                                    <td class="text-center font-w600">@if($report->id)<a href="{{route('reservations-show',$report->id)}}">#{{$report->id}}</a>@endif</td>
                                @endif
                                @if(isset($filter) && $filter->filter_type == 'typesales')
                                    <td class="hidden-xs"><span>{{$report->description}}</span></td>
                                    <td class="hidden-xs"><span>{{ucfirst($report->type)}}</span></td>
                                @else
                                    <td class="hidden-xs"><span>{{$report->full_name}}</span></td>
                                @endif
                                @if(isset($filter) && $filter->filter_type == 'typepaystack')
                                    <td class="hidden-xs">{{$report->customer}}</td>
                                    <td class="font-w600">@if($report->reservation_id)<a href="{{route('reservations-show',$report->reservation_id)}}">#{{$report->reservation_id}}</a>@endif</td>
                                    <td class="hidden-xs">{{$report->invoice_id}}</td>
                                    <td class="hidden-xs">{{$report->invoice_number}}</td>
                                    <td class="font-w600">{{$report->currency.' '.number_format($report->amount/100,2)}}</td>
                                    <td class="hidden-xs">{{$report->request_code}}</td>
                                    <td class="hidden-xs"><span class="badge badge-{{$report->status == 'success' ? 'success':'warning'}}">{{$report->status == 'success' ? 'Success':'Pending'}}</span> <span class="badge badge-{{$report->paid ? 'success':'danger'}}">{{$report->paid ? 'Paid':'Unpaid'}}</span></td>
                                    <td class="hidden-xs">{{$report->paid_at}}</td>
                                @else
                                    @if(isset($filter) && $filter->filter_type != 'typeroomincome' && $filter->filter_type != 'typesales')
                                        <td class="hidden-xs">
                                            @foreach ($report->details as $detail)
                                                <span class="badge badge-primary">{{$detail->room->name ?? ''}}</span>
                                            @endforeach
                                        </td>
                                        <td class="hidden-xs">
                                            @php
                                                $roomtypes = array();
                                                foreach ($report->details as $detail){
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
                                    @elseif(isset($filter) && $filter->filter_type != 'typesales')
                                        <td class="hidden-xs">{{$report->room_name ?? 'Unassigned'}}</td>
                                        <td class="hidden-xs">{{$report->room_type ?? 'Unassigned'}}</td>
                                    @endif
                                    @if(isset($filter) && $filter->filter_type != 'typesales')
                                        <td class="hidden-xs">{{$report->check_in}}</td>
                                        <td class="hidden-xs">{{$report->check_out}}</td>
                                        <td class="hidden-xs">@if($report->payment_method == 'complementary') <span class="badge badge-primary">Complementary</span> @endif @if($report->reservation_status == 'confirmed') <span class="badge badge-success">Confirmed</span>  @if($report->payment_method != 'complementary') @if($report->paid == 'full') <span class="badge badge-success">Fully Paid</span> @elseif($report->paid == 'part') <span class="badge badge-warning">Part Paid</span> @else<span class="badge badge-danger">Not Paid</span> @endif @endif  @elseif($report->reservation_status == 'pending') {!! strtotime($report->check_in) < strtotime(date('Y-m-d')) ? '<span class="badge badge-danger">Overdue</span>':'<span class="badge badge-warning">Pending</span>' !!} @elseif($report->reservation_status == 'rejected') <span class="badge badge-danger">Rejected</span> @else <span class="badge badge-danger">Cancelled</span> @endif</td>
                                    @else
                                        <td class="hidden-xs">@if($report->payment_method == 'complementary') <span class="badge badge-primary">Complementary</span> @endif @if($report->reservation_status == 'confirmed') <span class="badge badge-success">Confirmed</span>  @if($report->payment_method != 'complementary') @if($report->paid == 'full') <span class="badge badge-success">Fully Paid</span> @elseif($report->paid == 'part') <span class="badge badge-warning">Part Paid</span> @else<span class="badge badge-danger">Not Paid</span> @endif @endif @elseif($report->reservation_status == 'pending') <span class="badge badge-warning">Pending</span> @elseif($report->reservation_status == 'rejected') <span class="badge badge-danger">Rejected</span> @else <span class="badge badge-danger">Cancelled</span> @endif</td>
                                    @endif
                                    <td class="text-center">{{ucfirst($report->payment_method)}}</td>
                                    @if(isset($filter) && $filter->filter_type != 'typesales')
                                        <td class="text-center">{{$report->days}}</td>
                                    @endif
                                    @if(isset($filter) && $filter->filter_type == 'typeroomincome')
                                        <td class="hidden-xs">{{ number_format($report->price_per_day,2)}}</td>
                                    @elseif(isset($filter) && $filter->filter_type == 'typesales')
                                        <td class="hidden-xs">{{$report->quantity}}</td>
                                        <td class="hidden-xs">{{$report->total_price ?? 0}}</td>
                                    @endif
                                    <td class="hidden-xs">{{ number_format($report->grand_total,2)}}</td>
                                    @if(isset($filter) && $filter->filter_type != 'typeroomincome')
                                        <td class="hidden-xs">{{ number_format(($report->amount_paid),2)}}</td>
                                        <td class="hidden-xs">{{ number_format(($report->balance),2)}}</td>
                                        <td class="hidden-xs">{{$report->vat_invoice_number}}</td>
                                        <td class="hidden-xs">{{$report->ota_reservation_number}}</td>
                                    @endif
                                    {{-- @if(isset($filter) && $filter->filter_type == 'typeota')
                                        <td class="hidden-xs">{{$report->ota_reservation_number}}</td>
                                    @endif --}}
                                @endif
                            {{-- @endif --}}
                            <td class="hidden-xs">{{$report->created_at}}</td>
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
    {{-- <script>
        function hideFilterFields(select) {
            if (select.value == 'today') {
                $("#daterange").hide();
            } else {
                $("#daterange").show();
            }
        }
    </script> --}}
    <script id="blockOfStuff" type="text/html">
        <div class="paginate" style="margin-left: auto;">
            {{$reports->onEachSide(1)->links()}}
        </div>
    </script>

    <script type="text/javascript">
        $(function () {
            $('#DataTables_Table_0_info').html("Page {{$reports->currentPage()}} of {{$reports->lastPage()}}");
            $('#DataTables_Table_0_paginate').html("");
            var div = document.createElement('div');
            // div.setAttribute('class', 'someClass');
            div.innerHTML = document.getElementById('blockOfStuff').innerHTML;
            document.getElementById('DataTables_Table_0_paginate').appendChild(div);
        });
        $('.today-flatpickr').flatpickr()
        $(".table").addClass("compact nowrap w-100");
//         $('#report_filtered').dataTable( {
//   "scrollX": true
// } );
    </script>
@endsection
