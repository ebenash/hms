@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="content bg-gray-lighter">
	<div class="row items-push">
		<div class="col-sm-7">
			<h1 class="page-heading">
				Reporting<small></small>
			</h1>
		</div>
		<div class="col-sm-5 text-right hidden-xs">
			<ol class="breadcrumb push-10-t">
				<li>Accounting</li>
				<li><a class="link-effect" href="">Reporting</a></li>
			</ol>
		</div>
	</div>
</div>
<!-- END Page Header -->

<div class="block">
	<div class="block-header">
		<h3 class="block-title">REPORT FILTER</h3>
	</div>
	<div class="block-content">
		<div class="row items-push">
			<form method="post" action="/reports/filter" class="form-horizontal push-10-t">
			{{ csrf_field() }}
			@if(isset($filter))
			<div class="col-xs-6 col-sm-3">
				<div class="form-material">
					<select class="js-select2 form-control" id="report_type" style="width: 100%;" data-placeholder="Select Report Type.."  name="report_type">
						<option></option>
						<option value="1" @if($filter['report_type'] == '1') selected="selected" @endif>Guests</option>
						<option value="2" @if($filter['report_type'] == '2') selected="selected" @endif>Reservations</option>
						<option value="3" @if($filter['report_type'] == '3') selected="selected" @endif>Rooms</option>
						<option value="4" @if($filter['report_type'] == '4') selected="selected" @endif>Sales and Revenue</option>
					</select>
					<label for="material-text2">Report Type <p class="text-danger" style="display: inline-block;">*</p></label>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="js-datepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="false">
					<input class="js-datepicker form-control" type="text" id="start_date" name="start_date" placeholder="Choose check-out date.." value="{{$filter['start_date']}}">
					<label for="material-text2">Date From</label>
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="js-datepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="false">
					<input class="js-datepicker form-control" type="text" id="end_date" name="end_date" placeholder="Choose check-out date.." value="{{$filter['end_date']}}">
					<label for="material-text2">Date To</label>
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<button class="btn btn-minw btn-square btn-success" type="submit">Filter</button>
			</div>
			@else
			<div class="col-xs-6 col-sm-3">
				<div class="form-material">
					<select class="js-select2 form-control" id="report_type" style="width: 100%;" data-placeholder="Select Report Type.."  name="report_type">
						<option></option>
						<option value="1">Guests</option>
						<option value="2">Reservations</option>
						<option value="3">Rooms</option>
						<option value="4">Sales and Revenue</option>
					</select>
					<label for="material-text2">Report Type <p class="text-danger" style="display: inline-block;">*</p></label>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="js-datepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="false">
					<input class="js-datepicker form-control" type="text" id="start_date" name="start_date" placeholder="Choose check-out date..">
					<label for="material-text2">Date From</label>
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="js-datepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="false">
					<input class="js-datepicker form-control" type="text" id="end_date" name="end_date" placeholder="Choose check-out date..">
					<label for="material-text2">Date To</label>
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<button class="btn btn-minw btn-square btn-success" type="submit">Filter</button>
			</div>
			@endif
			</form>
		</div>
	</div>
</div>

