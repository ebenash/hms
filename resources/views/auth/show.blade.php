@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-image" style="background-image: url('/homepage/assets/img/reh/MG_8094.jpg');">
    <div class="bg-black-75">
        <div class="content content-full text-center">
            <div class="my-3">
                <img class="img-avatar img-avatar-thumb" src="{{asset('/media/avatars/avatar13.jpg')}}" alt="">
            </div>
            <h1 class="h2 text-white mb-0">{{$profile->name}}</h1>
            <h2 class="h4 font-w400 text-white-75">
                {{$profile->title}}
            </h2>
            <h4 class="h4 font-w400 text-white-75">{{$profile->company->name}}</h4>
        </div>
    </div>
</div>
<!-- END Hero -->

<!-- Page Content -->
<div class="content content-boxed">
    <!-- User Profile -->
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">User Profile</h3>
        </div>
        <div class="block-content">
            <form class="js-validation-register form-horizontal push-50-t push-50" action="{{ route('user-profile-update',$profile->id) }}" method="post">
                {{ method_field('PUT')}}
                @csrf
                <div class="row items-push">
                    <div class="col-lg-4">
                        <p class="font-size-sm text-muted">
                            Your account’s vital info. Your data will be publicly visible.
                        </p>
                    </div>
                    <div class="col-sm-6 col-sm-offset-3 form-horizontal">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label>User Role</label>
                                <select id="role_id" type="displayed_role_id" class="form-control input-lg" name="displayed_role_id" disabled >
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}" {{$profile->hasRole($role->name) ? 'selected' : ''}}>{{ucfirst($role->name)}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="role_id" value="{{implode(', ',json_decode($profile->getRoleNames()))}}"/>
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

                        <div class="form-group">
                            <button type="submit" class="btn btn-alt-primary">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END User Profile -->

    <!-- Change Password -->
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">Change Password</h3>
        </div>
        <div class="block-content">
            <form class="js-validation-register form-horizontal push-50-t push-50" action="{{ route('user-password-update',$profile->id) }}" method="post">
                {{ method_field('PUT')}}
                @csrf

                <div class="row push">
                    <div class="col-lg-4">
                        <p class="font-size-sm text-muted">
                            Changing your sign in password is an easy way to keep your account secure.
                        </p>
                    </div>
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

                        <div class="form-group">
                            <button type="submit" class="btn btn-alt-primary">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Change Password -->
@endsection
