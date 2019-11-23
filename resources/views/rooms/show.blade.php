@extends('layouts.app')

@section('content')
<h2>Room Information</h2>
<div><a href="/rooms" class="btn btn-primary">Go Back</a></div>
<br>
<div>
	<div class="form-group">
		<div class="">Room Name: <b>{{$room->name}}</b></div>
	</div>
	<div class="form-group">
		<div class="">Price: <b>{{$room->price}}</b></div>
	</div>
	<div class="form-group">
		<div class="">Room Type: <b>{{$room->type}}</b></div>
	</div>
	<div class="form-group">
		<div class="">Max Persons: <b>{{$room->max_persons}}</b></div>
	</div>
</div>
@endsection