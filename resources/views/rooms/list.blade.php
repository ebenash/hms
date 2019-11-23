@extends('layouts.app')

@section('content')
<h2>Room</h2>
<div>
	<div class=""><a href="/rooms/create" class="btn btn-primary pull-right">Add New Room</a></div>
	<table class="table table-striped table-hover">
		<tr>
			<th>Room</th>
			<th>Actions</th>
		</tr>
		@foreach($rooms as $room)
			<tr>
				<td>{{$room->name}}</td>
				<td><a href="/rooms/{{$room->id}}"  class="btn btn-info">View</a> | <a href="/rooms/{{$room->id}}/edit" class="btn btn-primary">Edit</a> | 

					<form method="post" action="/rooms/{{$room->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-danger">Delete</button></td></form>
			</tr>
		@endforeach
	</table>
</div>
@endsection