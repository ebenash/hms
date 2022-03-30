@extends('layouts.app')

@section('content')
<div class="block">
	<div class="block-content block-content-narrow">
<h2>
	@if(isset($create))
		Add New Guest
	@else
		Edit Guest
	@endif
</h2>

	@if(isset($create))
		<form method="post" action="/guests/store" class="form-horizontal push-10-t">
	@else
		<form method="post" action="/guests/{{$guest->id}}" class="form-horizontal push-10-t">
		{{ method_field('PUT')}}
	@endif
		{{ csrf_field() }}
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					@if(isset($create))
						<input type="text" name="first_name" class="form-control">
					@else
						<input type="text" name="first_name" class="form-control" value="{{$guest->first_name}}">
					@endif
				<label for="material-text2">First Name <p class="text-danger" style="display: inline-block;">*</p></label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					@if(isset($create))
						<input type="text" name="last_name" class="form-control">
					@else
						<input type="text" name="last_name" class="form-control" value="{{$guest->last_name}}">
					@endif
					<label for="material-text2">Last Name <p class="text-danger" style="display: inline-block;">*</p></label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					@if(isset($create))
						<input type="email" name="email" class="form-control">
					@else
						<input type="email" name="email" class="form-control" value="{{$guest->email}}">
					@endif
						<label for="material-text2">Email <p class="text-danger" style="display: inline-block;">*</p></label>
				</div>
			</div>
		</div>
		<div class="form-group">
		<div class="col-sm-9">
			<div class="form-material floating">
					@if(isset($create))
						<input type="text" name="phone" class="form-control">
					@else
						<input type="text" name="phone" class="form-control" value="{{$guest->phone}}">
					@endif
						<label for="material-text2">Phone <p class="text-danger" style="display: inline-block;">*</p></label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material floating">
					@if(isset($create))
						<input type="text" name="city" class="form-control">
					@else
						<input type="text" name="city" class="form-control" value="{{$guest->city}}">
					@endif
						<label for="material-text2">City</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-9">
				<div class="form-material">
					@if(isset($create))
						@include('includes.countries')
					@else
						<input class="js-autocomplete form-control" type="text" id="example-autocomplete2" name="country" placeholder="Countries.." value="{{$guest->country}}">
					@endif
						<label for="material-text2">Country</label>
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