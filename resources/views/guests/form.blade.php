@extends('layouts.app')

@section('content')
<h2>
	@if(isset($create))
		Add New Guest
	@else
		Edit Guest
	@endif
</h2>

<div>
	@if(isset($create))
		<form method="post" action="/guests/store">
	@else
		<form method="post" action="/guests/{{$guest->id}}">
		{{ method_field('PUT')}}
	@endif
		{{ csrf_field() }}
		<div class="form-group">
			<div class="">First Name</div>
		@if(isset($create))
			<input type="text" name="first_name" class="form-control">
		@else
			<input type="text" name="first_name" class="form-control" value="{{$guest->first_name}}">
		@endif
		</div>
		<div class="form-group">
			<div class="">Last Name</div>
			@if(isset($create))
				<input type="text" name="last_name" class="form-control">
			@else
				<input type="text" name="last_name" class="form-control" value="{{$guest->last_name}}">
			@endif
		</div>
		<div class="form-group">
			<div class="">Email</div>
			@if(isset($create))
				<input type="email" name="email" class="form-control">
			@else
				<input type="email" name="email" class="form-control" value="{{$guest->email}}">
			@endif
		</div>
		<div class="form-group">
			<div class="">Phone</div>
			@if(isset($create))
				<input type="text" name="phone" class="form-control">
			@else
				<input type="text" name="phone" class="form-control" value="{{$guest->phone}}">
			@endif

		</div>
		<div class="form-group">
			<div class="">City</div>
			@if(isset($create))
				<input type="text" name="city" class="form-control">
			@else
				<input type="text" name="city" class="form-control" value="{{$guest->city}}">
			@endif
		</div>
		<div class="form-group">
			<div class="">Country</div>
			@if(isset($create))
				<input type="text" name="country" class="form-control">
			@else
				<input type="text" name="country" class="form-control" value="{{$guest->country}}">
			@endif
		</div>
		<input type="submit" name="submit" value="Submit">
	</form>
</div>
@endsection