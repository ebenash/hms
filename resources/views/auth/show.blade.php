@extends('layouts.app')

@section('content')
<?php //die(var_dump($current_user)); ?>
<div class="content content-boxed">
	<!-- User Header -->
	<div class="block">
		<!-- Basic Info -->
		<div class="bg-image" style="background-image: url('{{ asset('assets/img/photos/photo3@2x.jpg')}}');">
			<div class="block-content bg-primary-op text-center overflow-hidden">
				<div class="push-30-t push animated fadeInDown">
					<img class="img-avatar img-avatar96 img-avatar-thumb" src="{{ asset('assets/img/avatars/avatar10.jpg')}}" alt="">
				</div>
				<div class="push-30 animated fadeInUp">
				<h2 class="h4 font-w600 text-white push-5">{{$profile->name}}</h2>
					<h3 class="h5 text-white-op">{{$profile->title}}</h3>
					<h4 class="h5 text-white-op">{{$profile->company->name}}</h4>
				</div>
			</div>
		</div>
		<!-- END Basic Info -->
	</div>
	<!-- END User Header -->

	<!-- Main Content -->
	<div class="block">
		<ul class="nav nav-tabs nav-justified push-20" data-toggle="tabs">
			<li class="active">
				<a href="#tab-profile-personal"><i class="fa fa-fw fa-pencil"></i> Personal</a>
			</li>
			<li class="">
				<a href="#tab-profile-password"><i class="fa fa-fw fa-asterisk"></i> Password</a>
			</li>
		</ul>
		<div class="block-content tab-content">
			<!-- Personal Tab -->
			<div class="tab-pane fade active in" id="tab-profile-personal">
				<form class="js-validation-register form-horizontal push-50-t push-50" action="{{ url('/users').'/'.$profile->id }}" method="post">
					{{ method_field('PUT')}}
					@csrf
					<div class="row items-push">
						<div class="col-sm-6 col-sm-offset-3 form-horizontal">
							<div class="form-group">
								<div class="col-xs-12">
									<label>User Role</label>
									<select id="role_id" type="displayed_role_id" class="form-control input-lg" name="displayed_role_id" disabled >
										<option value="">Select Role</option>
										@foreach($all_roles as $role)
										<option value="{{$role->id}}" @if($profile->role->id == $role->id) selected="selected" @endif>{{$role->role_name}}</option>
										@endforeach
									</select>
									<input type="hidden" name="role_id" value="{{$profile->role->id}}"/>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="name">Full Name</label>
									<input class="form-control input-lg" type="name" id="name" name="name" placeholder="Enter your Full Name.." value="{{$profile->name}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<label for="title">Job Title</label>
									<input class="form-control input-lg" type="title" id="title" name="title" placeholder="Enter your Job Title.." value="{{$profile->title}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6">
									<label for="phone">Phone</label>
									<input class="form-control input-lg" type="text" id="phone" name="phone" placeholder="Enter your phone number.." value="{{$profile->phone}}">
								</div>
								<div class="col-xs-6">
									<label for="email">Email Address</label>
									<input class="form-control input-lg" type="email" id="email" name="email" placeholder="Enter your email.." value="{{$profile->email}}" disabled>
								</div>
							</div>
							
						</div>
					</div>
					<div class="block-content block-content-full bg-gray-lighter text-center">
						<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check push-5-r"></i> Save Changes</button>
					</div>
				</form>
			</div>
			<!-- END Personal Tab -->

			<!-- Password Tab -->
			<div class="tab-pane fade" id="tab-profile-password">
				<form class="js-validation-register form-horizontal push-50-t push-50" action="{{ url('/user/password').'/'.$profile->id }}" method="post">
					{{ method_field('PUT')}}
					@csrf
				<div class="row items-push">
					<div class="col-sm-6 col-sm-offset-3 form-horizontal">
						<div class="form-group">
							<div class="col-xs-12">
								<label for="password-old">Current Password</label>
								<input id="password-old" type="password" class="form-control input-lg @error('password-old') is-invalid @enderror" name="password-old" required autocomplete="password-old" placeholder="Enter your current password..">

									@error('password-old')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
							</div>
						</div>
						<hr>
						<div class="form-group">
							<div class="col-xs-12">
								<label for="password">New Password</label>
								<input id="password" type="password" class="form-control input-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Choose a strong password..">

									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<label for="password-new-confirm">Confirm New Password</label>
								<input id="password-confirm" type="password" class="form-control input-lg" name="password_confirmation" required autocomplete="new-password" placeholder="..and confirm it">
							</div>
						</div>
					</div>
				</div>
				<div class="block-content block-content-full bg-gray-lighter text-center">
					<button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check push-5-r"></i> Save Changes</button>
				</div>
				</form>
			</div>
			<!-- END Password Tab -->
		</div>
	</div>
	<!-- END Main Content -->
</div>
@endsection