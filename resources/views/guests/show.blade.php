@extends('layouts.app')

@section('content')
<h2>Guest Information</h2>
<div><a href="/guests" class="btn btn-primary">Go Back</a></div>
<br>
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
@endsection