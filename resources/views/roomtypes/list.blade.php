@extends('layouts.app')

@section('content')
<div class="block-content block-content-narrow">
	<div class="pull-right">
		<a href="#" class="btn btn-sm btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#modal-view-add-roomtype"><i class="fa fa-plus"></i> Add New Room Type</a>
	</div>
	<br/><br/>
	<table class="table table-striped table-borderless">
		<thead>
			<tr>
				<th class="hidden-xs">Room Type</th>
				<th class="text-center" style="width: 10%;">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php $count=1; ?>
			@foreach($all_roomtypes as $roomtype)
			<tr>
				<td class="font-w600">{{$roomtype->name}}</td>
				<td class="text-center">
					<div class="btn-group">
						<div style="display: inline-block;"><a href="#" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-view-edit{{$roomtype->id}}" title="Edit Room Type"> <i class="fa fa-pencil"></i></a></div>
						<div style="display: inline-block;"><form method="post" action="/roomtypes/{{$roomtype->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-xs btn-danger" type="submit" data-toggle="tooltip" title="Remove Room"><i class="fa fa-times"></i></button></form></div>
					</div>
				</td>
			</tr>
		<div class="modal fade" id="modal-view-edit{{$roomtype->id}}" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog  modal-dialog-popout">
					<div class="modal-content">
						<div class="block block-themed block-transparent remove-margin-b">
							<div class="block-header bg-primary-dark">
								<ul class="block-options">
									<li>
										<button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
									</li>
								</ul>
								<h3 class="block-title">Room Type Edit</h3>
							</div>
							<form method="post" action="/roomtypes/{{$roomtype->id}}" class="form-horizontal push-10-t">
								{{ csrf_field() }}
								{{ method_field('PUT')}}
								<div class="block-content">
									<div class="form-group">
										<div class="col-sm-12">
											<div class="form-material floating">
												<input type="text" class="form-control" value="{{$roomtype->name}}" name="name">
												<label for="material-text2">Room Type Name</label>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12 pull-right">
											<button class="btn btn-sm btn-primary" type="submit">Submit</button>
										</div>
									</div>
								</div>
							</form>
							<br/><br/><br/><br/>
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
@endsection