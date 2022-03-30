@extends('layouts.simple')

@section('content')



    <div class="bg-image" style="background-image: url('/media/photos/photo28@2x.jpg');">
        <div class="row no-gutters bg-primary-dark-op">
            <!-- Meta Info Section -->
            <div class="hero-static col-lg-4 d-none d-lg-flex flex-column justify-content-center">
                <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                    <div class="w-100">
                        <a class="link-fx font-w600 font-size-h2 text-white" href="{{url('/')}}">
                            <img src="{{route('hms-uploads-file',($main_company->logo ?? 'mist_logo.jpeg'))}}" height="70px"/>
                        </a>
                        <p class="text-white-75 mt-2">
                            Welcome to your hotel portal. Feel free to login and start managing your hotel.
                        </p>
                    </div>
                </div>
                <div class="p-4 p-xl-5 d-xl-flex justify-content-between align-items-center font-size-sm">
                    <p class="font-w500 text-white-50 mb-0">
                        <strong>{{ config('app.name', 'Genio Hotel Management System') }}</strong> &copy; <span data-toggle="year-copy"></span>
                    </p>
                    {{-- <ul class="list list-inline mb-0 py-2">
                        <li class="list-inline-item">
                            <a class="text-white-75 font-w500" href="javascript:void(0)">Legal</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-white-75 font-w500" href="javascript:void(0)">Contact</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-white-75 font-w500" href="javascript:void(0)">Terms</a>
                        </li>
                    </ul> --}}
                </div>
            </div>
            <!-- END Meta Info Section -->

            <!-- Main Section -->
            <div class="hero-static col-lg-8 d-flex flex-column align-items-center bg-white">
                <div class="p-3 w-100 d-lg-none text-center">
                    <a class="link-fx font-w600 font-size-h3 text-dark" href="{{url('/')}}">
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
                                Sign In
                            </h1>
                            <h2 class="font-size-base text-muted">
                                Welcome, please login to begin.
                            </h2>
                        </div>
                        <!-- END Header -->

                        <!-- Sign In Form -->
                        <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js) -->
                        <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <div class="row no-gutters justify-content-center">
                            <div class="col-sm-8 col-xl-4">
                                <form class="js-validation-signin form-horizontal push-30-t" action="{{ route('login') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg form-control-alt py-4 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg form-control-alt py-4 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="d-md-flex align-items-md-center justify-content-md-between">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="text-muted custom-control-label font-w400" for="remember">{{ __('Remember Me') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-between align-items-center">
                                        @if (Route::has('password.request'))
                                            <div>
                                                <a class="text-muted font-size-sm font-w500 d-block d-lg-inline-block mb-1" href="{{ route('password.request') }}">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        @endif
                                        <div>
                                            <button type="submit" class="btn btn-lg btn-alt-primary">
                                                <i class="fa fa-fw fa-sign-in-alt mr-1 opacity-50"></i> Sign In
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <div class="col-xs-12">
                                    @if (Route::has('register'))
                                        <div class="text-muted font-s13 text-center push-5-t">
                                            Don't have an account? <a class="btn btn-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- END Sign In Form -->
                    </div>
                </div>
                <div class="px-4 py-3 w-100 d-lg-none d-flex flex-column flex-sm-row font-size-sm text-center">
                    <p class="font-w500 text-black-50 py-2 mb-0">
                        <strong>{{ config('app.name', 'Genio Hotel Management System') }}</strong> &copy; <span data-toggle="year-copy"></span>
                    </p>
                    {{-- <ul class="list list-inline py-2 mb-0">
                        <li class="list-inline-item">
                            <a class="text-muted font-w500" href="javascript:void(0)">Legal</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-muted font-w500" href="javascript:void(0)">Contact</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-muted font-w500" href="javascript:void(0)">Terms</a>
                        </li>
                    </ul> --}}
                </div>
            </div>
            <!-- END Main Section -->
        </div>
    </div>
@endsection
