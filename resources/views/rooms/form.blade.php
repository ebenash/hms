@extends('layouts.app')

@section('content')
<h2>
	@if(isset($create))
		Add New Room
	@else
		Edit Room
	@endif
</h2>

<div>
	@if(isset($create))
		<form method="post" action="/rooms/store">
	@else
		<form method="post" action="/rooms/{{$room->id}}">
		{{ method_field('PUT')}}
	@endif
		{{ csrf_field() }}
		<div class="form-group">
			<div class="">Room Name</div>
		@if(isset($create))
			<input type="text" name="name" class="form-control">
		@else
			<input type="text" name="name" class="form-control" value="{{$room->name}}">
		@endif
		</div>
		<div class="form-group">
			<div class="">Price</div>
		@if(isset($create))
			<input type="text" name="price" class="form-control">
		@else
			<input type="text" name="price" class="form-control" value="{{$room->price}}">
		@endif
		</div>
		<div class="form-group">
			<div class="">Room Type</div>
		@if(isset($create))
			@foreach($room->roomtype() as $roomtype)
			<input type="text" name="type" class="form-control">
			@endforeach
		@else
			@foreach($room->roomtype() as $roomtype)
			<input type="text" name="type" class="form-control" value="{{$room->type}}">
			@endforeach
		@endif
		</div>
		<div class="form-group">
			<div class="">Max Persons</div>
		@if(isset($create))
			<input type="text" name="max_persons" class="form-control">
		@else
			<input type="text" name="max_persons" class="form-control" value="{{$room->max_persons}}">
		@endif
		</div>
		
		<input type="submit" name="submit" value="Submit">
	</form>
</div>
@endsection