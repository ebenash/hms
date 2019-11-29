@extends('layouts.app')

@section('content')

<div class="block">
	<div class="block-content block-content-narrow">
<h2>
	@if(isset($create))
		Add New Room
	@else
		Edit Room
	@endif
</h2>

	@if(isset($create))
		<form method="post" action="/rooms/store" class="form-horizontal push-10-t">
	@else
		<form method="post" action="/rooms/{{$room->id}}" class="form-horizontal push-10-t">
		{{ method_field('PUT')}}
	@endif
		{{ csrf_field() }}
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					@if(isset($create))
						<input type="text" name="name" class="form-control">
					@else
						<input type="text" name="name" class="form-control" value="{{$room->name}}">
					@endif
				<label for="material-text2">Room Name</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					@if(isset($create))
						<input type="text" name="price" class="form-control">
					@else
						<input type="text" name="price" class="form-control" value="{{$room->price}}">
					@endif
					<label for="material-text2">Price</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					<select name="type" class="form-control">
						@if(isset($create))
							@foreach($all_roomtypes as $roomtype)
							<option value="">Select Room Type</option>
							<option value="{{$roomtype->id}}">{{$roomtype->name}}</option>
							@endforeach
						@else
							@foreach($all_roomtypes as $roomtype)
							<option value="">Select Room Type</option>
							<option value="{{$roomtype->id}}" @if($room->room_type_id == $roomtype->id) selected="selected" @endif>{{$roomtype->name}}</option>
							@endforeach
						@endif
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
		<div class="col-sm-9">
			<div class="form-material floating">
					@if(isset($create))
						<input type="number" name="max_persons" class="form-control">
					@else
						<input type="number" name="max_persons" class="form-control" value="{{$room->max_persons}}">
					@endif
						<label for="material-text2">Max Persons</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					<select name="status" class="form-control">
						@if(isset($create))
							<option value="0">Available</option>
							<option value="1">Inactive</option>
						@else
							<option value="0" @if($room->status == '0') selected="selected" @endif>Available</option>
							<option value="1" @if($room->status == '1') selected="selected" @endif>Inactive</option>
						@endif
					</select>
					<label for="material-text2">Room Status</label>
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