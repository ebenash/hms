@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="content bg-gray-lighter">
	<div class="row items-push">
		<div class="col-sm-7">
			<h1 class="page-heading">
				Reservations<small></small>
			</h1>
		</div>
		<div class="col-sm-5 text-right hidden-xs">
			<ol class="breadcrumb push-10-t">
				<li>Reservations</li>
				<li><a class="link-effect" href="">List</a></li>
			</ol>
		</div>
	</div>
</div>
<!-- END Page Header -->

<!-- Dynamic Table Full Pagination -->
<div class="block">
	
	<div class="block-content">
		<div class="pull-right">
			<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-reservation"><i class="fa fa-plus"></i> Add New Reservation</a>
		</div>
		<br/><br/>
		<!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
		<table class="table table-bordered table-hover table-striped js-dataTable-full-pagination">
			<thead>
				<tr>
					<th class="text-center"></th>
					<th>Guest Name</th>
					<th class="hidden-xs">Reserved Room</th>
					<th class="hidden-xs">Reservation Status</th>
					<th class="text-center" style="width: 10%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($all_reservations as $reservation)
				<tr>
					<td class="text-center">{{$count++}}</td>
					<td class="font-w600">{{$reservation->guest->first_name.' '.$reservation->guest->last_name}}</td>
					<td class="hidden-xs">{{$reservation->room->name}}</td>
					<td class="hidden-xs">@if($reservation->reservation_status == 1) <span class="label label-success">Confirmed</span>  @elseif($reservation->reservation_status == 0) <span class="label label-warning">Pending</span> @else <span class="label label-danger">Cancelled</span> @endif</td>
					<td class="text-center">
						<div class="btn-group">
							<div style="display: inline-block;"><a href="#" class="btn btn-xs btn-primary"  data-toggle="modal" data-target="#modal-view{{$reservation->id}}" title="View Reservation"> <i class="fa fa-eye"> </i></a></div>
							<div style="display: inline-block;"><a href="/reservations/{{$reservation->id}}/edit" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit Reservation"> <i class="fa fa-pencil"></i> </a></div>
							<div style="display: inline-block;"><a href="/reservations/calendar/{{$reservation->id}}" class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit Reservation"> <i class="fa fa-calendar"></i> </a></div>
							<div style="display: inline-block;"><form method="post" action="/reservations/{{$reservation->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-xs btn-danger" type="submit" data-toggle="tooltip" title="Remove Reservation"><i class="fa fa-times"> </i></button></form></div>
						</div>
					</td>
				</tr>
			<div class="modal fade" id="modal-view{{$reservation->id}}" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog  modal-dialog-popout">
						<div class="modal-content">
							<div class="block block-themed block-transparent remove-margin-b">
								<div class="block-header bg-primary-dark">
									<ul class="block-options">
										<li>
											<button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
										</li>
									</ul>
									<h3 class="block-title">Reservation Info</h3>
								</div>
								<div class="block-content">
									<div>
										<div class="form-group">
											<div class="">Guest Name: <b>{{$reservation->guest->first_name.' '.$reservation->guest->last_name}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Reservation Room: <b>{{$reservation->room->name}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Check In Date: <b>{{$reservation->check_in}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Check Out Date: <b>{{$reservation->check_out}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Adults: <b>{{$reservation->adults}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Children: <b>{{$reservation->children}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Reservation Status: <b> @if($reservation->reservation_status == 1) <span class="label label-success">Confirmed</span>  @elseif($reservation->reservation_status == 0) <span class="label label-warning">Pending</span> @else <span class="label label-danger">Cancelled</span> @endif </b></div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<!-- END Dynamic Table Full Pagination -->
@endsection