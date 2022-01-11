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
					<select class="js-select2 form-control" id="guest" style="width: 100%;" data-placeholder="Select Reservation Guest.." name="guest">
						<option></option>
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
				<label for="material-text2">Guest <p class="text-danger" style="display: inline-block;">*</p></label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material">
					<select class="js-select2 form-control" id="room" style="width: 100%;" data-placeholder="Select Room To Be Reserved.." name="room">
						<option></option>
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
					<label for="material-text2">Room <p class="text-danger" style="display: inline-block;">*</p></label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="js-datepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="false">
					@if(isset($create))
						<input class="js-datepicker form-control" type="text" id="check_in" name="check_in" placeholder="Choose check-in date..">	
					@else
						<input class="js-datepicker form-control" type="text" id="check_in" name="check_in" placeholder="Choose check-in date.." value="{{date_format(date_create($reservation->check_in),'m/d/Y')}}">
					@endif
					<label for="material-text2">Check In Date <p class="text-danger" style="display: inline-block;">*</p></label>
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="js-datepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="false">
					@if(isset($create))
						<input class="js-datepicker form-control" type="text" id="check_out" name="check_out" placeholder="Choose check-in date..">	
					@else
						<input class="js-datepicker form-control" type="text" id="check_out" name="check_out" placeholder="Choose check-in date.." value="{{date_format(date_create($reservation->check_out),'m/d/Y')}}">
					@endif
					<label for="material-text2">Check Out Date <p class="text-danger" style="display: inline-block;">*</p></label>
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material">
					<select class="js-select2 form-control" id="adults" style="width: 100%;" data-placeholder="Select Number of Adults.." name="adults">
                    <option></option>
					@if(isset($create))
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					@else
						<option value="1" @if($reservation->adults == '1') selected="selected" @endif>1</option>
						<option value="2" @if($reservation->adults == '2') selected="selected" @endif>2</option>
						<option value="3" @if($reservation->adults == '3') selected="selected" @endif>3</option>
						<option value="4" @if($reservation->adults == '4') selected="selected" @endif>4</option>
						<option value="5" @if($reservation->adults == '5') selected="selected" @endif>5</option>
					@endif
					</select>
					<label for="material-text2">Adults <p class="text-danger" style="display: inline-block;">*</p></label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material">
					<select class="js-select2 form-control" id="children" style="width: 100%;" data-placeholder="Select Number of Children.." name="children" required>
                    <option></option>
					@if(isset($create))
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
					@else
						<option value="0" @if($reservation->children == '0') selected="selected" @endif>0</option>
						<option value="1" @if($reservation->children == '1') selected="selected" @endif>1</option>
						<option value="2" @if($reservation->children == '2') selected="selected" @endif>2</option>
						<option value="3" @if($reservation->children == '3') selected="selected" @endif>3</option>
						<option value="4" @if($reservation->children == '4') selected="selected" @endif>4</option>
						<option value="5" @if($reservation->children == '5') selected="selected" @endif>5</option>
						<option value="6" @if($reservation->children == '6') selected="selected" @endif>6</option>
					@endif
					</select>
					<label for="material-text2">Children <p class="text-danger" style="display: inline-block;">*</p></label>
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
					<label for="material-text2">Reservation Status <p class="text-danger" style="display: inline-block;">*</p></label>
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