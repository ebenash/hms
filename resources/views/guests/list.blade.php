@extends('layouts.app')

@section('content')
<h2>Guests</h2>
<div>
	<div class=""><a href="/guests/create" class="btn btn-primary pull-right">Add New Guest</a></div>
	<table class="table table-striped table-hover">
		<tr>
			<th>Guest Name</th>
			<th>Phone</th>
			<th>Email</th>
			<th>Actions</th>
		</tr>
		@foreach($guests as $guest)
			<tr>
				<td>{{$guest->first_name.' '.$guest->last_name}}</td>
				<td>{{$guest->phone}}</td>
				<td>{{$guest->email}}</td>
				<td><a href="/guests/{{$guest->id}}"  class="btn btn-info">View</a> | <a href="/guests/{{$guest->id}}/edit" class="btn btn-primary">Edit</a> | 

					<form method="post" action="/guests/{{$guest->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-danger">Delete</button></td></form>
			</tr>
		@endforeach
	</table>
</div>
@endsection