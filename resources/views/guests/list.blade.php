@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="content bg-gray-lighter">
	<div class="row items-push">
		<div class="col-sm-7">
			<h1 class="page-heading">
				Guests<small></small>
			</h1>
		</div>
		<div class="col-sm-5 text-right hidden-xs">
			<ol class="breadcrumb push-10-t">
				<li>Guests</li>
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
			<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-guest"><i class="fa fa-plus"></i> Add New Guest</a>
		</div>
		<br/><br/>
		<!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
		<table class="table table-bordered table-hover table-striped js-dataTable-full-pagination">
			<thead>
				<tr>
					<th class="text-center"></th>
					<th>Name</th>
					<th class="hidden-xs">Email</th>
					<th class="hidden-xs">Phone</th>
					<th class="text-center" style="width: 10%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($all_guests as $guest)
				<tr>
					<td class="text-center">{{$count++}}</td>
					<td class="font-w600">{{$guest->first_name.' '.$guest->last_name}}</td>
					<td class="hidden-xs">{{$guest->email}}</td>
					<td class="hidden-xs">{{$guest->phone}}</td>
					<td class="text-center">
						<div class="btn-group">
							<div style="display: inline-block;"><a href="#" class="btn btn-xs btn-primary"  data-toggle="modal" data-target="#modal-view{{$guest->id}}" title="View Guest"> <i class="fa fa-eye"></i></a></div>
							<div style="display: inline-block;"><a href="/guests/{{$guest->id}}/edit" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit Guest"> <i class="fa fa-pencil"></i></a></div>
							<div style="display: inline-block;"><form method="post" action="/guests/{{$guest->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-xs btn-danger" type="button" data-toggle="tooltip" title="Remove Client"><i class="fa fa-times"></i></button></form></div>
						</div>
					</td>
				</tr>
			<div class="modal fade" id="modal-view{{$guest->id}}" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog  modal-dialog-popout">
						<div class="modal-content">
							<div class="block block-themed block-transparent remove-margin-b">
								<div class="block-header bg-primary-dark">
									<ul class="block-options">
										<li>
											<button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
										</li>
									</ul>
									<h3 class="block-title">Guest Info</h3>
								</div>
								<div class="block-content">
									<div>
										<div class="form-group">
											<div class="">First Name: <b>{{$guest->first_name}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Last Name: <b>{{$guest->last_name}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Email: <b>{{$guest->email}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Phone: <b>{{$guest->phone}}</b></div>
										</div>
										<div class="form-group">
											<div class="">City: <b>{{$guest->city}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Country: <b>{{$guest->country}}</b></div>
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