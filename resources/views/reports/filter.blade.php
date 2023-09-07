@extends('layouts.app')
@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        Reports
    </h1>
@endsection
@section('content')

<!-- Search -->
<div class="block block-rounded">
    <form action="{{route('reports-filter')}}" method="GET">
        {{-- @csrf --}}
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
                <div class="col-lg-3" id="searchdiv">
                    <input type="text" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" id="search" name="search" value="{{isset($filter) ? $filter->search : ''}}" placeholder="Search" autocomplete="off">
                </div>
                <div class="col-lg-3" id="filter_typediv">
                    <select name="filter_type" id="filter_type" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" required onchange="filterHide()">
                        <option value="">Select Filter Type</option>
                        <option value="typereservationincome" {{isset($filter) ? ($filter->filter_type == 'typereservationincome' ? 'selected' : '') : ''}}>Reservation Income Summary</option>
                        <option value="typeroomincome" {{isset($filter) ? ($filter->filter_type == 'typeroomincome' ? 'selected' : '') : ''}}>Room Income Summary</option>
                        <option value="typeota" {{isset($filter) ? ($filter->filter_type == 'typeota' ? 'selected' : '') : ''}}>OTA Summary</option>
                        <option value="typepaystack" {{isset($filter) ? ($filter->filter_type == 'typepaystack' ? 'selected' : '') : ''}}>Paystack Invoices</option>
                        <option value="typepayments" {{isset($filter) ? ($filter->filter_type == 'typepayments' ? 'selected' : '') : ''}}>Payments</option>
                        <option value="typeroomsavailable" {{isset($filter) ? ($filter->filter_type == 'typeroomsavailable' ? 'selected' : '') : ''}}>Room Availability</option>
                        <option value="typeunpaid" {{isset($filter) ? ($filter->filter_type == 'typeunpaid' ? 'selected' : '') : ''}}>Balance Receivable Reservations</option>
                        {{-- <option value="typeguests" {{isset($filter) ? ($filter->filter_type == 'typeguests' ? 'selected' : '') : ''}}>Guests</option> --}}
                    </select>
                </div>
                <div class="col-lg-3" id="reservation_statusdiv">
                    <select name="reservation_status" id="reservation_status" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2">
                        <option value="">Select Reservation Status</option>
                        <option value="pending" {{isset($filter) ? ($filter->reservation_status == 'pending' ? 'selected' : '') : ''}}>Pending Confirmation/Requests</option>
                        <option value="confirmed" {{isset($filter) ? ($filter->reservation_status == 'confirmed' ? 'selected' : '') : ''}}>Confirmed Reservations</option>
                        <option value="cancelled" {{isset($filter) ? ($filter->reservation_status == 'cancelled' ? 'selected' : '') : ''}}>Cancelled Reservations</option>
                        <option value="rejected" {{isset($filter) ? ($filter->reservation_status == 'rejected' ? 'selected' : '') : ''}}>Rejected Reservations</option>
                    </select>
                </div>
                <div class="col-lg-3" id="daterangediv">
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
            <table class="table table-bordered table-striped table-vcenter js-dataTable-reports">
                <thead>
                    <tr>
                        <td class="font-w600">No.</td>
                        @if(isset($filter) && $filter->filter_type == 'typesales')
                            <td class="font-w600">Description</td>
                            <td class="font-w600">Type</td>
                        @elseif(isset($filter) && $filter->filter_type == 'typepayments')
                        @else
                            @if(isset($filter) && $filter->filter_type != 'typeroomsavailable')
                                <td class="font-w600">Guest</td>
                            @endif
                        @endif
                        @if(isset($filter) && $filter->filter_type == 'typepaystack')
                            <th class="font-w600">Customer Number</th>
                            <th class="font-w600">Reservation</th>
                            <th class="font-w600">Invoice ID</th>
                            <th class="font-w600">Invoice Number</th>
                            <th class="font-w600">Amount</th>
                            <th class="font-w600">Request Code</th>
                        @elseif(isset($filter) && $filter->filter_type == 'typepayments')
                            <th class="font-w600">Type</th>
                            <th class="font-w600">Reservation</th>
                            <th class="font-w600">Payment Method</th>
                            <th class="font-w600">Amount</th>
                            <th class="font-w600">Reference</th>
                            <th class="font-w600">Reciept Number</th>
                        @elseif(isset($filter) && $filter->filter_type != 'typesales')
                            <th class="font-w600">Room(s)</th>
                            <th class="font-w600">Room Type</th>
                            @if(isset($filter) && $filter->filter_type != 'typeroomsavailable')
                                <th class="font-w600">Arrival</th>
                                <th class="font-w600">Departure</th>
                                <th class="font-w600">Type</th>
                            @endif
                        @endif
                        <th class="font-w600">Status</th>
                        @if(isset($filter) && $filter->filter_type == 'typeroomsavailable')
                            <th class="font-w600">Category</th>
                            <th class="font-w600">Max Persons</th>
                        @endif
                        @if(isset($filter) && $filter->filter_type == 'typepayments')
                            <th class="font-w600">Received By</th>
                        @endif
                        @if(isset($filter) && $filter->filter_type == 'typepaystack')
                            <th class="font-w600">Paid At</th>
                        @else
                            @if(isset($filter) && $filter->filter_type != 'typesales' && $filter->filter_type != 'typepayments' && $filter->filter_type != 'typeroomsavailable')
                                <th class="font-w600">Days</th>
                            @endif
                            @if(isset($filter) && $filter->filter_type == 'typeroomincome')
                                <th class="font-w600">Per Day(GHS)</th>
                            @elseif(isset($filter) && $filter->filter_type == 'typesales')
                                <th class="font-w600">Quantity</th>
                                <th class="font-w600">Price(GHS)</th>
                            @endif
                            @if(isset($filter) && $filter->filter_type != 'typepayments' && $filter->filter_type != 'typeroomsavailable')
                                <th class="font-w600">Total(GHS)</th>
                                @if(isset($filter) && $filter->filter_type != 'typeroomincome')
                                    <th class="font-w600">Paid(GHS)</th>
                                    <th class="font-w600">Balance(GHS)</th>
                                    <th class="font-w600">OTA Reservation Number</th>
                                @endif
                                {{-- @if(isset($filter) && $filter->filter_type == 'typeota')
                                    <th class="font-w600">Reservation #</th>
                                @endif --}}
                            @endif
                        @endif
                        @if(isset($filter) && $filter->filter_type != 'typeroomsavailable')
                            <th class="font-w600">Recorded</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count=($reports->perPage()*($reports->currentPage() -1))+1;
                    @endphp
                    @foreach($reports as $report)
                        @if(isset($filter) && $filter->filter_type == 'typeunpaid')
                            @php
                                $amtpaid = $report->success_payments->sum('amount')/100;
                                if ($amtpaid >= $report->grand_total) {
                                    continue;
                                }
                            @endphp
                        @endif
                        <tr>
                            {{-- @if(isset($filter) && $filter->filter_type == 'typesales')
                                @foreach ($report->details as $item)
                                    <td class="text-center font-w600"><a href="{{route('reservations-show',$item->reservations_id)}}">#{{$item->reservation_id}}</a></td>
                                @endforeach
                            @else --}}
                                @if(isset($filter) && ($filter->filter_type == 'typepaystack' || $filter->filter_type == 'typepayments' || $filter->filter_type == 'typeroomsavailable'))
                                    <td class="text-center">{{$count++}}</td>
                                @else
                                    <td class="text-center font-w600">@if($report->id)<a href="{{route('reservations-show',$report->id)}}">#{{$report->id}}</a>@endif</td>
                                @endif
                                @if(isset($filter) && $filter->filter_type == 'typesales')
                                    <td class="hidden-xs"><span>{{$report->description}}</span></td>
                                    <td class="hidden-xs"><span>{{ucfirst($report->type)}}</span></td>
                                @elseif(isset($filter) && $filter->filter_type == 'typepayments')
                                @else
                                    @if(isset($filter) && $filter->filter_type != 'typeroomsavailable')
                                        <td class="hidden-xs"><span>{{$report->full_name}}</span></td>
                                    @endif
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
                                @elseif(isset($filter) && $filter->filter_type == 'typepayments')
                                    <td class="hidden-xs">{{ucfirst($report->payment_type)}}</td>
                                    <td class="font-w600">@if($report->payment_type=='reservation' && isset($report->payment_type_id))<a href="{{route('reservations-show',$report->payment_type_id)}}">#{{$report->payment_type_id}}</a>@endif</td>
                                    <td class="hidden-xs">{{ucfirst($report->provider)}}</td>
                                    <td class="font-w600">{{$report->currency.' '.number_format($report->amount/100,2)}}</td>
                                    <td class="hidden-xs">{{$report->reference}}</td>
                                    <td class="hidden-xs">{{$report->vat_invoice_number}}</td>
                                    <td class="hidden-xs"><span class="badge badge-{{$report->status == 'success' ? 'success':'warning'}}">{{$report->status == 'success' ? 'Paid':'Unpaid'}}</span></td>
                                    <td class="hidden-xs">{{$report->received_by}}</td>
                                @else
                                    @if(isset($filter) && $filter->filter_type != 'typeroomincome' && $filter->filter_type != 'typepayments' && $filter->filter_type != 'typeroomsavailable')
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
                                    @if(isset($filter) && $filter->filter_type != 'typesales' && $filter->filter_type != 'typeroomsavailable')
                                        @php
                                            $amtpaid = ($report->success_payments->sum('amount') ?? 0)/100;
                                        @endphp

                                        <td class="hidden-xs">{{$report->check_in}}</td>
                                        <td class="hidden-xs">{{$report->check_out}}</td>
                                        <td class="hidden-xs">{{ucfirst($report->reservation_type)}}</td>
                                        <td class="hidden-xs">@if($report->reservation_type == 'complementary') <span class="badge badge-primary">Complementary</span> @endif @if($report->reservation_status == 'confirmed') <span class="badge badge-success">Confirmed</span>  @if($report->reservation_type != 'complementary') @if($amtpaid >= $report->grand_total) <span class="badge badge-success">Fully Paid</span> @elseif(($amtpaid > 0) && ($amtpaid < $report->grand_total)) <span class="badge badge-warning">Part Paid</span> @else<span class="badge badge-danger">Not Paid</span> @endif @endif  @elseif($report->reservation_status == 'pending') {!! strtotime($report->check_in) < strtotime(date('Y-m-d')) ? '<span class="badge badge-danger">Overdue</span>':'<span class="badge badge-warning">Pending</span>' !!} @elseif($report->reservation_status == 'rejected') <span class="badge badge-danger">Rejected</span> @else <span class="badge badge-danger">Cancelled</span> @endif</td>
                                    @else
                                        @if(isset($filter) && $filter->filter_type == 'typeroomsavailable')
                                            <td class="hidden-xs">@if($report->status == 1) <span class="badge badge-success">Available</span>  @else <span class="badge badge-danger">Inactive</span> @endif</td>
                                        @else
                                            <td class="hidden-xs">@if($report->reservation_type == 'complementary') <span class="badge badge-primary">Complementary</span> @endif @if($report->reservation_status == 'confirmed') <span class="badge badge-success">Confirmed</span>  @if($report->reservation_type != 'complementary') @if($report->paid == 'full') <span class="badge badge-success">Fully Paid</span> @elseif($report->paid == 'part') <span class="badge badge-warning">Part Paid</span> @else<span class="badge badge-danger">Not Paid</span> @endif @endif @elseif($report->reservation_status == 'pending') <span class="badge badge-warning">Pending</span> @elseif($report->reservation_status == 'rejected') <span class="badge badge-danger">Rejected</span> @else <span class="badge badge-danger">Cancelled</span> @endif</td>
                                        @endif
                                    @endif
                                    @if(isset($filter) && $filter->filter_type != 'typesales' && $filter->filter_type != 'typeroomsavailable')
                                        <td class="text-center">{{$report->days}}</td>
                                    @endif
                                    @if(isset($filter) && $filter->filter_type == 'typeroomincome')
                                        <td class="hidden-xs">{{ number_format($report->price_per_day,2)}}</td>
                                    @elseif(isset($filter) && $filter->filter_type == 'typesales')
                                        <td class="hidden-xs">{{$report->quantity}}</td>
                                        <td class="hidden-xs">{{$report->total_price ?? 0}}</td>
                                    @endif
                                    @if(isset($filter) && $filter->filter_type == 'typeroomsavailable')
                                        <td class="hidden-xs">{{ucfirst($report->category ?? 'room')}}</td>
                                        <td class="hidden-xs">{{$report->max_persons ?? 0}}</td>
                                    @else
                                        <td class="hidden-xs">{{ number_format($report->grand_total,2)}}</td>
                                    @endif
                                    @if(isset($filter) && ($filter->filter_type != 'typeroomincome' && $filter->filter_type != 'typepayments' && $filter->filter_type != 'typeroomsavailable'))
                                        @php
                                            $amtpaid = ($report->success_payments->sum('amount') ?? 0)/100;
                                        @endphp
                                        <td class="hidden-xs">{{ number_format(($amtpaid),2)}}</td>
                                        <td class="hidden-xs">{{ number_format((($report->grand_total-$amtpaid)),2)}}</td>
                                        <td class="hidden-xs">{{$report->ota_reservation_number}}</td>
                                    @endif
                                    {{-- @if(isset($filter) && $filter->filter_type == 'typeota')
                                        <td class="hidden-xs">{{$report->ota_reservation_number}}</td>
                                    @endif --}}
                                @endif
                            {{-- @endif --}}
                            @if(isset($filter) && $filter->filter_type != 'typeroomsavailable')
                                <td class="hidden-xs">{{$report->created_at}}</td>
                            @endif
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
            jQuery(".js-dataTable-reports").dataTable({
                pageLength: 200,
                responsive: true,
                scrollX: true,
                // lengthMenu: [
                //     [50, 100, 200, 500],
                //     [50, 100, 200, 500]
                // ],
                lengthChange: false,
                columnDefs: [
                    // { targets: [0, 1], visible: false },
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 1 },
                    { responsivePriority: 3, targets: 7 },
                    { responsivePriority: 4, targets: -1 }
                ],
                searching: false,
                autoWidth: !1,
                buttons: [{ extend: "colvis", className: "btn btn-sm btn-alt-primary" }, { extend: "copy", className: "btn btn-sm btn-alt-primary" }, { extend: "csv", className: "btn btn-sm btn-alt-primary" }, { extend: "pdf", className: "btn btn-sm btn-alt-primary" }, { extend: "print", className: "btn btn-sm btn-alt-primary" }],
                dom: "<'row'<'col-sm-12'<'text-left py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
            })
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


        function filterHide() {
            var type = $("#filter_type").val();
            console.log(type);
            if (type == 'typepaystack' || type == 'typepayments') {
                $("#searchdiv").show();
                $("#reservation_statusdiv").hide();

                $("#searchdiv").attr('class', 'col-lg-4');
                $("#filter_typediv").attr('class', 'col-lg-4');
                $("#daterangediv").attr('class', 'col-lg-4');
            }else if (type == 'typeroomsavailable' || type == 'typeunpaid') {
                $("#searchdiv").hide();
                $("#reservation_statusdiv").hide();

                $("#filter_typediv").attr('class', 'col-lg-6');
                $("#daterangediv").attr('class', 'col-lg-6');
            }else{
                $("#searchdiv").show();
                $("#reservation_statusdiv").show();

                $("#searchdiv").attr('class', 'col-lg-3');
                $("#filter_typediv").attr('class', 'col-lg-3');
                $("#reservation_statusdiv").attr('class', 'col-lg-3');
                $("#daterangediv").attr('class', 'col-lg-3');
            }
        }
    </script>
@endsection
