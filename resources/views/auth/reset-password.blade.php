@extends('auth.layout')

@section('title') @lang('Reset Password') @endsection

@section('content')

<div class="main-content">

    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-6">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <h1 class="text-white">
                            @lang('Reset Password')
                        </h1>
                        <p class="text-lead text-white">
                            @lang("Enter your email address and set new password.")
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <div class="container mt--9 pb-5">

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card bg-secondary border border-soft">

                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small></small>
                        </div>

                        @include('flash::message')

                        @if ($errors->any())
                        <!-- Validation Errors -->
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <p>
                                <i class="fas fa-exclamation-triangle"></i> @lang('Please fix the following errors & try again!')
                            </p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <form class="form" method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

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

                                <div class="input-group mb-3 {{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="input-email"><i class="fas fa-at"></i></span>
                                    </div>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $email ?? old('email') }}" placeholder="{{ __('Email Address') }}" aria-label="Email" aria-describedby="input-email" required>
                                </div>

                                <div class="input-group mb-3 {{ $errors->has('password') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="input-password"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" placeholder="{{ __('Password') }}" aria-label="{{ __('Password') }}" aria-describedby="input-password" required autocomplete="new-password">
                                </div>

                                <div class="input-group mb-3 {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="input-password_confirmation"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" aria-label="{{ __('Confirm Password') }}" aria-describedby="input-password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="footer text-center py-0">
                                <button type="submit" class="btn btn-primary btn-round btn-block">{{ __('Reset Password') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    @if (Route::has('register'))
                    <div class="col-6 text-left">
                        <a href="{{ route('register') }}" class="text-gray">
                            <small>Create new account</small>
                        </a>
                    </div>
                    @endif

                    <div class="col-6 text-right">
                        <a href="{{ route('login') }}" class="text-gray">
                            <small>Login to account</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
