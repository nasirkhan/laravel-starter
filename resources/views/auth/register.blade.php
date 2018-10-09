@extends('auth.layout')

@section('content')

<div class="page-header-image" style="background-image:url('img/cover-01.jpg')"></div>

<div class="content-center">
    <div class="container">

        @include('flash::message')
        <!-- Errors block -->
        @include('frontend.includes.errors')
        <!-- / Errors block -->

        <div class="col-md-4 content-center">
            <div class="card card-login card-plain">
                <form class="form" method="POST" action="{{ route('frontend.auth.register.post') }}">
                    {{ csrf_field() }}

                    <div class="header header-primary text-center">
                        <div class="logo-container">
                            <img src="img/login-logo.png" alt="">
                        </div>
                        <h5>
                            Create an Account
                        </h5>
                    </div>
                    <div class="content">
                        <div class="input-group mb-3 input-lg {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="input-name"><i class="fas fa-user"></i></span>
                            </div>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Full Name" aria-label="Name" aria-describedby="input-name" required>
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
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Password" aria-label="Password" aria-describedby="input-password_confirmation" required>
                        </div>
                    </div>
                    <div class="footer text-center">
                        <button type="submit" class="btn btn-primary btn-round btn-block">Create Account</button>
                    </div>
                    <div class="pull-left">
                        <h6>
                            <a href="{{ route('frontend.auth.login') }}" class="link">Login to Account</a>
                        </h6>
                    </div>
                    <div class="float-right">
                        <h6>
                            <a href="{{route('frontend.auth.password.email')}}" class="link">Need Help?</a>
                        </h6>
                    </div>
                </form>
            </div>

            @include('auth.social_login_buttons')
        </div>
    </div>
</div>

@endsection
