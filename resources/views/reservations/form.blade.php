@extends('layouts.app')

@section('content')

<div class="block">
	<div class="block-content block-content-narrow">
<h2>
	@if(isset($create))
		Add New Reservation
	@else
		Edit Reservation
	@endif
</h2>

<br/><br/>
<div class="pull-left">
	<a href="{{url('/reservations/calendar')}}" class="btn btn-sm btn-primary"><i class="fa fa-chevron-left"></i> Return</a>
</div>
<br/><br/>

	@if(isset($create))
		<form method="post" action="/reservations/store" class="form-horizontal push-10-t">
	@else
		<form method="post" action="/reservations/{{$reservation->id}}" class="form-horizontal push-10-t">
		{{ method_field('PUT')}}
	@endif
		{{ csrf_field() }}
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material">
					<select name="guest" class="form-control">
						<option value="">Select Reservation Guest</option>
						@if(isset($create))
							@foreach($all_guests as $guest)
							<option value="{{$guest->id}}">{{$guest->first_name.' '.$guest->last_name}}</option>
							@endforeach
						@else
							@foreach($all_guests as $guest)
							<option value="{{$guest->id}}" @if($reservation->guest->id == $guest->id) selected="selected" @endif>{{$guest->first_name.' '.$guest->last_name}}</option>
							@endforeach
						@endif
					</select>
				<label for="material-text2">Guest</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material">
					<select name="room" class="form-control">
						<option value="">Select Room To Be Reserved</option>
						@if(isset($create))
							@foreach($all_rooms->where('status',0) as $room)
							<option value="{{$room->id}}">{{$room->name}} - GH₵ {{$room->price}}</option>
							@endforeach
						@else
							@foreach($all_rooms->where('status',0) as $room)
							<option value="{{$room->id}}" @if($reservation->room->id == $room->id) selected="selected" @endif>{{$room->name}} - GH₵ {{$room->price}}</option>
							@endforeach
						@endif
					</select>
					<label for="material-text2">Room To Be Reserved</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					@if(isset($create))
						<input type="date" name="check_in" class="form-control">	
					@else
						<input type="date" name="check_in" class="form-control" value="{{$reservation->check_in}}">
					@endif
					<label for="material-text2">Check In Date</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					@if(isset($create))
						<input type="date" name="check_out" class="form-control">	
					@else
						<input type="date" name="check_out" class="form-control" value="{{$reservation->check_out}}">
					@endif
					<label for="material-text2">Check Out Date</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					@if(isset($create))
						<input type="number" name="adults" class="form-control">
					@else
						<input type="number" name="adults" class="form-control" value="{{$reservation->adults}}">
					@endif
						<label for="material-text2">Adults</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					@if(isset($create))
						<input type="number" name="children" class="form-control">
					@else
						<input type="number" name="children" class="form-control" value="{{$reservation->children}}">
					@endif
						<label for="material-text2">Children</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					<select name="status" class="form-control">
						@if(isset($create))
							<option value="0">Pending</option>
							<option value="1">Confirmed</option>
							<option value="2">Cancelled</option>
						@else
							<option value="0" @if($reservation->reservation_status == '0') selected="selected" @endif>Pending</option>
							<option value="1" @if($reservation->reservation_status == '1') selected="selected" @endif>Confirmed</option>
							<option value="2" @if($reservation->reservation_status == '2') selected="selected" @endif>Cancelled</option>
						@endif
					</select>
					<label for="material-text2">Reservation Status</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating input-group">
					@if(isset($create))
						<input type="number" name="discount" class="form-control">
					@else
						<input type="number" name="discount" class="form-control" value="{{$reservation->discount}}">
					@endif
						<label for="material-text2">Discount %</label>
                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-9">
				<button class="btn btn-sm btn-primary" type="submit">Submit</button>
			</div>
		</div>
	</form>
</div>
</div>
@endsection