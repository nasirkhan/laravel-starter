@extends('auth.layout')

@section('content')

<div class="page-header-image" style="background-image:url('{{asset('img/cover-01.jpg')}}')"></div>

<div class="content-center">
    <div class="container">

        <div class="col-md-4 content-center">
            <div class="card card-login card-plain mb-0">
                <form class="form" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="header header-primary text-center">
                        <h5>
                            Create an Account
                        </h5>

                        @include('flash::message')
                        <!-- Errors block -->
                        @include('frontend.includes.errors')
                        <!-- / Errors block -->

                    </div>
                    <div class="content">
                        <div class="input-group mb-3 input-lg {{ $errors->has('first_name') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input-first_name"><i class="fas fa-user"></i></span>
                            </div>
                            <input id="name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" aria-label="First Name" aria-describedby="input-first_name" required>
                        </div>

                        <div class="input-group mb-3 input-lg {{ $errors->has('last_name') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input-last_name"><i class="fas fa-user"></i></span>
                            </div>
                            <input id="name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" aria-label="Last Name" aria-describedby="input-last_name" required>
                        </div>

                        <div class="input-group mb-3 input-lg {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input-email"><i class="fas fa-at"></i></span>
                            </div>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email address" aria-label="Email" aria-describedby="input-email" required>
                        </div>

                        <div class="input-group mb-3 input-lg {{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input-password"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="input-password" required>
                        </div>

                        <div class="input-group mb-3 input-lg {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input-password_confirmation"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Password (Enter Again)" aria-label="Password" aria-describedby="input-password_confirmation" required>
                        </div>
                    </div>
                    <div class="footer text-center py-0">
                        <button type="submit" class="btn btn-primary btn-round btn-block">Create Account</button>
                    </div>
                    <div class="pull-left">
                        <h6>
                            <a href="{{ route('login') }}" class="link">Login to Account</a>
                        </h6>
                    </div>
                    @if (Route::has('password.request'))
                    <div class="float-right">
                        <h6>
                            <a class="link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </h6>
                    </div>
                    @endif
                </form>
            </div>

            {{-- @include('auth.social_login_buttons') --}}
        </div>
    </div>
</div>

@endsection
