@extends('layouts.app')

@section('content')
<div class="block-content">

<h2>Guest Information</h2>
<div><a href="/reservations" class="btn btn-primary">Go Back</a></div>
<br>
<div>
	<div class="form-group">
		<div class="">Guest Name: <b>{{$reservation->guest->first_name.' '.$reservation->guest->last_name}}</b></div>
	</div>
	<div class="form-group">
		<div class="">Room: <b>{{$reservation->room->name}}</b></div>
	</div>
	<div class="form-group">
		<div class="">Check In: <b>{{$reservation->check_in}}</b></div>
	</div>
	<div class="form-group">
		<div class="">Check Out: <b>{{$reservation->check_out}}</b></div>
	</div>
	<div class="form-group">
		<div class="">Adults: <b>{{$reservation->adults}}</b></div>
	</div>
	<div class="form-group">
		<div class="">Children: <b>{{$reservation->children}}</b></div>
	</div>
	<div class="form-group">
		<div class="">Reservation Status: <b> @if($reservation->reservation_status == 1) <span class="label label-success">Confirmed</span>  @elseif($reservation->reservation_status == 0) <span class="label label-warning">Pending</span> @else <span class="label label-danger">Cancelled</span> @endif </b></div>
	</div>
</div>
</div>

@endsection