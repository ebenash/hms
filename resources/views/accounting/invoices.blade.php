@extends('layouts.app')

@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        Paystack Invoices
    </h1>
@endsection

@section('content')

<!-- Dynamic Table Full -->
<div class="block block-rounded">
    <div class="block-header">
        <h3 class="block-title">Paystack <small>Invoices</small></h3>
    </div>
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->

        <table class="table table-bordered table-striped table-vcenter js-dataTable-report">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Customer</th>
					<th class="font-w600">Reservation</th>
					<th class="font-w600">Invoice ID</th>
					<th class="font-w600">Amount</th>
					<th class="font-w600">Request Code</th>
					<th class="font-w600">Status</th>
					<th class="font-w600">Paid At</th>
					<th class="text-center" style="width: 10%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				@php
                    $count=($all_invoices->perPage()*($all_invoices->currentPage() -1))+1;
                @endphp
				@foreach($all_invoices as $invoice)
                    <tr>
                        <td class="text-center">{{$count++}}</td>
                        <td class="hidden-xs">{{$invoice->guest->full_name}}</td>
                        <td class="font-w600">@if($invoice->reservation_id)<a href="{{route('reservations-show',$invoice->reservation_id)}}">#{{$invoice->reservation_id}}</a>@endif</td>
                        <td class="hidden-xs">{{$invoice->invoice_id}} ({{$invoice->invoice_number}})</td>
                        <td class="font-w600">{{$invoice->currency.' '.number_format($invoice->amount/100,2)}}</td>
                        <td class="hidden-xs">{{$invoice->request_code}}</td>
                        <td class="hidden-xs"><span class="badge badge-{{$invoice->status == 'success' ? 'success':'warning'}}">{{$invoice->status == 'success' ? 'Success':'Pending'}}</span><span class="badge badge-{{$invoice->paid ? 'success':'danger'}}">{{$invoice->paid ? 'Paid':'Unpaid'}}</span></td>
                        <td class="hidden-xs">{{$invoice->paid_at}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                @can('view invoices')<div style="display: inline-block;"><a href="#" class="btn btn-sm btn-alt-primary" data-toggle="modal" data-target="#modal-view{{$invoice->id}}" title="View Paystack Invoice"> <i class="fa fa-eye"></i></a></div> @endcan
                            </div>
                        </td>
                    </tr>
                    @can('view invoices')
                        <div class="modal fade" id="modal-view{{$invoice->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog  modal-dialog-popout">
                                <div class="modal-content">
                                    <div class="block block-themed block-transparent mb-0">
                                        <div class="block-header bg-primary-dark">
                                            <h3 class="block-title">Paystack Invoice Info</h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                    <i class="si si-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content block-content-narrow">

                                            <div>
                                                <div class="form-group">
                                                    <div class="">Full Name: <b>{{$invoice->full_name}}</b></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="">Email: <b>{{$invoice->email}}</b></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="">Phone: <b>{{$invoice->phone}}</b></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="">City: <b>{{$invoice->city}}</b></div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="">Country: <b>{{$invoice->country}}</b></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-lg btn-alt-primary" type="button" data-dismiss="modal">Close</button>
                                            @can('add reservations')<a href="{{route('reservations-create-invoice',$invoice->id)}}" class="btn btn-lg btn-primary"><i class="fa fa-address-book"></i> Make Reservation</a>@endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
				@endforeach
			</tbody>
		</table>
                {{-- {{ $all_invoices->links() }} --}}
    </div>
</div>
<!-- END Dynamic Table Full -->

@endsection

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
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

    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/tables_datatables.js') }}"></script>

    <script id="blockOfStuff" type="text/html">
        <div class="paginate" style="margin-left: auto;">
            {{$all_invoices->onEachSide(1)->links()}}
        </div>
    </script>

    <script type="text/javascript">
        $(function () {
            $('#DataTables_Table_0_info').html("Page {{$all_invoices->currentPage()}} of {{$all_invoices->lastPage()}}");
            $('#DataTables_Table_0_paginate').html("");
            var div = document.createElement('div');
            // div.setAttribute('class', 'someClass');
            div.innerHTML = document.getElementById('blockOfStuff').innerHTML;
            document.getElementById('DataTables_Table_0_paginate').appendChild(div);

            $(".table").addClass("compact nowrap w-100");
        });
    </script>

@endsection
