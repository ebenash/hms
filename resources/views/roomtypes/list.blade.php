@extends('layouts.app')

@section('content')
<h2>Room Types</h2>
<div>
	<div class=""><a href="/roomtypes/create" class="btn btn-primary pull-right">Add New Room Type</a></div>
	<table class="table table-striped table-hover">
		<tr>
			<th>Room Type</th>
			<th>Actions</th>
		</tr>
		@foreach($roomtypes as $roomtype)
			<tr>
				<td>{{$roomtype->name}}</td>
				<td><a href="/roomtypes/{{$roomtype->id}}"  class="btn btn-info">View</a> | <a href="/roomtypes/{{$roomtype->id}}/edit" class="btn btn-primary">Edit</a> | 

					<form method="post" action="/roomtypes/{{$roomtype->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-danger">Delete</button></td></form>
			</tr>
		@endforeach
	</table>
</div>
@endsection