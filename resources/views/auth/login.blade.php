@extends('layouts.app')

@section('content')

<!-- Login Content -->
<div class="bg-white pulldown">
        <div class="content content-boxed overflow-hidden">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <div class="push-30-t push-50 animated fadeIn">
                        <!-- Login Title -->
                        <div class="text-center">
                            <i class="fa fa-2x fa-terminal text-primary"></i>
                            <h1 class="h3 push-10-t">{{ __('Login') }}</h1>
                            <p class="text-muted push-15-t">Welcome... shall we begin?</p>
                        </div>
                        <!-- END Login Title -->

                        <!-- Login Form -->
                        <!-- jQuery Validation (.js-validation-login class is initialized in js/pages/base_pages_login.js) -->
                        <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <form class="js-validation-login form-horizontal push-30-t" action="{{ route('login') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        <label for="login-username">{{ __('E-Mail Address') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="form-material form-material-primary floating">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        <label for="login-password">{{ __('Password') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label class="css-input switch switch-sm switch-primary">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span></span> {{ __('Remember Me') }}?
                                    </label>
                                </div>
                                <div class="col-xs-6">
                                    <div class="font-s13 text-right push-5-t">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}?
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group push-30-t">
                                <div class="col-xs-12">
                                    <button class="btn btn-sm btn-block btn-primary" type="submit">{{ __('Login') }}</button>
                                </div>
                                <div class="col-xs-12">
                                    @if (Route::has('register'))
                                        <div class="font-s13 text-center push-5-t">
                                            Don't have an account? <a class="btn btn-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                        </form>
                        <!-- END Login Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Login Content -->
@endsection
