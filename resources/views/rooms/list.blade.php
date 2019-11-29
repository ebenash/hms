@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="content bg-gray-lighter">
	<div class="row items-push">
		<div class="col-sm-7">
			<h1 class="page-heading">
				Rooms<small></small>
			</h1>
		</div>
		<div class="col-sm-5 text-right hidden-xs">
			<ol class="breadcrumb push-10-t">
				<li>Rooms</li>
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
			<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-room"><i class="fa fa-plus"></i> Add New Room</a>
			<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-roomtypes"><i class="fa fa-list"></i> Room Types</a>
		</div>
		<br/><br/>
		<!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
		<table class="table table-bordered table-hover table-striped js-dataTable-full-pagination">
			<thead>
				<tr>
					<th class="text-center"></th>
					<th>Room Name</th>
					<th class="hidden-xs">Room Type</th>
					<th class="hidden-xs">Room Status</th>
					<th class="text-center" style="width: 10%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($all_rooms as $room)
				<tr>
					<td class="text-center">{{$count++}}</td>
					<td class="font-w600">{{$room->name}}</td>
					<td class="hidden-xs">{{$room->roomtype->name}}</td>
					<td class="hidden-xs">@if($room->status == 0) <span class="label label-success">Available</span>  @else <span class="label label-danger">Inactive</span> @endif</td>
					<td class="text-center">
						<div class="btn-group">
							<div style="display: inline-block;"><a href="#" class="btn btn-xs btn-primary"  data-toggle="modal" data-target="#modal-view{{$room->id}}" title="View Room"> <i class="fa fa-eye"> </i></a></div>
							<div style="display: inline-block;"><a href="/rooms/{{$room->id}}/edit" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit Room"> <i class="fa fa-pencil"></i> </a></div>
							<div style="display: inline-block;"><form method="post" action="/rooms/{{$room->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-xs btn-danger" type="submit" data-toggle="tooltip" title="Remove Room"><i class="fa fa-times"> </i></button></form></div>
						</div>
					</td>
				</tr>
			<div class="modal fade" id="modal-view{{$room->id}}" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog  modal-dialog-popout">
						<div class="modal-content">
							<div class="block block-themed block-transparent remove-margin-b">
								<div class="block-header bg-primary-dark">
									<ul class="block-options">
										<li>
											<button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
										</li>
									</ul>
									<h3 class="block-title">Room Info</h3>
								</div>
								<div class="block-content">
									<div>
										<div class="form-group">
											<div class="">Room Name: <b>{{$room->name}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Price Set: <b>{{$room->price}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Max Persons: <b>{{$room->max_persons}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Room Type: <b>{{$room->roomtype->name}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Status: <b> @if($room->status == 0) <span class="label label-success">Available</span>  @else <span class="label label-danger">Inactive</span> @endif </b></div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
								<button class="btn btn-sm btn-primary" type="button" data-dismiss="modal"><i class="fa fa-calendar-check-o"></i> Make Reservation</button>
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