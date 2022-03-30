<!DOCTYPE html>
<html>
<head>
	<style>
		body {font-family: sans-serif;
		font-size: 10pt;
		}
		p {	margin: 0pt; }
		table, td, th {
		border: 1px solid #ddd;
		text-align: left;
		}

		table {
		border-collapse: collapse;
		max-width: 2480px;
    	width:100%;
		}

		thead {
		background-color: #EEEEEE
		}

		th, td {
		padding: 5px;
		width: auto;
		overflow: hidden;
		word-wrap: break-word;
		font-size: 7pt;
		}
		header { position: fixed; top: -60px; left: 0px; right: 0px;  height: 50px;}
    	footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px;}
	</style>
</head>
  <body>

	<footer>
		<div style="font-size: 6pt; text-align: left; padding-top: 3mm; ">
			<p>Report for: {{$current_user->company->name}} Email: {{$current_user->company->email}} Generated by: {{$current_user->name}} on {{date("F j, Y")}} </p>
			<p align="right">powered by >ash_</p>
		</div>
	</footer>
	<div>
		@if(isset($filter))
		@if($filter['report_type'] == 1)
		<h2>Guests Report Export</h2>
		@elseif($filter['report_type'] == 2)
		<h2>Reservations Report Export</h2>
		@elseif($filter['report_type'] == 3)
		<h2>Rooms Report Export</h2>
		@elseif($filter['report_type'] == 4)
		<h2>Sales and Revenue Report Export</h2>
		@endif
		<p>Please find exported data below.</p>
		<br/><br/>
		<!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
		<table class="items" width="100%" cellspacing="0" cellpadding="0">
			@if($filter['report_type'] == 1)
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Phone</th>
					<th>Email</th>
					<th>City</th>
					<th>Country</th>
					<th>Date Registered</th>
					<th>Recorded By</th>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($filter['data'] as $guest)
				<tr>
					<td>{{$count++}}</td>
					<td>{{$guest->full_name}}</td>
					<td>{{$guest->phone}}</td>
					<td>{{$guest->email}}</td>
					<td>{{$guest->city}}</td>
					<td>{{$guest->country}}</td>
					<td>{{date_format(new DateTime($guest->created_at), 'jS F, Y')}}</td>
					<td>{{$guest->user['name']}}</td>
				</tr>
				@endforeach
			</tbody>
			@elseif($filter['report_type'] == 2)
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Room</th>
					<th>Type</th>
					<th>Arrival</th>
					<th>Departure</th>
					<th>Adults</th>
					<th>Children</th>
					<th>Status</th>
					<th>Discount</th>
					<th>Date Recorded</th>
					<th>Recorded By</th>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($filter['data'] as $reservation)
				<tr>
					<td>{{$count++}}</td>
					<td>{{$reservation->guest->first_name.' '.$reservation->guest->last_name}}</td>
					<td>{{$reservation->guest->phone}}</td>
					<td>{{$reservation->guest->email}}</td>
					<td>{{$reservation->room->name}}</td>
					<td>{{$reservation->room->roomtype->name}}</td>
					<td>{{date_format(new DateTime($reservation->check_in), 'jS F, Y')}}</td>
					<td>{{date_format(new DateTime($reservation->check_out), 'jS F, Y')}}</td>
					<td>{{$reservation->adults}}</td>
					<td>{{$reservation->children}}</td>
					<td>@if($reservation->reservation_status == 1) <span class="label label-success">Confirmed</span>  @elseif($reservation->reservation_status == 0) <span class="label label-warning">Pending</span> @else <span class="label label-danger">Cancelled</span> @endif</td>
					<td>{{$reservation->discount}} %</td>
					<td>{{date_format(new DateTime($reservation->created_at), 'jS F, Y')}}</td>
					<td>{{$reservation->user['name']}}</td>
				</tr>
				@endforeach
			</tbody>
			@elseif($filter['report_type'] == 3)
			<thead>
				<tr>
					<th>#</th>
					<th>Room Name</th>
					<th>Room Type</th>
					<th>Price</th>
					<th>Max Occupancy</th>
					<th>Room Status</th>
					<th>Date Recorded</th>
					<th>Recorded By</th>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($filter['data'] as $room)
				<tr>
					<td>{{$count++}}</td>
					<td>{{$room->name}}</td>
					<td>{{$room->roomtype->name}}</td>
					<td>{{$room->price}}</td>
					<td>{{$room->max_persons}}</td>
					<td>@if($room->status == 0) <span class="label label-success">Available</span>  @else <span class="label label-danger">Inactive</span> @endif</td>
					<td>{{date_format(new DateTime($room->created_at), 'jS F, Y')}}</td>
					<td>{{$room->user['name']}}</td>
				</tr>
				@endforeach
			</tbody>
			@elseif($filter['report_type'] == 4)
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Room</th>
					<th>Type</th>
					<th>Arrival</th>
					<th>Departure</th>
					<th>Status</th>
					<th>Number of Days</th>
					<th>Room Price</th>
					<th>Discount</th>
					<th>Total Amount</th>
					<th>Date Recorded</th>
					<th>Recorded By</th>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($filter['data'] as $reservation)
				<tr>
					<td>{{$count++}}</td>
					<td>{{$reservation->guest->first_name.' '.$reservation->guest->last_name}}</td>
					<td>{{$reservation->room->name}}</td>
					<td>{{$reservation->room->roomtype->name}}</td>
					<td>{{date_format(new DateTime($reservation->check_in), 'jS F, Y')}}</td>
					<td>{{date_format(new DateTime($reservation->check_out), 'jS F, Y')}}</td>
					<td>@if($reservation->reservation_status == 1) <span class="label label-success">Confirmed</span>  @elseif($reservation->reservation_status == 0) <span class="label label-warning">Pending</span> @else <span class="label label-danger">Cancelled</span> @endif</td>
					<td>{{date_diff(date_create($reservation->check_in),date_create($reservation->check_out))->format("%a")}} days</td>
					<td>{{number_format($reservation->room->price,2)}}</td>
					<td>{{$reservation->discount}} %</td>
					<td>{{number_format($reservation->price,2)}}</td>
					<td>{{date_format(new DateTime($reservation->created_at), 'jS F, Y')}}</td>
					<td>{{$reservation->user['name']}}</td>
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

	</body>
</html>
