@extends('layouts.app')

@section('content')

<div class="block">
	<div class="block-content block-content-narrow">
<h2>View Reservation Details</h2>
	<br/><br/>
	<div class="pull-left">
	<a href="{{url('/reservations/calendar')}}" class="btn btn-sm btn-primary"><i class="fa fa-chevron-left"></i> Return</a>
	</div>
	<br/><br/>
	<form class="form-horizontal push-10-t">
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material">
					<select name="guest" class="form-control" disabled>
						<option value="">Select Reservation Guest</option>
							@foreach($all_guests as $guest)
							<option value="{{$guest->id}}" @if($reservation->guest->id == $guest->id) selected="selected" @endif>{{$guest->full_name}}</option>
							@endforeach
					</select>
				<label for="material-text2">Guest</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material">
					<select name="room" class="form-control" disabled>
						<option value="">Select Room To Be Reserved</option>
							@foreach($all_rooms as $room)
							<option value="{{$room->id}}" @if(($reservation->room->id ?? null) == $room->id) selected="selected" @endif>{{$room->name}} - GH₵ {{$room->price}}</option>
							@endforeach
					</select>
					<label for="material-text2">Room To Be Reserved</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					<input type="text" name="check_in" class="form-control" value="{{date_format(new DateTime($reservation->check_in), 'l jS F Y')}}" disabled>
					<label for="material-text2">Check In Date</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					<input type="text" name="check_out" class="form-control" value="{{date_format(new DateTime($reservation->check_out), 'l jS F Y')}}" disabled>
					<label for="material-text2">Check Out Date</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					<input type="number" name="adults" class="form-control" value="{{$reservation->adults}}" disabled>
					<label for="material-text2">Adults</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					<input type="number" name="children" class="form-control" value="{{$reservation->children}}" disabled>
					<label for="material-text2">Children</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					<select name="status" class="form-control" disabled>
						<option value="0" @if($reservation->reservation_status == '0') selected="selected" @endif>Pending</option>
						<option value="1" @if($reservation->reservation_status == '1') selected="selected" @endif>Confirmed</option>
						<option value="2" @if($reservation->reservation_status == '2') selected="selected" @endif>Cancelled</option>
					</select>
					<label for="material-text2">Reservation Status</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					<input type="number" name="rooprice" class="form-control" value="{{$reservation->room->price ?? ''}}" disabled>
					<label for="material-text2">Room Price</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating input-group">
					<input type="number" name="discount" class="form-control" value="{{$reservation->discount}}" disabled>
					<label for="material-text2">Discount %</label>
					<span class="input-group-addon"><i class="fa fa-percent"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating input-group">
					<span class="input-group-addon">GHS</span>
					<input type="number" name="price" class="form-control" value="{{$reservation->price}}" disabled>
					<label for="material-text2">Total Amount</label>
				</div>
			</div>
		</div>
	</form>
	</div>
</div>
@endsection
