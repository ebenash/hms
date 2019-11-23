@extends('layouts.app')

@section('content')
<h2>Room Type Information</h2>
<div><a href="/roomtypes" class="btn btn-primary">Go Back</a></div>
<br>
<div>
	<div class="form-group">
		<div class="">Room Type Name: <b>{{$roomtype->name}}</b></div>
	</div>
</div>
@endsection