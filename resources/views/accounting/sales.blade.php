@extends('layouts.app')

@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        Other Sales {{$today? " From Today" : ""}}
    </h1>
@endsection

@section('content')
<!-- Search -->
<div class="block block-rounded">
    <form action="{{route('sale-filter')}}" method="GET">
        {{-- @csrf --}}
        <div class="block-header">
            <h3 class="block-title">Search</h3>
            <div class="pull-right">
                <button type="submit" class="btn btn-dark">Submit Filter</button>
            </div>
        </div>
        <div class="block-content block-content-full">
            <!-- Form Search - Alternative Style -->
            <div class="row">
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" name="search" value="{{isset($filter['search']) ? $filter['search'] : ''}}" placeholder="Search">
                </div>
                <div class="col-lg-3">
                    <select name="filter_type" id="filter_type" class="form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" onchange="hideTodayDates(this)">
                        <option value="">Select Filter Type</option>
                        <option value="pending" {{isset($filter['filter_type']) ? ($filter['filter_type'] == 'pending' ? 'selected' : '') : ''}}>Pending</option>
                        <option value="paid" {{isset($filter['filter_type']) ? ($filter['filter_type'] == 'paid' ? 'selected' : '') : ''}}>Paid</option>
                    </select>
                </div>
                <div class="col-lg-5">
                    <input type="text" class="today-flatpickr form-control form-control-alt mb-2 mr-sm-2 mb-sm-2" id="daterange" name="daterange" value="{{isset($filter['daterange']) ? $filter['daterange'] : date('Y-m-d')}}" placeholder="Select Date Range" data-mode="range">
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
        <h3 class="block-title">Other <small>Sales{{$today? " From Today" : ""}}</small></h3>
        <div class="pull-right">
			@can('add reservations')<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add-new-sale"><i class="fa fa-plus"></i> Add New Sale</a>@endcan
		</div>
    </div>
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->

        <table class="table table-bordered table-striped table-vcenter js-dataTable-reports">
			<thead>
				<tr>
					<th class="text-center"></th>
					<th>Description</th>
					<th class="font-w600">Type</th>
					<th class="font-w600">Reservation</th>
					<th class="font-w600">Method</th>
					<th class="font-w600">Status</th>
					<th class="font-w600">Qty</th>
					<th class="font-w600">Price (GHS)</th>
					<th class="font-w600">Total (GHS)</th>
					<th class="font-w600">Recorded</th>
					<th class="text-center" style="width: 10%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				@php
                    $count=($all_sales->perPage()*($all_sales->currentPage() -1))+1;
                @endphp

				@foreach($all_sales as $sale)
                    <tr>
                        <td class="text-center"></td>
                        <td class="hidden-xs"><span title="{{$sale->description}}">{{$sale->description}}</span></td>
                        <td class="hidden-xs">{{ucfirst($sale->expense_type)}}</td>
                        <td class="font-w600">@if($sale->reservations_id)<a href="{{route('reservations-show',$sale->reservations_id)}}">#{{$sale->reservations_id}}</a>@endif</td>
                        <td class="hidden-xs">{{ucfirst($sale->method)}}</td>
                        <td class="hidden-sm">
                            @if($sale->reservation_type == 'complementary')
                                <span class="badge badge-primary">Complementary</span>
                            @endif
                            @if($sale->status == 'confirmed')
                                @php
                                    $amtpaid = $sale->reservation->success_payments->sum('amount')/100;
                                @endphp
                                <span class="badge badge-success">Confirmed</span>
                                @if($sale->reservation_type != 'complementary')
                                    @if($amtpaid >= $sale->grand_total)
                                        <span class="badge badge-success">Fully Paid</span>
                                    @elseif(($amtpaid > 0) && ($amtpaid < $sale->grand_total))
                                        <span class="badge badge-warning">Part Paid</span>
                                    @else
                                        <span class="badge badge-danger">Not Paid</span>
                                    @endif
                                @endif
                            @elseif($sale->status == 'paid')
                                <span class="badge badge-success">Paid</span>
                            @elseif($sale->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">{{ucfirst($sale->status)}}</span>
                            @endif
                        </td>
                        <td class="hidden-xs">{{$sale->quantity}}</td>
                        <td class="font-w600">{{number_format($sale->price,2)}}</td>
                        <td class="font-w600">{{number_format($sale->total_price,2)}}</td>
                        <td class="hidden-xs">{{$sale->created_at}}</td>
                        <td class="text-center">
                            @php
                                $deleteurl = route('sale-destroy',$sale->id);
                            @endphp
                            <div class="btn-group">
                                @can('edit reservations')<div style="display: inline-block;">@if(date('Y-m-d') <= $sale->created_at) @if(!$sale->reservations_id)<a href="#" class="btn btn-sm btn-alt-primary" data-toggle="modal" data-target="#modal-edit-sale{{$sale->id}}" title="Edit Sale"> <i class="fa fa-edit"></i></a>@else <span class="mr-2">Go Directly To Reservation To Edit</span> @endif @endif</div> @endcan
                                @can('remove reservations')<div style="display: inline-block;"><button class="btn btn-sm btn-danger" type="button" data-toggle="tooltip" title="Remove Sale" onclick="confimdelete('{{$deleteurl}}')"><i class="fa fa-times"> </i></button></div>@endcan
                            </div>
                        </td>
                    </tr>
                    @can('edit reservations')
                        <div class="modal fade" id="modal-edit-sale{{$sale->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog  modal-dialog-popout">
                                <div class="modal-content">
                                    <div class="block block-themed block-transparent mb-0">
                                        <div class="block-header bg-primary-dark">
                                            <h3 class="block-title">Edit Sale Info</h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                    <i class="si si-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content block-content-narrow">

                                            <form method="post" action="{{route('sale-update',$sale->id)}}" class="form-horizontal push-10-t">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-row mb-2 col-lg-12">
                                                        <label for="material-text2">Description <small>(Max 50 characters)</small><span class="text-danger" style="display: inline-block;">*</span></label>
                                                        <input type="text" name="expense_description" class="form-control" required autocomplete="off" maxlength="50" value="{{$sale->description}}">
                                                    </div>
                                                    <div class="form-row mb-2 col-lg-6">
                                                        <label for="material-text2">Sale Type <span class="text-danger" style="display: inline-block;">*</span></label>
                                                        <select class="form-control" id="expense_type" data-placeholder="Select Sale Type.." name="expense_type" autocomplete="off">
                                                            <option>Select Sale Type</option>
                                                            <option value="food" {{$sale->expense_type == 'food' ? 'selected' : ''}}>Food</option>
                                                            <option value="drinks" {{$sale->expense_type == 'drinks' ? 'selected' : ''}}>Drinks</option>
                                                            <option value="pool" {{$sale->expense_type == 'pool' ? 'selected' : ''}}>Pool</option>
                                                            <option value="other" {{$sale->expense_type == 'other' ? 'selected' : ''}}>Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-row mb-2 col-lg-6">
                                                        <label for="material-text2">Quantity <span class="text-danger" style="display: inline-block;">*</span></label>
                                                        <input type="number" name="expense_quantity" id="expense_quantity{{$sale->id}}" class="form-control" value="{{$sale->quantity}}" required autocomplete="off">
                                                    </div>
                                                    <div class="form-row mb-2 col-lg-6">
                                                        <label for="material-text2">Price <span class="text-danger" style="display: inline-block;">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text input-group-text-alt">
                                                                    {{$current_user->company->currency}}
                                                                </span>
                                                            </div>
                                                            <input type="number" step="0.01" id="expense_price{{$sale->id}}" name="expense_price" class="form-control text-center" onkeyup="calcIndexSalePrice({{$sale->id}})" placeholder="Item Price" autocomplete="off" value="{{$sale->price}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-row mb-2 col-lg-6">
                                                        <label for="material-text2">Total Amount <span class="text-danger" style="display: inline-block;">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text input-group-text-alt">
                                                                    {{$current_user->company->currency}}
                                                                </span>
                                                            </div>
                                                            <input type="number" step="0.01" id="expense_total_price{{$sale->id}}" name="expense_total_price" class="form-control text-center" readonly placeholder="Total Amount" autocomplete="off" value="{{$sale->total_price}}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text input-group-text-alt">
                                                                    <i class="fa fa-calculator"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row mb-2 col-lg-6">
                                                        <label for="material-text2">Status <span class="text-danger" style="display: inline-block;">*</span></label>
                                                        <select class="form-control" id="expense_status" readonly style="pointer-events: none;" tabindex="-1" data-placeholder="Select Status.." name="expense_status" autocomplete="off" required>
                                                            <option>Select Status</option>
                                                            <option value="pending" {{$sale->status == 'pending' ? 'selected' : ''}}>Pending</option>
                                                            <option value="paid" {{$sale->status == 'paid' ? 'selected' : ''}} {{$sale->status == 'confirmed' && $sale->paid == 'full' ? 'selected' : ''}}>Paid</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-row mb-2 col-lg-6">
                                                        <label for="material-text2">Method <span class="text-danger" style="display: inline-block;">*</span></label>
                                                        <select name="expense_payment_type" id="expense_payment_type" class="form-control" required autocomplete="off">
                                                            <option value="">Select Payment Method</option>
                                                            <option value="paystack" {{$sale->method == 'paystack' ? 'selected' : ''}}>Paystack</option>
                                                            <option value="cash" {{$sale->method == 'cash' ? 'selected' : ''}}>Cash Payment</option>
                                                            <option value="momo" {{$sale->method == 'momo' ? 'selected' : ''}}>Mobile Money</option>
                                                            <option value="pos" {{$sale->method == 'pos' ? 'selected' : ''}}>Card POS</option>
                                                            <option value="complementary" {{$sale->method == 'complementary' ? 'selected' : ''}}>Complementary</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-row mb-2 col-lg-6">
                                                        <label for="expense_reference">Reference Number</label>
                                                        <input type="text" class="form-control" id="expense_reference" name="expense_reference" placeholder="Reference Number" autocomplete="off" value="{{$sale->sale_payment->reference ?? ''}}">
                                                    </div>
                                                    <div class="form-row mb-2 col-lg-6">
                                                        <label for="expense_vat_invoice_number">Receipt Number</label>
                                                        <input type="text" class="form-control" id="expense_vat_invoice_number" name="expense_vat_invoice_number" placeholder="Receipt/VAT Invoice Number" autocomplete="off" value="{{$sale->sale_payment->vat_invoice_number ?? ''}}">
                                                    </div>
                                                    <div class="form-row mb-2 col-lg-12">
                                                        <label for="expense_received_by">Received By</label>
                                                        <input type="text" class="form-control" id="expense_received_by" name="expense_received_by" placeholder="Payment Received By" autocomplete="off" value="{{$sale->sale_payment->received_by ?? ''}}">
                                                    </div>
                                                    <div class="form-row mb-2 col-lg-12 text-right">
                                                        <button class="btn btn-lg btn-alt-primary" type="submit">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
				@endforeach
			</tbody>
		</table>
                {{-- {{ $all_sales->links() }} --}}
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

    <script id="blockOfStuff" type="text/html">
        <div class="paginate" style="margin-left: auto;">
            {{$all_sales->onEachSide(1)->links()}}
        </div>
    </script>

    <script>jQuery(function(){One.helpers(['flatpickr']);});</script>

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
                // order: [[-2, 'desc']],
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 2 },
                    { responsivePriority: 4, targets: 4 },
                    { responsivePriority: 5, targets: 5 },
                    { responsivePriority: 6, targets: 6 },
                    { responsivePriority: 7, targets: 7 },
                    { responsivePriority: 8, targets: 8 },
                    { responsivePriority: 3, targets: -1 }
                ],
                searching: false,
                autoWidth: !1,
                buttons: [{ extend: "colvis", className: "btn btn-sm btn-alt-primary" }, { extend: "copy", className: "btn btn-sm btn-alt-primary" }, { extend: "csv", className: "btn btn-sm btn-alt-primary" }, { extend: "pdf", className: "btn btn-sm btn-alt-primary" }, { extend: "print", className: "btn btn-sm btn-alt-primary" }],
                dom: "<'row'<'col-sm-12'<'text-left py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
            });

            $('#DataTables_Table_0_info').html("Page {{$all_sales->currentPage()}} of {{$all_sales->lastPage()}}");
            $('#DataTables_Table_0_paginate').html("");
            var div = document.createElement('div');
            // div.setAttribute('class', 'someClass');
            div.innerHTML = document.getElementById('blockOfStuff').innerHTML;
            document.getElementById('DataTables_Table_0_paginate').appendChild(div);

            $(".table").addClass("compact nowrap w-100");


        $('.today-flatpickr').flatpickr({ maxDate: "today" });
        });

        function calcIndexSalePrice(index) {
            var price = $("#expense_price"+index).val();
            var quantity = $("#expense_quantity"+index).val();

            var totalprice = quantity * price;
            $('#expense_total_price'+index).val(totalprice);
        }
    </script>

@endsection
