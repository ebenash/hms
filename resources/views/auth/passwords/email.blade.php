@extends('layouts.simple')

@section('content')

    <!-- Page Content -->
    <div class="bg-primary">
        <div class="row no-gutters bg-primary-dark-op">
            <!-- Meta Info Section -->
            <div class="hero-static col-lg-4 d-none d-lg-flex flex-column justify-content-center">
                <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                    <div class="w-100">
                        <a class="link-fx font-w600 font-size-h2 text-white" href="{{url('/')}}">
                            <img src="{{route('hms-uploads-file',($main_company->logo ?? 'mist_logo.jpeg'))}}" height="70px"/>
                        </a>
                        <p class="text-white-75 mt-2">
                            Don’t worry, we’ve got your back. We’ll send a reset link to you!
                        </p>
                    </div>
                </div>
                <div class="p-4 p-xl-5 d-xl-flex justify-content-between align-items-center font-size-sm">
                    <p class="font-w500 text-white-50 mb-0">
                        <strong>{{ config('app.name', 'Genio Hotel Management System') }}</strong> &copy; <span data-toggle="year-copy"></span>
                    </p>
                </div>
            </div>
            <!-- END Meta Info Section -->

            <!-- Main Section -->
            <div class="hero-static col-lg-8 d-flex flex-column align-items-center bg-white">
                <div class="p-3 w-100 d-lg-none text-center">
                    <a class="link-fx font-w600 font-size-h3 text-dark" href="index.html">
                        <img src="{{route('hms-uploads-file',($main_company->logo ?? 'mist_logo.jpeg'))}}" height="50px"/>
                    </a>
                </div>
                <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                    <div class="w-100">
                        <!-- Header -->
                        <div class="text-center mb-5">
                            <p class="mb-3">
                                <i class="fa fa-2x fa-terminal text-primary-light"></i>
                            </p>
                            <h1 class="font-w700 mb-2">
                                Password Reset
                            </h1>
                            <h2 class="font-size-base text-muted">
                                Please provide your account’s email and we will send you a link to reset your password.
                            </h2>
                        </div>
                        <!-- END Header -->

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <!-- Reminder Form -->
                        <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/op_auth_reminder.min.js which was auto compiled from _js/pages/op_auth_reminder.js) -->
                        <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <div class="row no-gutters justify-content-center">
                            <div class="col-sm-8 col-xl-4">
                                <form class="js-validation-reminder form-horizontal push-30-t" action="{{ route('password.email') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg form-control-alt py-4 @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group text-center mb-0">
                                        <button type="submit" class="btn btn-lg btn-alt-primary">
                                            <i class="fa fa-fw fa-envelope mr-1 opacity-50"></i> {{ __('Send Password Reset Link') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END Reminder Form -->
                    </div>
                </div>
                <div class="px-4 py-3 w-100 d-lg-none d-flex flex-column flex-sm-row justify-content-between font-size-sm text-center text-sm-left">
                    <p class="font-w500 text-black-50 py-2 mb-0">
                        <strong>{{ config('app.name', 'Genio Hotel Management System') }}</strong> &copy; <span data-toggle="year-copy"></span>
                    </p>
                </div>
            </div>
            <!-- END Main Section -->
        </div>
    </div>
    <!-- END Page Content -->

@endsection
