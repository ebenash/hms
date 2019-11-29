@extends('layouts.app')

@section('content')

<!-- Reminder Content -->
<div class="bg-white pulldown">
        <div class="content content-boxed overflow-hidden">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <div class="push-30-t push-20 animated fadeIn">
                        <!-- Reminder Title -->
                        <div class="text-center">
                            <i class="fa fa-2x fa-terminal text-primary"></i>
                            <h1 class="h3 push-10-t">{{ __('Reset Password') }}</h1>
                            <p class="text-muted push-15-t">Don’t worry, we’ll send a reset link to you.</p>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="js-validation-reminder form-horizontal push-30-t" action="{{ route('password.email') }}" method="post">
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
                                        <label for="reminder-email">Enter Your {{ __('E-Mail Address') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                                    <button class="btn btn-sm btn-block btn-primary" type="submit">{{ __('Send Password Reset Link') }}</button>
                                </div>
                            </div>
                        </form>
                        <!-- END Reminder Form -->

                        <!-- Extra Links -->
                        <div class="text-center push-50-t">
                        <a href="{{route('login')}}">Login?</a>
                        </div>
                        <!-- END Extra Links -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Reminder Content -->

@endsection
