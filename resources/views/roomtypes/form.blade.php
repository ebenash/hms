@extends('layouts.app')

@section('content')
<h2>
	@if(isset($create))
		Add New Room Type
	@else
		Edit Room Type
	@endif
</h2>

<div>
	@if(isset($create))
		<form method="post" action="/roomtypes/store">
	@else
		<form method="post" action="/roomtypes/{{$roomtype->id}}">
		{{ method_field('PUT')}}
	@endif
		{{ csrf_field() }}
		<div class="form-group">
			<div class="">Room Type Name</div>
		@if(isset($create))
			<input type="text" name="name" class="form-control">
		@else
			<input type="text" name="name" class="form-control" value="{{$roomtype->name}}">
		@endif
		</div>
		
		<input type="submit" name="submit" value="Submit">
	</form>
</div>
@endsection