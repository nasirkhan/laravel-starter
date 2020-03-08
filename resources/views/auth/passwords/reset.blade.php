@extends('auth.layout')

@section('content')

<div class="page-header-image" style="background-image:url('{{asset('img/cover-01.jpg')}}')"></div>

<div class="content-center">
    <div class="container">

        <div class="col-md-4 content-center">
            <div class="card card-login card-plain mb-0">
                <form class="form" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="header header-primary text-center">
                        <h5>
                            {{ __('Reset Password') }}
                        </h5>

                        @include('flash::message')
                        <!-- Errors block -->
                        @include('frontend.includes.errors')
                        <!-- / Errors block -->

                    </div>
                    <div class="content">

                        <div class="input-group mb-3 input-lg {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input-email"><i class="fas fa-at"></i></span>
                            </div>
                            <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" placeholder="{{ __('Email Address') }}" aria-label="Email" aria-describedby="input-email" required>
                        </div>

                        <div class="input-group mb-3 input-lg {{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input-password"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="input-password" required autocomplete="new-password">
                        </div>

                        <div class="input-group mb-3 input-lg {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input-password_confirmation"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" aria-label="Password" aria-describedby="input-password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="footer text-center py-0">
                        <button type="submit" class="btn btn-primary btn-round btn-block">{{ __('Reset Password') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