<!-- Dynamic Table Full Pagination -->
<div class="block">

	<div class="block-content">
		@if(isset($filter))
		<div class="pull-right">

			<div style="display: inline-block;"><form method="post" action="/reports/exportpdf" target="_blank">{{ csrf_field() }} <input type="hidden" name="report_type" value="{{$filter['report_type']}}"/><input type="hidden" name="start_date" value="{{$filter['start_date']}}"/><input type="hidden" name="end_date" value="{{$filter['end_date']}}"/><button type="submit" data-toggle="tooltip" title="Export Data to PDF" class="btn btn-sm btn-danger"><i class="fa fa-file-pdf-o"></i> Export PDF </i></button></form></div>
			<div style="display: inline-block;"><form method="post" action="/reports/exportexcel" target="_blank">{{ csrf_field() }} <input type="hidden" name="report_type" value="{{$filter['report_type']}}"/><input type="hidden" name="start_date" value="{{$filter['start_date']}}"/><input type="hidden" name="end_date" value="{{$filter['end_date']}}"/><button type="submit" data-toggle="tooltip" title="Export Data to Excel" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o"></i> Export Excel </i></button></form></div>

		</div>
		<br/><br/>
		<!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
		<table class="table table-bordered table-hover table-striped" width="100%" style="font-size: 7pt !important; border-collapse: collapse; word-wrap: break-word; padding: 7px;">
			@if($filter['report_type'] == 1)

			<thead>
				<tr>
					<td class="font-w600">#</td>
					<td class="font-w600">Name</td>
					<td class="font-w600">Phone</td>
					<td class="font-w600">Email</td>
					<td class="font-w600">City</td>
					<td class="font-w600">Country</td>
					<td class="font-w600">Date Registered</td>
					<td class="font-w600">Recorded By</td>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($filter['data'] as $guest)
				<tr>
					<td class="text-center">{{$count++}}</td>
					<td class="hidden-xs">{{$guest->full_name}}</td>
					<td class="hidden-xs">{{$guest->phone}}</td>
					<td class="hidden-xs">{{$guest->email}}</td>
					<td class="hidden-xs">{{$guest->city}}</td>
					<td class="hidden-xs">{{$guest->country}}</td>
					<td class="hidden-xs">{{date_format(new DateTime($guest->created_at), 'jS F, Y')}}</td>
					<td class="hidden-xs">{{$guest->user['name']}}</td>
				</tr>
				@endforeach
			</tbody>
			@elseif($filter['report_type'] == 2)
			<thead>
				<tr>
					<td class="font-w600">#</td>
					<td class="font-w600">Name</td>
					<td class="font-w600">Phone</td>
					<td class="font-w600">Email</td>
					<td class="font-w600">Room</td>
					<td class="font-w600">Type</td>
					<td class="font-w600">Arrival</td>
					<td class="font-w600">Departure</td>
					<td class="font-w600">Adults</td>
					<td class="font-w600">Children</td>
					<td class="font-w600">Status</td>
					<td class="font-w600">Discount %</td>
					<td class="font-w600">Date Recorded</td>
					<td class="font-w600">Recorded By</td>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($filter['data'] as $reservation)
				<tr>
					<td class="text-center">{{$count++}}</td>
					<td class="hidden-xs">{{$reservation->guest->first_name.' '.$reservation->guest->last_name}}</td>
					<td class="hidden-xs">{{$reservation->guest->phone}}</td>
					<td class="hidden-xs">{{$reservation->guest->email}}</td>
					<td class="hidden-xs">{{$reservation->room->name}}</td>
					<td class="hidden-xs">{{$reservation->room->roomtype->name}}</td>
					<td class="hidden-xs">{{date_format(new DateTime($reservation->check_in), 'l jS F, Y')}}</td>
					<td class="hidden-xs">{{date_format(new DateTime($reservation->check_out), 'l jS F Y')}}</td>
					<td class="hidden-xs">{{$reservation->adults}}</td>
					<td class="hidden-xs">{{$reservation->children}}</td>
					<td class="hidden-xs">@if($reservation->reservation_status == 1) <span class="label label-success">Confirmed</span>  @elseif($reservation->reservation_status == 0) <span class="label label-warning">Pending</span> @else <span class="label label-danger">Cancelled</span> @endif</td>
					<td class="hidden-xs">{{$reservation->discount}}</td>
					<td class="hidden-xs">{{date_format(new DateTime($reservation->created_at), 'jS F, Y')}}</td>
					<td class="hidden-xs">{{$reservation->user['name']}}</td>
				</tr>
				@endforeach
			</tbody>
			@elseif($filter['report_type'] == 3)
			<thead>
				<tr>
					<td class="font-w600">#</td>
					<td class="font-w600">Room Name</td>
					<td class="font-w600">Room Type</td>
					<td class="font-w600">Price</td>
					<td class="font-w600">Max Occupancy</td>
					<td class="font-w600">Room Status</td>
					<td class="font-w600">Date Recorded</td>
					<td class="font-w600">Recorded By</td>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($filter['data'] as $room)
				<tr>
					<td class="text-center">{{$count++}}</td>
					<td class="hidden-xs">{{$room->name}}</td>
					<td class="hidden-xs">{{$room->roomtype->name}}</td>
					<td class="hidden-xs">{{$room->price}}</td>
					<td class="hidden-xs">{{$room->max_persons}}</td>
					<td class="hidden-xs">@if($room->status == 0) <span class="label label-success">Available</span>  @else <span class="label label-danger">Inactive</span> @endif</td>
					<td class="hidden-xs">{{date_format(new DateTime($room->created_at), 'jS F, Y')}}</td>
					<td class="hidden-xs">{{$room->user['name']}}</td>
				</tr>
				@endforeach
			</tbody>
			@elseif($filter['report_type'] == 4)
			<thead>
				<tr>
					<td class="font-w600">#</td>
					<td class="font-w600">Name</td>
					<td class="font-w600">Room</td>
					<td class="font-w600">Type</td>
					<td class="font-w600">Arrival</td>
					<td class="font-w600">Departure</td>
					<td class="font-w600">Status</td>
					<td class="font-w600">Number of Days</td>
					<td class="font-w600">Room Price</td>
					<td class="font-w600">Discount %</td>
					<td class="font-w600">Total Amount</td>
					<td class="font-w600">Date Recorded</td>
					<td class="font-w600">Recorded By</td>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($filter['data'] as $reservation)
				<tr>
					<td class="text-center">{{$count++}}</td>
					<td class="hidden-xs">{{$reservation->guest->first_name.' '.$reservation->guest->last_name}}</td>
					<td class="hidden-xs">{{$reservation->room->name}}</td>
					<td class="hidden-xs">{{$reservation->room->roomtype->name}}</td>
					<td class="hidden-xs">{{date_format(new DateTime($reservation->check_in), 'jS F, Y')}}</td>
					<td class="hidden-xs">{{date_format(new DateTime($reservation->check_out), 'jS F, Y')}}</td>
					<td class="hidden-xs">@if($reservation->reservation_status == 1) <span class="label label-success">Confirmed</span>  @elseif($reservation->reservation_status == 0) <span class="label label-warning">Pending</span> @else <span class="label label-danger">Cancelled</span> @endif</td>
					<td class="hidden-xs">{{date_diff(date_create($reservation->check_in),date_create($reservation->check_out))->format("%a")}} days</td>
					<td class="hidden-xs">{{number_format($reservation->room->price,2)}}</td>
					<td class="hidden-xs">{{$reservation->discount}}</td>
					<td class="hidden-xs">{{number_format($reservation->price,2)}}</td>
					<td class="hidden-xs">{{date_format(new DateTime($reservation->created_at), 'jS F, Y')}}</td>
					<td class="hidden-xs">{{$reservation->user['name']}}</td>
				</tr>
				@endforeach
			</tbody>
			@endif
		</table>
		@else
			<div align="center">Please Specify Filter Values</div>
			<br>
		@endif
	</div>
</div>
<!-- END Dynamic Table Full Pagination -->
@endsection
