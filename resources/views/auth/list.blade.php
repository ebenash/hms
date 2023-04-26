@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="content bg-gray-lighter">
	<div class="row items-push">
		<div class="col-sm-7">
			<h1 class="page-heading">
				Users<small></small>
			</h1>
		</div>
		<div class="col-sm-5 text-right hidden-xs">
			<ol class="breadcrumb push-10-t">
				<li>Users</li>
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
			<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-user"><i class="fa fa-plus"></i> Add New User</a>
		</div>
		<br/><br/>
		<!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
		<table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
			<thead>
				<tr>
					<th class="hidden-xs">#</th>
					<th>User Name</th>
					<th class="hidden-xs">Job Title</th>
					<th class="hidden-xs">Phone Number</th>
					<th class="hidden-xs">Email</th>
					<th class="hidden-xs">User Role</th>
					<th class="text-center" style="width: 10%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				@php $count=1; @endphp
				@foreach($all_users as $user)
				<tr>
					<td class="text-center">{{$count++}}</td>
					<td class="font-w600">{{$user->name}}</td>
					<td class="hidden-xs">{{$user->title}}</td>
					<td class="hidden-xs">{{$user->phone}}</td>
					<td class="hidden-xs">{{$user->email}}</td>
					<td class="hidden-xs">{{$user->role->role_name}}</td>
					<td class="text-center">
						<div class="btn-group">
							<div style="display: inline-block;"><a href="/users/{{$user->id}}" class="btn btn-xs btn-primary" data-toggle="tooltip" title="View User"> <i class="fa fa-eye"> </i></a></div>
							<div style="display: inline-block;"><form method="post" action="/users/{{$user->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-xs btn-danger" type="submit" data-toggle="tooltip" title="Remove User"><i class="fa fa-times"> </i></button></form></div>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<!-- END Dynamic Table Full Pagination -->
@endsection
